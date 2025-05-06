import numpy as np
import faiss
import sys
import io
import os
import shutil
from fastapi import Request, HTTPException
from fastapi import FastAPI, UploadFile, File, Form
from fastapi.middleware.cors import CORSMiddleware
from langchain_community.document_loaders import PyPDFLoader, TextLoader
from langchain_text_splitters import RecursiveCharacterTextSplitter
from langchain_openai import ChatOpenAI
from langchain_core.prompts import ChatPromptTemplate
from langchain.chains import LLMChain  # import LLMChain for chaining
from langchain_core.pydantic_v1 import BaseModel, Field
import re
import logging
import psycopg2
from google import genai
from google.genai import types
from fastapi.responses import Response
# from starlette.middleware.trustedhost import TrustedHostMiddleware
# from starlette.middleware.proxy_headers import ProxyHeadersMiddleware
# from starlette.middleware.base import BaseHTTPMiddleware
import httpx
from fastapi.responses import JSONResponse
import json

from api_backend_rag_compliment import chat_with_bot_structured_compliment, chat_with_bot_structured_2_compliment, chat_with_bot_structured_3_compliment, chat_with_bot_structured_4_compliment, chat_with_bot_structured_5_compliment
from llm_backend import chat_llm

app = FastAPI()

logging.basicConfig(level=logging.INFO, format='%(asctime)s - %(name)s - %(levelname)s - %(message)s')
logger = logging.getLogger(__name__)
# Allow frontend to connect
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# class ReverseProxyMiddleware(BaseHTTPMiddleware):
#     async def dispatch(self, request: Request, call_next):
#         """
#         Route traffic:
#         - `/api/*` → FastAPI Backend (http://127.0.0.1:5000)
#         - Everything else → Laravel Backend (http://127.0.0.1:9000)
#         """
#         target_url = "http://127.0.0.1:5000" if request.url.path.startswith("/api/") else "http://127.0.0.1:9000"

#         async with httpx.AsyncClient() as client:
#             forwarded_response = await client.request(
#                 method=request.method,
#                 url=f"{target_url}{request.url.path}",
#                 headers=request.headers.raw,
#                 content=await request.body(),
#                 timeout=300  # Set timeout for file uploads
#             )

#         return Response(content=forwarded_response.content, status_code=forwarded_response.status_code, headers=dict(forwarded_response.headers))

# app.add_middleware(ReverseProxyMiddleware)

@app.middleware("http")
async def limit_upload_size(request: Request, call_next):
    max_size = 100 * 1024 * 1024  # 100MB
    if request.headers.get("content-length") and int(request.headers["content-length"]) > max_size:
        return HTTPException(status_code=413, detail="File too large")
    return await call_next(request)

@app.post("/api/data-chatbot") #/data-chatbot
async def data_chatbot(message: str = Form(...)):
    with open("public/columns.json", "r") as f:
        data = json.load(f)

    output = chat_llm(message, data)

    return {"reply": f"{output}"}

UPLOAD_DIR = "uploads"
os.makedirs(UPLOAD_DIR, exist_ok=True)

# Load GloVe embeddings
GLOVE_PATH = "glove.6B.300d.txt"
EMBEDDING_DIM = 300

def load_glove_embeddings(glove_path):
    """Loads GloVe embeddings into a dictionary"""
    glove_embeddings = {}
    with open(glove_path, "r", encoding="utf-8") as f:
        for line in f:
            values = line.split()
            word = values[0]
            vector = np.asarray(values[1:], dtype="float32")
            glove_embeddings[word] = vector
    return glove_embeddings

# Load embeddings at startup
glove_embeddings = load_glove_embeddings(GLOVE_PATH)

# FAISS index (stores vector embeddings)
faiss_index = None
document_chunks = []  # Stores text chunks for retrieval



def get_sentence_embedding(sentence, glove_embeddings):
    """Convert a sentence to a vector by averaging word vectors"""
    words = sentence.split() ## EXAMINE THIS LINE
    valid_vectors = [glove_embeddings[word] for word in words if word in glove_embeddings]
    if not valid_vectors:
        return np.zeros(EMBEDDING_DIM)
    return np.mean(valid_vectors, axis=0)



