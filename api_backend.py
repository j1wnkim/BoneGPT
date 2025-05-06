# import numpy as np
# import faiss
# import os
# import shutil
from fastapi import FastAPI, UploadFile, File, Form
from fastapi.middleware.cors import CORSMiddleware
from google import genai
from google.genai import types

#from google import generativeai as genai 
#from google.generativeai import types 
import logging

# from langchain_community.document_loaders import PyPDFLoader, TextLoader

import psycopg2

app = FastAPI()
logger = logging.getLogger(__name__)

# CHATGPT_APIKEY = "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"

# Allow frontend to connect
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# UPLOAD_DIR = "uploads"
# os.makedirs(UPLOAD_DIR, exist_ok=True)

# Load GloVe embeddings
# GLOVE_PATH = "glove.6B.300d.txt"
# EMBEDDING_DIM = 300
#glove_embeddings = {}

# def load_glove_embeddings(glove_path): ## Function GOOD
#     """Loads GloVe embeddings into a dictionary"""
#     glove_embeddings = {}
#     with open(glove_path, "r", encoding="utf-8") as f:
#         for line in f:
#             values = line.split()
#             word = values[0]
#             vector = np.asarray(values[1:], dtype="float32")
#             glove_embeddings[word] = vector
#     return glove_embeddings

# Load embeddings at startup
# glove_embeddings = load_glove_embeddings(GLOVE_PATH)


# FAISS index (stores vector embeddings)
# faiss_index = None
# document_texts = []  # Stores raw text for retrieval

# def get_sentence_embedding(sentence, glove_embeddings): ## FUNCTION GOOD.
#     """Convert a sentence to a vector by averaging word vectors"""
#     words = sentence.split()
#     valid_vectors = [glove_embeddings[word] for word in words if word in glove_embeddings]
#     if not valid_vectors:
#         return np.zeros(EMBEDDING_DIM)
#     return np.mean(valid_vectors, axis=0)

# def process_and_store_file(file_path: str):
#     """Reads a file, extracts sentences, and stores embeddings in FAISS"""
#     global faiss_index, document_texts

#     loader = PyPDFLoader(file_path) if file_path.endswith(".pdf") else TextLoader(file_path)
#     docs = loader.load()
#     document_texts = [doc.page_content for doc in docs]

#     # Convert text to vectors
#     vectors = np.array([get_sentence_embedding(text) for text in document_texts], dtype=np.float32)

#     # Create FAISS index
#     faiss_index = faiss.IndexFlatL2(EMBEDDING_DIM)
#     faiss_index.add(vectors)

# @app.post("/rag-upload")
# async def upload_file(file: UploadFile = File(...)):
#     file_path = os.path.join(UPLOAD_DIR, file.filename)
#     with open(file_path, "wb") as buffer:
#         shutil.copyfileobj(file.file, buffer)

#     process_and_store_file(file_path)

#     return {"success": True, "message": "File uploaded and processed successfully"}

# Define connection parameters
host = "soc-sdp-27.soc.uconn.edu"
user = "laravel_user"
password = "temp"  # Provide the password for the 'laravel_user'
database = "bgptsample"

# Establish the connection
try:
    conn = psycopg2.connect(
        host=host,
        user=user,
        password=password,
        dbname=database
    )
    print("Connection successful")
except Exception as e:
    print(f"Error: {e}")
    exit(1)

# Create a cursor object to interact with the database
cursor = conn.cursor()

# Example: Run a query
cursor.execute("SELECT * FROM tf_list;")
rows = cursor.fetchall()

# Print the results
# for row in rows:
#     print(row)

client = genai.Client(api_key="AIzaSyAu0Q7b71upte0wvIjHde2IAfKmiilBLTA")
chat = client.chats.create(
    model="gemini-2.0-flash",
    config=types.GenerateContentConfig(
        system_instruction=
        f"Answer questions that only pertain to the SQL database"
        f"The database is: {rows}"
        # "If applicable, generate an SQL command."
        "If you don't know, say you don't know"
    ),
)

@app.post("/chatbot")
async def chat_with_bot(message: str = Form(...)):
    response = chat.send_message(message)
    return {"reply": f"{response.text}"}

# @app.get("/rag-query")
# async def query_rag(question: str):
#     return await chat_with_bot(message=question)

cursor.close()
conn.close()
