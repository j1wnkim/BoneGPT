from google import genai
from google.genai import types

import os
import subprocess
import json

env = os.environ.copy()
env["PGPASSWORD"] = "temp"

tables = [
    "Control_female_Cortical_average",
    "Control_male_Cortical_average",
    "Controlfemale_femurCorticalIM",
    "Controlmale_femurCorticalIM",
    "controlfemale_Vertebra",
    "controlfemale_femur",
    "controlmale_Vertebra",
    "controlmale_femur",
    "femaleVertebraIM",
    "female_FemurCortical_average",
    "female_Femur_average",
    "female_Vert_average",
    "female_femurCorticalIM",
    "female_femurIM",
    "maleVertebraIM",
    "male_FemurCortical_average",
    "male_Femur_average",
    "male_Vert_average",
    "male_femurCorticalIM",
    "male_femurIM",
    "sessions",
    "study_info"
]

client = genai.Client(api_key="AIzaSyAu0Q7b71upte0wvIjHde2IAfKmiilBLTA")

def should_gen_sql(input) -> bool:
    response = client.models.generate_content(
        model="gemini-2.0-flash",
        config=types.GenerateContentConfig(
            system_instruction=
            "You're a bone biologist."
            "You must only return a boolean."
            "If the user's request can be turned into an SQL command, then return true. Otherwise, return false."
            "Use keywords that either relate to SQL (selct, etc) and/or biology (genes, etc) to determine if it's an SQL command or not."
        ),
        contents=input
    )

    return response.text.strip().lower() == "true"

def contains_tf_question(input) -> bool:
    response = client.models.generate_content(
        model="gemini-2.0-flash",
        config=types.GenerateContentConfig(
            system_instruction=
            "You must only return a boolean."
            "If the user's request contains \"transcription factor\" or \"tf\", then return true. Otherwise, return false."
        ),
        contents=input
    )

    print(f"Contains tf: {response.text}")
    return response.text.strip().lower() == "true"

def find_genes_in_tf(input, data):
    database_name = data["databaseName"]
    table_name = data["tableName"]
    table_name = "male_femurIM"

    cmd = [
        "psql",
        "-h",
        "soc-sdp-27.soc.uconn.edu",
        "-U",
        "laravel_user",
        "-d",
        f"{database_name}",
        "-t",
        "-A"
        "-c",
        f"SELECT \"gene_symbol\" from \"{table_name}\";"
    ]

    result = subprocess.run(cmd, capture_output = True, text = True, env = env)

    if result.returncode != 0:
        print("ERR")

    print(result.stdout)
    exit(0)
    response = client.models.generate_content(
        model="gemini-2.0-flash",
        config=types.GenerateContentConfig(
            system_instruction=
            "Only return the SQL command. Don't say anything. No code blocks."
            "The SQL command that you need to fill in is: \"SELECT gene FROM tf_list WHERE TRIM(gene) IN ();\"."
            "Inside the parenthesis is where you'll be putting the genes you'll find from the user's input."
            "Don't forget to surround the gene names with single quotes."
        ),
        contents=input
    )

    print(repr(response.text))

    # cmd = [
    #     "psql",
    #     "-h",
    #     "soc-sdp-27.soc.uconn.edu",
    #     "-U",
    #     "laravel_user",
    #     "-d",
    #     f"bgptsample",
    #     "-c",
    #     f"{response.split()}"
    # ]

    # result = subprocess.run(cmd, capture_output = True, text = True, env = env)

    print(response.text)

def get_columns(data):
    database_name = data["databaseName"]
    table_name = data["tableName"]

    cmd = [
        "psql",
        "-h",
        "soc-sdp-27.soc.uconn.edu",
        "-U",
        "laravel_user",
        "-d",
        f"{database_name}",
        "-c",
        f"\\d \"{table_name}\""
    ]

    result = subprocess.run(cmd, capture_output = True, text = True, env = env)

    err = ""
    if not result.returncode == 0:
        err = "Couldn't process your request"
        print(f"Couldn't get columns from table {table_name} from database {database_name}: {result.stderr}")

    return err, result.stdout

def generate_sql_cmd(input, data):
    table_name = data["tableName"]
    err, columns = get_columns(data)

    if err:
        return err

    response = client.models.generate_content(
        model="gemini-2.0-flash",
        config=types.GenerateContentConfig(
            system_instruction=
            "You must only output the result."
            "No code block formatting."
            "Generate an PSQL command based on the user's request and don't say anything else."
            "If for some reason you can't, return false."
            "Surround the table name with double quotes."
            f"Here is the table name: {table_name}."
            "If necessary, find the closest match for the column name from the user's request, and surround it with double quotes."
            "You must select either the sample name or the gene symbol if present in the table."
            f"Here are the columns for that table:"
            f"{columns}"

        ),
        contents=input
    )

    r = response.text.strip()
    b = r.lower() == "false"
    sql = r

    err = ""
    if b:
        err = "Couldn't process your request"
        print(f"Couldn't generate sql cmd: {sql}")

    return err, sql

def execute_sql_cmd(sql, data):
    database_name = data["databaseName"]

    cmd = [
        "psql",
        "-h",
        "soc-sdp-27.soc.uconn.edu",
        "-U",
        "laravel_user",
        "-d",
        f"{database_name}",
        "-c",
        f"{sql}"
    ]

    result = subprocess.run(cmd, capture_output = True, text = True, env = env)

    err = ""
    if not result.returncode == 0:
        err = "Couldn't process your request"
        print(f"Couldn't execute sql cmd: {result.stderr}")
        print(f"The cmd is: {cmd}")

    print(f"The sql cmd is: {sql}")

    return err, result.stdout

def convert_to_json(input):
    response = client.models.generate_content(
        model="gemini-2.0-flash",
        config=types.GenerateContentConfig(
            system_instruction=
            "Take the result from an SQL query and convert it into JSON format."
            "In the JSON, it'll contain an array/list."
            "The name will either be sample name or gene symbol. Then convert it to camel case."
            "In the array/list, include all of the elements from the input."
            "No code blocks or any other type of formatting."
            "Don't say anything and just return the JSON."
        ),
        contents=input
    )

    with open("public/update_graph.json", "w") as f:
        f.write(response.text)

def chat_llm(input, data):
    chat = client.chats.create(
        model="gemini-2.0-flash",
        config=types.GenerateContentConfig(
            system_instruction=
            "You're a bone biologist."
            "Answer based on the user's input and the data (if they provided on)."
            "If you can't, say you don't know."
        ),
    )

    # if contains_tf_question(input):
    #     find_genes_in_tf(input, data)
    #     return "tf test"

    if should_gen_sql(input):
        err, sql_cmd = generate_sql_cmd(input, data)

        if err:
            return err

        err, sql_res = execute_sql_cmd(sql_cmd, data)

        if err:
            return err

        convert_to_json(sql_res)

        res = chat.send_message(
            f"This is the user's original input: {input}"
            f"This is the sql cmd: {sql_cmd}"
            f"This is the result of the sql cmd: {sql_res}"
        )
    else:
        res = chat.send_message(input)


    return res.text

if __name__ == "__main__":
    with open("public/columns.json", "r") as f:
        data = json.load(f)

    # print(json.dumps(data, indent=4))
    find_genes_in_tf("", data)
    r = chat_llm(input("Enter prompt: "), data)
    print("OUT:")
    print(r)