def process_and_store_file(file_path: str):
    """Reads a file, splits into chunks, and stores embeddings in FAISS"""
    global faiss_index, document_chunks

    loader = PyPDFLoader(file_path) if file_path.endswith(".pdf") else TextLoader(file_path)
    docs = loader.load()
    #full_text = "\n\n".join([doc.page_content for doc in docs])
    # Split document into smaller chunks
    text_splitter = RecursiveCharacterTextSplitter(chunk_size = 1300, chunk_overlap = 190, length_function = len, separators=["\n\n", " ", "\n"])
    chunks = text_splitter.split_documents(docs)  ##
    document_chunks = chunks

    # Convert chunks to vectors
    vectors = np.array([get_sentence_embedding(str(chunk), glove_embeddings) for chunk in chunks], dtype=np.float32)
    # Create FAISS index
    
    faiss_index = faiss.IndexFlatL2(EMBEDDING_DIM) 
    faiss_index.add(vectors)


    # async def upload_file(file: UploadFile = File(...)):
    #     file_path = os.path.join(UPLOAD_DIR, file.filename)
    #     with open(file_path, "wb") as buffer:
    #         shutil.copyfileobj(file.file, buffer)
    #
    #     process_and_store_file(file_path)
    #
    #     return {"success": True, "message": "File uploaded and processed successfully"}

@app.post("/api/save_data")
async def save_data(request: Request):
    data = await request.json()
    file_path = os.path.join(os.getcwd(), "study_data.json")
    try:
        with open(file_path, "w") as f:
            json.dump(data, f, indent=2)
        return JSONResponse(content={"status": "success", "file_path": file_path})
    except Exception as e:
        return JSONResponse(content={"status": "error", "message": str(e)}, status_code=200)


@app.post("/api/clear_saved_data")
async def clear_saved_data():
    file_path = os.path.join(os.getcwd(), "study_data.json")

    try:
        with open(file_path, "w") as f:
            json.dump({}, f, indent=2)
        return JSONResponse(content={"status": "success", "message": "File cleared"})
    except Exception as e:
        return JSONResponse(content={"status": "error", "message": str(e)}, status_code=200)


@app.post("/api/rag-upload")
async def upload_file(file: UploadFile = File(...)):
    try:
        file_path = os.path.join(UPLOAD_DIR, file.filename)
        with open(file_path, "wb") as buffer:
            shutil.copyfileobj(file.file, buffer)

        process_and_store_file(file_path)
        logger.info(f"File uploaded and processed successfully: {file.filename}")
        return {"success": True, "message": "File uploaded and processed successfully"}
    except Exception as e:
        logger.error(f"Error uploading file: {e}")
        return {"success": False, "message": "Error uploading file"}



@app.post("/api/rag-upload-2") #/rag-upload-2
async def upload_file2(file: UploadFile = File(...)):
    file_path = os.path.join(UPLOAD_DIR, file.filename)
    with open(file_path, "wb") as buffer:
        shutil.copyfileobj(file.file, buffer)

    process_and_store_file(file_path)

    return {"success": True, "message": "File uploaded and processed successfully"}



def return_template() -> str:
    PROMPT_TEMPLATE = """
You are a helpful retrieval-augmented assistant.
Below is some context retrieved for you. Answer the user’s question formally, using the provided context.
Do *NOT* make up anything beyond the retrieved context.
Please ensure that your answer is composed of one or more complete sentences.

CONTEXT:
{context}

USER QUESTION:
{question}

ASSISTANT:
"""
    return PROMPT_TEMPLATE


"""class AnswerWithSources(BaseModel):
    answer: str = Field(description="Answer to question")
    sources: str = Field(description="Full direct text chunk from the context used to answer the question")
    reasoning: str = Field(description="Explain the reasoning of the answer based on the sources")

class ExtractedInfo(BaseModel):
    paper_title: AnswerWithSources
    paper_summary: AnswerWithSources
    publication_year: AnswerWithSources
    paper_authors: AnswerWithSources
"""
JSON_DEFAULT_PATH = "/home/sdp/laravel-app/public"

