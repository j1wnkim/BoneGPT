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


logging.basicConfig(level=logging.INFO, format='%(asctime)s - %(name)s - %(levelname)s - %(message)s')
logger = logging.getLogger(__name__)



faiss_index = None


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


def return_template() -> str:
    PROMPT_TEMPLATE = """
You are a helpful retrieval-augmented assistant.
Below is some context retrieved for you. Answer the user’s question formally, using the provided context.
If you do not have enough information, say “I don’t know.”
Do *NOT* make up anything beyond the retrieved context.
Please ensure that your answer is composed of one or more complete sentences.

CONTEXT:
{context}

USER QUESTION:
{question}

ASSISTANT:
"""
    return PROMPT_TEMPLATE








def chat_with_bot_structured_compliment(message = """What is the title?
What's the summary of the paper?
What are the funding sources of the paper?
What are the conflicts of interest of the paper?
When was the paper published, answer ONLY in the format: "MM/DD/YYYY" no puncutation whatsoever?
Has this study been published, answer only yes or no without punctuation""", k: int = 5, faiss_index = faiss_index, document_chunks = document_chunks):
    # Initialize your LLM
    CHATGPT_APIKEY = ""
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

    for message in list_message:
        # Retrieve top-k relevant document chunks from FAISS
        query_vector = np.array([get_sentence_embedding(message, glove_embeddings)], dtype=np.float32)
        _, indices = faiss_index.search(query_vector, k)
        best_matches = "\n\n---\n\n".join([str(document_chunks[idx]) for idx in indices[0]])

        prompt = prompt_template.format(context = best_matches, question = message)
        structured_output = llm.invoke(prompt).content #
        #structured_output = structured_output.replace(".", ".\n")
        outputs[message] = structured_output # then we need to print that.
    binary_map = {"yes": 1, "no":0}

    binary_answer = outputs[list_message[-1]].lower()
    if binary_answer in binary_map.keys():
        response = {"studyTitle": outputs["What is the title?"], "studySummary": outputs["What's the summary of the paper?"], "funding": outputs["What are the funding sources of the paper?"],
                    "conflicts": outputs["What are the conflicts of interest of the paper?"], "Date": outputs[list_message[-2]], "published": binary_map[binary_answer]}
        return response
    else:
        response = {"studyTitle": outputs["What is the title?"], "studySummary": outputs["What's the summary of the paper?"], "funding": outputs["What are the funding sources of the paper?"],
                    "conflicts": outputs["What are the conflicts of interest of the paper?"], "Date": outputs[list_message[-2]], "published": 0}
        return response