@app.post("api/chatbot")
async def chat_with_bot(message: str = Form(...), k: int = 5):
    CHATGPT_APIKEY = "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"
    llm = ChatOpenAI(model = "gpt-4o-mini", api_key = CHATGPT_APIKEY, temperature = 0.5, max_tokens = 400)

    template = return_template() # get the template.
    prompt_template = ChatPromptTemplate.from_template(template)

    if faiss_index is None or not document_chunks:
        return {"reply": "RAG system not initialized. Upload a document first."}

    # Convert message to embedding
    #message = "What is the content of the paper?"
    query_vector = np.array([get_sentence_embedding(message, glove_embeddings)], dtype=np.float32)

    # Retrieve top-k relevant chunks
    _, indices = faiss_index.search(query_vector, k)
    best_matches = "\n\n---\n\n".join([str(document_chunks[idx]) for idx in indices[0]])

    prompt = prompt_template.format(context = best_matches, question = message)

    ### this is where we need to connect to our model.
    output = llm.invoke(prompt).content # the output where we'll have to restructure our text a bit.
    output = output.replace(".", ".\n")
    return {"reply": f"Based on your query, here’s what I found:\n\n{output}"}


@app.post("/api/simultaneous_generate_text") 
async def simultaneous_generate_text():
    answer_1 = chat_with_bot_structured()
    answer_2 = chat_with_bot_structured_2() 
    answer_3 = chat_with_bot_structured_3() 
    answer_4 = chat_with_bot_structured_4() 
    answer_5 = chat_with_bot_structured_5()

    logger.info("Processed the answers")
    # "subject_areas": answer_2, "experimental_groups": answer_4,
    collection_answer = {"study_information": answer_1, "subject_areas": answer_2, "investigators":answer_3, "experimental_groups": answer_4, "phenotype_analysis": answer_5}

    with open(f"{JSON_DEFAULT_PATH}/output_answer.json", "w") as f:
        json.dump(collection_answer, f, indent=2)

    logger.info("Processed the files!!")
    return collection_answer # just return the study information tab and subject areas tab.


@app.post("/api/simultaneous_generate_text_2")
async def simultaneous_generate_text_2():
    answer_1 = chat_with_bot_structured()
    answer_2 = chat_with_bot_structured_2()
    answer_3 = chat_with_bot_structured_3()
    answer_4 = chat_with_bot_structured_4()
    answer_5 = chat_with_bot_structured_5()

    logger.info("Processed the answers")
    # "subject_areas": answer_2, "experimental_groups": answer_4,
    collection_answer = {"study_information": answer_1, "subject_areas": answer_2, "investigators":answer_3, "experimental_groups": answer_4, "phenotype_analysis": answer_5}

    with open(f"{JSON_DEFAULT_PATH}/output_answer.json", "w") as f:
        json.dump(collection_answer, f, indent=2)

    logger.info("Processed the files!!")
    return collection_answer # just return the study information tab and subject areas tab.



@app.post("/api/simultaneous_generate_text_3")
async def simultaneous_generate_text_3():
    answer_1 = chat_with_bot_structured()
    answer_2 = chat_with_bot_structured_2()
    answer_3 = chat_with_bot_structured_3()
    answer_4 = chat_with_bot_structured_4()
    answer_5 = chat_with_bot_structured_5()

    logger.info("Processed the answers")
    # "subject_areas": answer_2, "experimental_groups": answer_4,
    collection_answer = {"study_information": answer_1, "subject_areas": answer_2, "investigators": answer_3,"experimental_groups": answer_4, "phenotype_analysis": answer_5}

    with open(f"{JSON_DEFAULT_PATH}/output_answer.json", "w") as f:
        json.dump(collection_answer, f, indent=2)

    logger.info("Processed the files!!")
    return collection_answer # just return the study information tab and subject areas tab.



@app.post("/api/simultaneous_generate_text_4")
async def simultaneous_generate_text_4():
    answer_1 = chat_with_bot_structured()
    answer_2 = chat_with_bot_structured_2()
    answer_3 = chat_with_bot_structured_3()
    answer_4 = chat_with_bot_structured_4()
    answer_5 = chat_with_bot_structured_5()

    logger.info("Processed the answers")
    # "subject_areas": answer_2, "experimental_groups": answer_4,
    collection_answer = {"study_information": answer_1, "subject_areas": answer_2, "investigators": answer_3, "experimental_groups": answer_4, "phenotype_analysis": answer_5}

    with open(f"{JSON_DEFAULT_PATH}/output_answer.json", "w") as f:
        json.dump(collection_answer, f, indent=2)

    logger.info("Processed the files!!")
    return collection_answer # just return the study information tab and subject areas tab.


@app.post("/api/simultaneous_generate_text_5")
async def simultaneous_generate_text_5():
    answer_1 = chat_with_bot_structured()
    answer_2 = chat_with_bot_structured_2()
    answer_3 = chat_with_bot_structured_3()
    answer_4 = chat_with_bot_structured_4()
    answer_5 = chat_with_bot_structured_5()

    logger.info("Processed the answers")
    # "subject_areas": answer_2, "experimental_groups": answer_4,
    collection_answer = {"study_information": answer_1, "subject_areas": answer_2, "investigators": answer_3, "experimental_groups": answer_4, "phenotype_analysis": answer_5}

    with open(f"{JSON_DEFAULT_PATH}/output_answer.json", "w") as f:
        json.dump(collection_answer, f, indent=2)

    logger.info("Processed the files!!")
    return collection_answer # just return the study information tab and subject areas tab.


#@app.post("/api/generate-study") #/generate-study ## study information tab.
def chat_with_bot_structured(message = """What is the title?
What's the summary of the paper?
What are the funding sources of the paper?
What are the conflicts of interest of the paper?
When was the paper published, answer ONLY in the format: "MM/DD/YYYY" no puncutation whatsoever?
Has this study been published, answer only yes or no without punctuation""", k: int = 5):
    # Initialize your LLM
    CHATGPT_APIKEY = "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"
    llm = ChatOpenAI(
        model="gpt-4o-mini",
        api_key=CHATGPT_APIKEY,
        temperature=0.5,
        max_tokens=1200
    )
    template = return_template()
    prompt_template = ChatPromptTemplate.from_template(template)

    list_message = message.split("?\n")
    for idx, content in enumerate(list_message):
        list_message[idx] = content + "?" # edit the list_message.

    # Ensure the RAG system is initialized
    if faiss_index is None or not document_chunks:
        return {"reply": "RAG system not initialized. Upload a document first."}

    outputs = {} ## maybe make it into a dictionary.
    saved_chunks = None

    idx = 0
    for message in list_message:
        # Retrieve top-k relevant document chunks from FAISS
        query_vector = np.array([get_sentence_embedding(message, glove_embeddings)], dtype=np.float32)
        _, indices = faiss_index.search(query_vector, k)
        best_matches = "\n\n---\n\n".join([str(document_chunks[idx]) for idx in indices[0]])
        prompt = prompt_template.format(context = best_matches, question = message)

        if idx == 1:
            saved_chunks = best_matches


        structured_output = llm.invoke(prompt).content #
        #structured_output = structured_output.replace(".", ".\n")
        outputs[message] = structured_output # then we need to print that.
        idx+=1
    binary_map = {"yes": 1, "no":0}

    binary_answer = outputs[list_message[-1]].lower()
    if binary_answer in binary_map.keys():
        response = {"studyTitle": outputs["What is the title?"], "studySummary": outputs["What's the summary of the paper?"], "funding": outputs["What are the funding sources of the paper?"],
                    "conflicts": outputs["What are the conflicts of interest of the paper?"], "Date": outputs[list_message[-2]], "published": binary_map[binary_answer], "summary_chunks": saved_chunks}
        return response
    else:
        response = {"studyTitle": outputs["What is the title?"], "studySummary": outputs["What's the summary of the paper?"], "funding": outputs["What are the funding sources of the paper?"],
                    "conflicts": outputs["What are the conflicts of interest of the paper?"], "Date": outputs[list_message[-2]], "published": 0, "summary_chunks": saved_chunks}
        return response