def chat_with_bot_structured_2_compliment(message = """In list 1, list only the most relevant subject areas in the paper use the exact same spelling and phrasing:
In list 2, list only the most relevant subject areas in the paper use the exact same spelling and phrasing:
In list 3, list only the most relevant subject areas in the paper use the exact same spelling and phrasing:
In list 4, list only the most relevant subject areas in the paper use the exact same spelling and phrasing""", k: int = 5, faiss_index = faiss_index, document_chunks = document_chunks):
    # Initialize your LLM
    list1 = ["aging", "autophagy", "bone_development", "bone_metabolism", "bone_remodeling", "circadian_rhythm"]
    list2 = ["adipose_tissue", "digestive_system", "endocrine_system", "immune_system"]
    list3 = ["bone_lining_cells", "chondrocyte", "osteoblast"]
    list4 = ["osteopenia", "osteoporosis", "osteopetrosis"]


    Collection_List = [list1, list2, list3, list4]
    CHATGPT_APIKEY = ""
    llm = ChatOpenAI(
        model="gpt-4o-mini",
        api_key=CHATGPT_APIKEY,
        temperature=0.5,
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


def chat_with_bot_structured_6_generalized(question, question_list, Collection_list, k =5, text = None): ## construct a question_list and collection_list as well to make our 
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














def chat_with_bot_structured_6_compliment(message = """In the experimental category list, please list only the most relevant experimental categories in the paper use the exact same spelling and phrasing of categories:""", k = 5):
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
    
    ## digest the message and return an output. 
    matches = [kw for kw in list1 if re.search(rf"\b{re.escape(kw)}\b", output)]
    ## then we check whether the matches contain any of the keywords that are important. 
    if "Uses genetically modified mice to investigate the role of a gene or cell population on the skeleton" in matches: 
        message2 = "Given that the paper uses genetically modified mice to investigate the role of a gene or cell population on the skeleton, please list the attributes that describe the genetically modified animals in the study:"
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
        
        _, indices = faiss_index.search(query_vector, k) # search for the relevant indices. 
        best_matches = "\n\n---\n\n".join([str(document_chunks[idx]) for idx in indices[0]])
        
        output = llm.invoke(prompt_template.format(context = best_matches, question = combined_message)).content # get the output.
        matches = [kw for kw in list2 if re.search(rf"\b{re.escape(kw)}\b", output)] # check for the matches. 
        
        gene_mutation = ["Global targeted knockout or knock-in to alter an endogeneous gene's function",
                 "Spontaneous, Chemical or X-Ray Induced Mutation (randomly generated point mutation or deletion that has been mapped)",
                 "Insertional Mutagenesis: Gene Trap, Retroviral, or Transposon Mediated Mutagenesis."] 
        
        conditional_mouse = ["Conditional Knockout or Knockin to alter an endogeneous gene's function in a specific cell lineage typically when intercrossed with Cre transgenic Mice (tissue/lineage specific loss of function)",
                 "Conditional Knock-in into a specific gene or \"Safe Harbor\" site such as the Rosa Locus"]
         
        transgenic_mouse = ["Random Genome Integration of a Transgene (i.e. over expression of a coding sequence controlled by tissue specific regulatory sequences)"]
        
        dict_answer = {}
        for text in matches: 
            if text in gene_mutation: 
                question = "Based on the fact that " + text + " is used in the paper for genetically modified animals,"
            
                question1 = question + " please name the animal model that is present in the paper."
                question2 = question + " please name the full name of the investigator only in which the animal model was originated in the paper."
                question3 = question + " please name the genetically modified gene."
                Question_list = [question1, question2, question3]
    
    
                list_1 = ["Knockout(-)", "Knockin(KI)"]
                list_2 = ["wildtype allele(+); knockout alelle(-)", "wildtype allele(+), knockin allele(KI)", "Other"] 
                list_3 = ["Protein Coding", "MicroRNA", "Long Non-Coding RNA", "Small Nuclear RNA", "Small Nuclear RNA", 
                    "Enhancer RNA", "Antisense RNA", "Other"]
                list_4 = ["Loss of Function", "Gain of Function", "Hypomorphic Mutant", "Dominant Negative","Unknown"]
                list_5 = ["C57BL/6", "C3H", "FVB", "CD1", "BALB/c", "NOD", "ICR", "DBA", "Other"]  
    
                Collection_list = [list_1, list_2, list_3, list_4, list_5] # collection.
                complete_dict = chat_with_bot_structured_6_generalized(question, Question_list, Collection_list, k = 5, text = text) # call the function
                dict_answer.update(complete_dict) # update the dictionary. 
            elif text in conditional_mouse:
                question = "Based on the fact that " + text + " is used in the paper for conditionally engineered animal models, "
                
                question1 = question + " please only give me the name of the animal model that is present in the paper."
                question2 = question + " please only give me the full name of the investigator only in which the animal model was originated in the paper."
                question3 = question + " please only give me the name of Gene Engineered for Conditional Targeting from the paper."
                question4 = question + " please only give me the Gene Symbol of Genetically Modified Gene from the paper."
                Question_list = [question1, question2, question3, question4]
                
                list_1 = ["wildtype allele (+); floxed allele (flx)", "other"]
                list_2 = ["protein coding, MicroRNA", "Long Non-Coding RNA", "Small Nuclear RNA", "Enhancer RNA", "Antisense RNA", "other"] 
                list_3 = ["Loss of Function", "Gain of Function", "Hypomorphic Mutant", "Dominant Negative", "Unknown"]
                list_4 = ["C57BL/6", "C3H", "FVB", "CD1", "BALB/c", "NOD", "ICR", "DBA", "Mixed or Other"]
                list_5 = ["Transgene Regulated Non-Inducible", "Tamoxifen INducible", "Doxycycline Regulated"]
                
                Collection_list = [list_1, list_2, list_3, list_4, list_5]
                complete_dict = chat_with_bot_structured_6_generalized(question, Question_list, Collection_list, k = 5, text = text) # call the function
                dict_answer.update(complete_dict) # update the dictionary.
                
            elif text in transgenic_mouse:
                question = "Based on the fact that " + text + " is used in the paper for transgenic animals, "
                question_1 = question +"please only give the name of the transgenic animal model that is present in the paper."
                question_2 = question + "please only give the abbreviation of rnadomly integrated transgene"
                question_3 = question + "please give the full name of the investigator from which the animal model was orignated in the paper."
                question_4 = question + "please only give the Name of Gene from which Regulatory Sequences were derived to Drive the Expression of the Desired Product from the paper."
                question_5 = question + "please only give the Tissue/Cell Lineage Specificity of Transgenic Line from the paper."
                question_6 = question + "please only give the name of the gene product being expressed by the transgene."
                
                Question_list = [question_1, question_2, question_3, question_4, question_5, question_6]
                
                list_1 = ["Gain of Function", "Dominant Negative", "Cell Ablation", "Knock Down", "Unknown"]
                list_2 = ["Protein Coding", "MicroRNA", "Long Non-Coding RNA", "Small Nuclear RNA", "Enancer RNA", "Antisense RNA", "Other"]
                list_3 = ["C57BL/6", "C3H", "FVB", "CD1", "BALB/c", "NOD", "ICR", "DBA", "Mixed or Other"] 
                Collection_list = [list_1, list_2, list_3]
                complete_dict = chat_with_bot_structured_6_generalized(question, Question_list, Collection_list, k = 5, text = text)
                dict_answer.update(complete_dict)

    else:
        return matches, dict_answer # return the matches and the dictionary answer fully. 

        
def chat_with_bot_structured_6_generalized_compliment(question, question_list, Collection_list, k =5, text = None): ## construct a question_list and collection_list as well to make our 
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
    






def chat_with_bot_structured_3_compliment(message = """Based on the paper, give me the investigators information that is returned by a tuple where each tuple is formatted as (first_name, last_name, email, department, organization, country).
                                     Only answer with tuples and if there's multiple tuples, use commas "," after each tuple. And if you don't know the country name, just write 'Afghanistan' without the quotation marks. Write 'I don't know' for the other fields you have no clue on.""", k: int = 5, faiss_index = faiss_index, document_chunks = document_chunks):
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
    outputs[message] = structured_output # then we need to print that.

    #output_str = ""
    #for key in outputs.keys():
    #    output_str += key + ":\n\n" + structured_output
    return outputs

def chat_with_bot_structured_4_compliment(message = """Based on the paper, tell me the number of experiment group where they each should contain information about sex and age in weeks answer.
                                     Answer strictly with a tuple format (sex, weeks) and list them with a "-". No additional text.""", k: int = 5, faiss_index = faiss_index, document_chunks = document_chunks):

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
    outputs[0] = structured_output

    return outputs # just return them.


def chat_with_bot_structured_5_compliment(message = "Based on the paper, select the following type of analyses that were performed to phenotype the mice if mentioned:", k: int = 5, faiss_index = faiss_index, document_chunks = document_chunks):
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

    list_message = message
    list_message1 = list_message + " " + " ".join(list1) # connect
    list_message2 = "Since there's Dual-Energy X-Ray Absorptiometry in the paper, select out of the list which part it was performed on: " + " ".join(dexa_list)
    list_message3 = "Since there's Microcomputed Tomography in the paper, select ouf of the list which part of the bone it was performed on: " + " ".join(micro_list)


    # Ensure the RAG system is initialized
    if faiss_index is None or not document_chunks:
        return {"reply": "RAG system not initialized. Upload a document first."}

    outputs = {} ## maybe make it into a dictionary.
    outputs2 = {}
    outputs3 = {}
        # Retrieve top-k relevant document chunks from FAISS
    query_vector = np.array([get_sentence_embedding(list_message1, glove_embeddings)], dtype=np.float32)
    _, indices = faiss_index.search(query_vector, k)
    best_matches = "\n\n---\n\n".join([str(document_chunks[idx]) for idx in indices[0]])

    prompt = prompt_template.format(context = best_matches, question = message)
    structured_output = llm.invoke(prompt).content #

    matches = [kw for kw in list1 if re.search(rf"\b{re.escape(kw.lower())}\b", structured_output.lower())]
    outputs[0] = matches # if it's yes then we have to do it again for two other lists.

    if "Dual-Energy X-Ray Absorptiometry (DEXA)" in matches: ## then we do it again.
        query_vector = np.array([get_sentence_embedding(list_message2, glove_embeddings)], dtype = np.float32)
        _, indices = faiss_index.search(query_vector, k)
        best_matches = "\n\n---\n\n".join([str(document_chunks[idx]) for idx in indices[0]])

        prompt = prompt_template.format(context = best_matches, question = message)
        structured_output = llm.invoke(prompt).content

        matches = [kw for kw in dexa_list if re.search(rf"\b{re.escape(kw.lower())}\b", structured_output.lower())]
        outputs2[0] = matches


    if "Microcomputed Tomography" in matches:
        query_vector = np.array([get_sentence_embedding(list_message3, glove_embeddings)], dtype = np.float32)
        _, indices = faiss_index.search(query_vector, k)
        best_matches = "\n\n---\n\n".join([str(document_chunks[idx]) for idx in indices[0]])

        prompt = prompt_template.format(context = best_matches, question = message)
        structured_output = llm.invoke(prompt).content

        matches = [kw for kw in dexa_list if re.search(rf"\b{re.escape(kw.lower())}\b", structured_output.lower())]
        outputs3[0] = matches

    #output_str = ""
    #for key in outputs.keys():
    #    output_str += key + ":\n\n" + structured_output
    return outputs, outputs2, outputs3