#@app.post("/api/generate-study-2") # /generate-study-2 Subject Areas Tab.
def chat_with_bot_structured_2(message = """In list 1, strictly list only the most directly relevant subject areas in the paper use the exact same spelling and phrasing:
In list 2, strictly list only the most directly relevant subject areas in the paper use the exact same spelling and phrasing:
In list 3, strictly list only the most directly relevant subject areas in the paper use the exact same spelling and phrasing:
In list 4, strictly list only the most directly relevant subject areas in the paper use the exact same spelling and phrasing""", k: int = 5):
    # Initialize your LLM
    list1 = ["aging", "autophagy", "bone_development", "bone_metabolism", "bone_remodeling", "circadian_rhythm"]
    list2 = ["adipose_tissue", "digestive_system", "endocrine_system", "immune_system"]
    list3 = ["bone_lining_cells", "chondrocyte", "osteoblast"]
    list4 = ["osteopenia", "osteoporosis", "osteopetrosis"]


    Collection_List = [list1, list2, list3, list4]
    CHATGPT_APIKEY = "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"
    llm = ChatOpenAI(
        model="gpt-4o-mini",
        api_key=CHATGPT_APIKEY,
        temperature=0.3,
        max_tokens=1200
    )
    # Retrieve your prompt template (which should expect keys "context" and "question")
    template = return_template()
    prompt_template = ChatPromptTemplate.from_template(template)

    list_message = message.split(":\n")
    for idx, content in enumerate(list_message):
        list_message[idx] = content + ":" + str(Collection_List[idx])[1:-1] # edit the list_message.

    # Ensure the RAG system is initialized
    if faiss_index is None or not document_chunks:
        return {"reply": "RAG system not initialized. Upload a document first."}

    outputs = {} ## maybe make it into a dictionary.
    idx = 0
    for message in list_message:
        # Retrieve top-k relevant document chunks from FAISS
        query_vector = np.array([get_sentence_embedding(message, glove_embeddings)], dtype=np.float32)
        _, indices = faiss_index.search(query_vector, k)
        best_matches = "\n\n---\n\n".join([str(document_chunks[idx]) for idx in indices[0]])

        prompt = prompt_template.format(context = best_matches, question = message)
        structured_output = llm.invoke(prompt).content

        keyword_list = Collection_List[idx]
        matches = [kw for kw in keyword_list if re.search(rf"\b{re.escape(kw)}\b", structured_output)]
        outputs[message] = matches # then we need to print that.
        idx+=1

    #output_str = ""
    #for key in outputs.keys():
    #    output_str += key + ":\n\n" + structured_output
    response = {"list1": outputs[list_message[0]], "list2": outputs[list_message[1]], "list3": outputs[list_message[2]], "list4": outputs[list_message[3]]}
    logger.info(f"Response Data: {response}")
    return response
    #return {"reply": f"Based on the default queries, here's what I found:\n{output_str}"}


#@app.post("/api/generate-study-3") ## investigators. # /generate-study-3
def chat_with_bot_structured_3(message = """Based on the paper, give me the investigators involved in the paper using tuples where each tuple is formatted as (first_name, last_name, email, department, organization, country). Find their corresponding first name, last name, their email, department, organization, and country.
                                     These informations should be on first page! Only answer with tuples and if there's multiple tuples, use commas "," after each tuple. And if you don't know the country infer based on department location or write 'United States'. Write 'NULL' for the other fields you have no clue on.""", k: int = 5):
    # Initialize your LLM
    CHATGPT_APIKEY = "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"
    llm = ChatOpenAI(
        model="gpt-4o-mini",
        api_key=CHATGPT_APIKEY,
        temperature=0.5,
        max_tokens=1200
    )
    # Retrieve your prompt template (which should expect keys "context" and "question")
    template = return_template()
    prompt_template = ChatPromptTemplate.from_template(template)

    list_message = message

    # Ensure the RAG system is initialized
    if faiss_index is None or not document_chunks:
        return {"reply": "RAG system not initialized. Upload a document first."}

    outputs = {} ## maybe make it into a dictionary.

        # Retrieve top-k relevant document chunks from FAISS
    query_vector = np.array([get_sentence_embedding(list_message, glove_embeddings)], dtype=np.float32)
    _, indices = faiss_index.search(query_vector, k)
    best_matches = "\n\n---\n\n".join([str(document_chunks[idx]) for idx in indices[0]])

    prompt = prompt_template.format(context = best_matches, question = list_message)
    structured_output = llm.invoke(prompt).content #
    structured_output = structured_output.replace(".", ".\n")
    
    logger.info(f"Response Data: {structured_output}") ## for debugging purposes. 
    outputs["investigator_info"] = structured_output # then we need to print that.

    return outputs

#@app.post("/api/generate-study-4") # /generate-study-4 ## experimental group tab.


def chat_with_bot_structured_4(message = """In the experimental category list, please list only the most relevant experimental categories in the paper. Use the exact same spelling and phrasing of categories:""", k = 5):
    list1 = ["Uses genetically modified mice to investigate the role of a gene or cell population on the skeleton",
             "Investigates the impact of a drug treatment on the skeleton",
             "Performs a mechanical loading/unloading procedure.",
             "Performs a gonadectomy.",
             "Compares different animal diet conditions (testing of Nutrients, Phytochemicals, Probiotics)",
             "Compares different light/dark cycles",
             "Compares different mouse strains"]

    CHATGPT_APIKEY = "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"

    llm = ChatOpenAI(
        model="gpt-4o-mini",
        api_key=CHATGPT_APIKEY,
        temperature=0.5,
        max_tokens=1200
    )

    first_message = message + " " + str(list1)[1:-1] # convert it to a string message. we'll later have to

    template = return_template()
    prompt_template = ChatPromptTemplate.from_template(template)
    query_vector = np.array([get_sentence_embedding(first_message, glove_embeddings)], dtype=np.float32)
    _, indices = faiss_index.search(query_vector, k)


    best_matches = "\n\n---\n\n".join([str(document_chunks[idx]) for idx in indices[0]])
    prompt = prompt_template.format(context = best_matches, question = first_message) # construct the prompt.
    output = llm.invoke(prompt).content # get the output!

    if faiss_index is None or not document_chunks:
        return {"reply": "RAG system not initialized. Upload a document first."} # return this message if something doesn't work!

    logger.info(f"Animal experimentation response: {output}") # for debugging purposes
    answer_dict = {}
    ## digest the message and return an output.
    matches = [kw for kw in list1 if re.search(rf"\b{re.escape(kw)}\b", output)]
    answer_dict[0] = matches # we need to set that.
    ## then we check whether the matches contain any of the keywords that are important.
    if "Uses genetically modified mice to investigate the role of a gene or cell population on the skeleton" in matches:
        message2 = "Given that the paper uses genetically modified mice to investigate the role of a gene or cell population on the skeleton, please list the attributes that were used in the study:"
        list2 = ["Global targeted knockout or knock-in to alter an endogeneous gene's function",
                 "Spontaneous, Chemical or X-Ray Induced Mutation (randomly generated point mutation or deletion that has been mapped)",
                 "Insertional Mutagenesis: Gene Trap, Retroviral, or Transposon Mediated Mutagenesis.",
                 "Conditional Knockout or Knockin to alter an endogeneous gene's function in a specific cell lineage typically when intercrossed with Cre transgenic Mice (tissue/lineage specific loss of function)",
                 "Conditional Knock-in into a specific gene or \"Safe Harbor\" site such as the Rosa Locus",
                 "Random Genome Integration of a Transgene (i.e. over expression of a coding sequence controlled by tissue specific regulatory sequences)"]

        combined_message = message2 + " " + str(list2)[1:-1]
        template = return_template()
        prompt_template = ChatPromptTemplate.from_template(template) # create the prompt template.
        query_vector = np.array([get_sentence_embedding(combined_message, glove_embeddings)], dtype=np.float32) # construct the query vector for our model to understand.

        _, indices = faiss_index.search(query_vector, k+2) # search for the relevant indices.
        best_matches = "\n\n---\n\n".join([str(document_chunks[idx]) for idx in indices[0]])

        output = llm.invoke(prompt_template.format(context = best_matches, question = combined_message)).content # get the output.
        matches = [kw for kw in list2 if re.search(rf"\b{re.escape(kw)}\b", output)] # check for the matches.
        answer_dict[1] = matches # add the matches to the dictionary.
        return answer_dict
    else:
        return answer_dict


def chat_with_bot_structured_4_generalized(question, question_list, Collection_list, k =5, text = None): ## construct a question_list and collection_list as well to make our
                                                           ## function more generalized and easier to use.
    CHATGPT_APIKEY = "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"
    llm = ChatOpenAI(
        model="gpt-4o-mini",
        api_key=CHATGPT_APIKEY,
        temperature=0.5,
        max_tokens=1200)

    answer = {}
    for i in range(len(question_list)):
        template = return_template()
        prompt_template = ChatPromptTemplate.from_template(template)
        query_vector = np.array([get_sentence_embedding(question_list[i], glove_embeddings)], dtype=np.float32)

        _, indices = faiss_index.search(query_vector, k)
        best_matches = "\n\n---\n\n".join([str(document_chunks[idx]) for idx in indices[0]])

        output = llm.invoke(prompt_template.format(context = best_matches, question = question_list[i])).content
        answer[f"{text}_{i}"] = output

    index = 3
    for i in Collection_list:
        question_1 = question + "please only select the following(s) that is relevant to the paper: " + str(i)[1:-1]
        query_vector = np.array([get_sentence_embedding(question_1, glove_embeddings)], dtype=np.float32)

        _, indices = faiss_index.search(query_vector, k)
        best_matches = "\n\n---\n\n".join([str(document_chunks[idx]) for idx in indices[0]])

        output = llm.invoke(prompt_template.format(context = best_matches, question = question_1)).content
        matches = [kw for kw in i if re.search(rf"\b{re.escape(kw)}\b", output)]
        answer[f"{text}_{index}"] = matches
        index += 1
    return answer




def chat_with_bot_structured_5(message = """Based on the paper, list the experiment groups where they each should contain information about sex and age in weeks as an answer.
                                     Answer strictly with a tuple format (sex, weeks) and list them with a "-". sex is denoted as 1 as male and 0 for female. If you can't
                                     find the sex and/or age, omit that answer.""", k: int = 5):

    CHATGPT_APIKEY = "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"
    llm = ChatOpenAI(
        model="gpt-4o-mini",
        api_key=CHATGPT_APIKEY,
        temperature=0.5,
        max_tokens=1200)


    template = return_template()
    prompt_template = ChatPromptTemplate.from_template(template)

    if faiss_index is None or not document_chunks:
        return {"reply": "RAG system not initialized. Upload a document first."}

    outputs = {} ## maybe make it into a dictionary.

    query_vector = np.array([get_sentence_embedding(message, glove_embeddings)], dtype=np.float32)
    _, indices = faiss_index.search(query_vector, k)
    best_matches = "\n\n---\n\n".join([str(document_chunks[idx]) for idx in indices[0]])

    prompt = prompt_template.format(context = best_matches, question = message)
    structured_output = llm.invoke(prompt).content #

    structured_output = structured_output.split("-")
    #structured_output = structured_output.split("-")
    trimmed_output = [item.strip() for item in structured_output]
    outputs["groups"] = trimmed_output

    logger.info(f"Response Data: {outputs}") ## for debugging purposes.
    return outputs # just return them.


#@app.post("/api/generate-study-5") # /generate-study-5 ## phenotype analysis
def chat_with_bot_structured_6(message = "Based on the paper, select the following type of analyses that were performed to phenotype the mice if mentioned:", k: int = 5):
    # Initialize your LLM
    CHATGPT_APIKEY = "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"
    llm = ChatOpenAI(
        model="gpt-4o-mini",
        api_key=CHATGPT_APIKEY,
        temperature=0.5,
        max_tokens=1200
    )
    # Retrieve your prompt template (which should expect keys "context" and "question")
    template = return_template()
    prompt_template = ChatPromptTemplate.from_template(template)

    list1 = ["Dual-Energy X-Ray Absorptiometry (DEXA)", "Microcomputed Tomography", "Bone Histomorphometry", "Mechanical Strength Testing", "Clinical Biochemistry/Biomarkers"]

    dexa_list = ["Whole Body", "Femur", "Tibia", "Vertebra"]
    micro_list = ["Femur Trabecular Bone", "Femur Cortical Bone","Tibia Trabecular Bone","Tibia Cortical Bone", "Vertebra Trabecular Bone"]
    bone_histo_list = ["Femur Trabecular Bone", "Femur Cortical Bone", "Tibia Trabecular Bone", "Tibia Cortical Bone", "Vertebra Trabecular Bone"]
    mechanical_list = bone_histo_list
    clincal_list = ["Bone","Urine"]


    list_message = message
    list_message1 = list_message + " " + " ".join(list1) # connect
    list_message2 = "Since there's Dual-Energy X-Ray Absorptiometry in the paper, select out of the list which part it was performed on: " + " ".join(dexa_list)
    list_message3 = "Since there's Microcomputed Tomography in the paper, select ouf of the list which part of the bone it was performed on: " + " ".join(micro_list)
    list_message4 = "Since there's Bone Histomorphometry in the paper, select out of the list which part of the bone it was performed on: " + " ".join(bone_histo_list)
    list_message5 = "Since there's Mechanical Strength Testing in the paper, select out of the list which part of the bone it was performed on: " + " ".join(mechanical_list)
    list_message6 = "Since there's Clinical Biochemistry/Biomarkers in the paper, select out of the list which part of the bone it was performed on: " + " ".join(clincal_list)

    # Ensure the RAG system is initialized
    if faiss_index is None or not document_chunks:
        return {"reply": "RAG system not initialized. Upload a document first."}

    outputs = {} ## maybe make it into a dictionary.
    outputs2 = {}
    outputs3 = {}
    outputs4 = {}
    outputs5 = {}
    outputs6 = {}
        # Retrieve top-k relevant document chunks from FAISS
    query_vector = np.array([get_sentence_embedding(list_message1, glove_embeddings)], dtype=np.float32)
    _, indices = faiss_index.search(query_vector, k)
    best_matches = "\n\n---\n\n".join([str(document_chunks[idx]) for idx in indices[0]])

    prompt = prompt_template.format(context = best_matches, question = message)
    structured_output = llm.invoke(prompt).content #

    matches = [kw for kw in list1 if re.search(rf"\b{re.escape(kw.lower())}\b", structured_output.lower())]
    outputs["matches"] = matches # if it's yes then we have to do it again for two other lists.

    if "Dual-Energy X-Ray Absorptiometry (DEXA)" in matches: ## then we do it again.
        outputs2["DEXA"] = chat_with_bot_structured_5_complement(prompt_template = prompt_template, llm = llm, faiss_index = faiss_index, message = list_message2, list_topic = dexa_list)

    if "Microcomputed Tomography" in matches:
        outputs3["Micro Tomography"] = chat_with_bot_structured_5_complement(prompt_template = prompt_template, llm = llm, faiss_index = faiss_index, message = list_message3, list_topic = micro_list)

    if "Bone Histomorphometry" in matches:
        outputs4["Bone Histomorphometry"] = chat_with_bot_structured_5_complement(prompt_template = prompt_template, llm = llm, faiss_index = faiss_index, message = list_message4, list_topic = bone_histo_list)

    if "Mechanical Strength Testing" in matches:
        outputs5["Mechanical Strength"] = chat_with_bot_structured_5_complement(prompt_template = prompt_template, llm = llm, faiss_index = faiss_index, message = list_message5, list_topic = mechanical_list)

    if "Clincal Biochemistry/Biomarkers" in matches:
        outputs6["Clincal Biochem"] = chat_with_bot_structured_5_complement(prompt_template = prompt_template, llm = llm, faiss_index = faiss_index, message = list_message6, list_topic = clincal_list)

    return outputs, outputs2, outputs3, outputs4, outputs5, outputs6

def chat_with_bot_structured_5_complement(prompt_template, llm, faiss_index, message, list_topic):

    outputs = {}
    query_vector = np.array([get_sentence_embedding(message, glove_embeddings)], dtype = np.float32)
    _, indices = faiss_index.search(query_vector, 5)
    best_matches = "\n\n---\n\n".join([str(document_chunks[idx]) for idx in indices[0]])

    prompt = prompt_template.format(context = best_matches, question = message)
    structured_output = llm.invoke(prompt).content

    matches = [kw for kw in list_topic if re.search(rf"\b{re.escape(kw.lower())}\b", structured_output.lower())]
    outputs[0] = matches

    #return outputs
    return matches




@app.get("/api/rag-query") # /rag-query
async def query_rag(question: str, k: int = 5):
    #return await chat_with_bot(message=question, k=k)
    return await chat_with_bot(message = question, k=k) # let's test that out.

