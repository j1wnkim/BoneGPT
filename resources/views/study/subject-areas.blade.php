@extends('layout')

@section('title', 'Subject Areas')

@section('content')
<style>
        /* Add your chatbot-specific styles here */
        .chatbot-bubble {
            position: fixed;
            word-wrap: break-word;
            max-width: 80%;
            padding: 10px;
            border-radius: 12px;
            margin-bottom: 10px;
        }

        .chatbot-container {
            display: none;
            overflow-y: auto;
            position: fixed;
            bottom: 20px;
            right: 20px;
            scroll-behavior: smooth;
            background-color: #ffffff;
            width: 350px;
            max-height: 500px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;

        }

        .chatbot-header {
            background-color: #3b82f6;
            color: white;
            padding: 10px;
            border-radius: 12px 12px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 50px; /* Fixed height for header */
        }

        .chatbot-header button {
            background: transparent;
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
        }

        .chatbot-messages {
            padding: 10px;
            overflow-y: auto;
            flex-grow: 1;
            max-height: 300px; /* Adjust height to fit inside the chatbot */
            padding-bottom: 60px;
            word-wrap: break-word; /* Ensure text wraps properly */
            display: flex;
            flex-direction: column;
            scrollbar-width: thin; /* Optional: makes scrollbar less intrusive */
        }

        .chatbot-input-container {
            display: flex;
            padding: 10px;
            border-top: 1px solid #ddd;
            height: 50px;
            justify-content: space-between;
            align-items: center;
            position: absolute;
            bottom: 0;
            width: 100%;
            box-sizing: border-box;
            background: white;
        }

        .chatbot-input {
            width: 100%;
            padding: 8px;
            border-radius: 25px;
            border: 1px solid #ddd;
            outline: none;
            resize: none; /* Disable resizing the input box */
            box-sizing: border-box; /* Make sure padding doesn't overflow */
        }

        .chat-bubble {
            padding: 12px;
            border-radius: 12px;
            max-width: 80%;
            margin-bottom: 10px;
            word-wrap: break-word; /* Ensure text stays within the bubble */
            overflow-wrap: break-word; /* Alternative for better support */
        }

        .chat-bubble.bot {
            background-color: #f0f0f0;
            margin-right: auto;
        }

        .chat-bubble.user {
            background-color: #3b82f6;
            color: white;
            margin-left: auto;
        }

        .navigate-button {
            background-color: #3b82f6;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            margin-top: 20px;
        }

        .tab-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .nav-tabs .nav-link {
            cursor: pointer;
        }
        .nav-link i.fa-cog {
            font-size: 20px; /* Adjust size */
            margin-left: 5px; /* Add spacing from the "Contact Us" button */
            color: #333; /* Default color */
                            }

        .nav-link i.fa-cog:hover {
            color: #007bff; /* Change color on hover */
                            }

</style>



<div class="container">
    <h1 class="mb-4">Subject Areas</h1>
    <form method="GET" action="{{ route('study.subject-areas', ['study' => $study['id']]) }}" hx-boost="true" data-confirmchanges>
        @csrf
        <div class="row">
            @foreach(App\Models\Study::getSubjectAreaCategories() as $category => $areas)
                <div class="col-md-3">
                    <h4>{{ $category }}</h4>
                    @foreach($areas as $key => $label)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" 
                                   name="subject_areas[]" value="{{ $key }}" id="{{ $key }}"
                                   {{ in_array($key, old('subject_areas', $study->subject_areas ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="{{ $key }}">{{ $label }}</label>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

        <div class="mt-4 d-flex">
            <button type="submit" class="btn btn-primary">Save</button>
            
        </div>
    </form>
</div>
<!-- Chatbot Bubble and Container -->
<div id="chatbot-bubble" class="chatbot-bubble">
        ?
    </div>

    <div id="chatbot-container" class="chatbot-container">
        <div class="chatbot-header">
            <span>Chatbot</span>
            <button id="close-chatbot">×</button>
        </div>
        <!-- Tabs for Chat and RAG -->
        <ul class="nav nav-tabs" id="chatbot-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="chat-tab" data-bs-toggle="tab" href="#chat" role="tab">Chat-R</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="rag-tab" data-bs-toggle="tab" href="#rag" role="tab">RAG</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="new-chat-tab" data-bs-toggle="tab" href="#new-chat" role="tab">Chat-S</a>
            </li>
        </ul>
        <div class="tab-content" id="chatbot-tabs-content">
            <!-- Chat Tab -->
            <div class="tab-pane fade show active" id="chat" role="tabpanel">
                <div id="chatbot-messages" class="chatbot-messages"></div>
                <div class="chatbot-input-container">
                    <input id="user-input" class="chatbot-input" type="text" placeholder="Type a message..." autocomplete="off">
                </div>
                <!-- View Graphical Data Button -->
                <div id="navigate-graph" class="text-center mt-3 hidden">
                    <a href="/chart" class="btn btn-primary btn-lg">View Graphical Data</a>
                </div>
            </div>
            <!-- RAG Tab -->
            <div class="tab-pane fade" id="rag" role="tabpanel">
                <div class="text-center p-3">
                    <h5>Upload Your Files</h5>
                    <form id="upload-form" enctype="multipart/form-data">
                        <input type="file" name="rag-file" id="rag-file" class="form-control mb-2" accept="application/*">
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>
            </div>
            <div class="tab-pane fade" id="new-chat" role="tabpanel">
                <div id="new-chat-messages" class="chatbot-messages"></div>
                    <div class="chatbot-input-container">
                        <input id="new-chat-input" class="chatbot-input" type="text" placeholder="Type a message..." autocomplete="off">
                    </div>
            </div>
        </div>
    </div>

    <div style="position: fixed; bottom: 20px; right: 370px; z-index: 10000;">
        <button id="generate-study-btn" class="btn btn-success" style="display: block; visibility: visible;">Click here to generate study information</button>
    </div>

    <div id="checkbox-values" style="margin-top: 20px;"></div>


    <!-- <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (data.subjectAreas && Array.isArray(data.subjectAreas)) {
                // Uncheck all checkboxes first (optional, to reset selection)
                document.querySelectorAll('input[name="subject_areas[]"]').forEach(checkbox => {
                    checkbox.checked = true;
                });
            }
        });
    </script> -->

    <script>
    const chatbotBubble = document.getElementById("chatbot-bubble");
    const chatbotContainer = document.getElementById("chatbot-container");
    const closeButton = document.getElementById("close-chatbot");
    const chatMessages = document.getElementById("chatbot-messages");
    const userInput = document.getElementById("user-input");
    const navigateGraph = document.getElementById("navigate-graph");

    // Open chatbot container
    chatbotBubble.addEventListener("click", () => {
        chatbotContainer.style.display = "flex";
        chatbotBubble.style.display = "none";
    });

    // Close chatbot container
    closeButton.addEventListener("click", () => {
        chatbotContainer.style.display = "none";
        chatbotBubble.style.display = "flex";
    });

    // Handle user input
    userInput.addEventListener("keypress", async (e) => {
        if (e.key === "Enter") {
            e.preventDefault();
            const userMessage = userInput.value.trim();
            if (userMessage === "") return;

            appendMessage(userMessage, "user");
            userInput.value = ""; // Clear the input
            
            // Send user input to the backend LLM API
            // original url: http://127.0.0.1:5000/chatbot
            try {
                const response = await fetch("https://rossa.soc.uconn.edu/api/chatbot", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: new URLSearchParams({ message: userMessage }),
                });

                const data = await response.json();
                appendMessage(data.reply, "bot");
            } catch (error) {
                console.error("Error:", error);
                appendMessage("Could not get response.", "bot");
            }
        }
    });

    function appendMessage(message, sender) {
        const div = document.createElement("div");
        div.classList.add("chat-bubble", sender);
        div.innerText = message;
        chatMessages.appendChild(div);
        setTimeout(() => {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }, 100);
    }

    // Handle file upload for RAG
    document.getElementById("upload-form").addEventListener("submit", async (e) => {
        e.preventDefault();
        
        const formData = new FormData();
        const ragFile = document.getElementById("rag-file").files[0];

        if (ragFile) {
            formData.append("file", ragFile);
            
            try {
                //127.0.0.1:5000
                const response = await fetch("https://rossa.soc.uconn.edu/api/rag-upload-2", {
                    method: "POST",
                    body: formData,
                });

                const data = await response.json();
                alert(data.message); // Notify user of upload status
            } catch (error) {
                console.error("Error uploading file:", error);
                alert("Error uploading file.");
            }
        } else {
            alert("Please select a file before uploading.");
        }
    });

//     document.getElementById("generate-study-btn").addEventListener("click", () => {
//     const list1 = ["aging", "autophagy", "bone_development", "bone_metabolism", "bone_remodeling", "circadian_rhythm"];
//     const list2 = ["adipose_tissue", "digestive_system", "endocrine_system", "immune_system"];
//     const list3 = ["bone_lining_cells", "chondrocyte", "osteoblast"];
//     const list4 = ["osteopenia", "osteoporosis", "osteopetrosis"];
//     const checkboxValuesDiv = document.getElementById("checkbox-values");
//     checkboxValuesDiv.innerHTML = "";
//     // Select checkboxes that are in list1
//     document.querySelectorAll('input[name="subject_areas[]"]').forEach(checkbox => {
//         if (list1.includes(checkbox.value)||list2.includes(checkbox.value)||list3.includes(checkbox.value)||list4.includes(checkbox.value)) {
//             checkbox.checked = true;
//         } else {
//             checkbox.checked = false; // Uncheck others
//         }
//         const valueElement = document.createElement("div");
//         valueElement.textContent = checkbox.value + ": " + (checkbox.checked ? "checked" : "unchecked");
//         checkboxValuesDiv.appendChild(valueElement);
//     });
//     alert("Relevant checkboxes have been selected!");
// });

// document.getElementById("generate-study-btn-2").addEventListener("click", async () => {
//     try {
//         // 127.0.0.1:5000
//         const response = await fetch("https://rossa.soc.uconn.edu/api/generate-study-2", {
//             method: "POST",
//             headers: {
//                 "Content-Type": "application/json"
//             },
//             body: JSON.stringify({})
//         });

//         const data = await response.json();
//         alert("Study Information Generated!");

//         if (data.list1 && data.list2 && data.list3 && data.list4) {
//             // Combine all lists into a single array
//             const combinedList = [...data.list1, ...data.list2, ...data.list3, ...data.list4];

//             const checkboxValuesDiv = document.getElementById("checkbox-values");
//             checkboxValuesDiv.innerHTML = "<h3>Combined List:</h3>";
//             const combinedListElement = document.createElement("div");
//             combinedListElement.textContent = JSON.stringify(combinedList, null, 2);
//             checkboxValuesDiv.appendChild(combinedListElement);

//             // Uncheck all checkboxes first (optional, to reset selection)
//             document.querySelectorAll('input[name="subject_areas[]"]').forEach(checkbox => {
//                 checkbox.checked = false;
//             });
            

//             // Select checkboxes that are in list1
//             document.querySelectorAll('input[name="subject_areas[]"]').forEach(checkbox => {
//                 if (combinedList.includes(checkbox.value)) {
//                     checkbox.checked = true;
//                 } else {
//                     checkbox.checked = false; // Uncheck others
//                 }

//                 const valueElement = document.createElement("div");
//                 valueElement.textContent = checkbox.value + ": " + (checkbox.checked ? "checked" : "unchecked");
//                 checkboxValuesDiv.appendChild(valueElement);
//             });
            
//             const dataElement = document.createElement("div");
//             dataElement.innerHTML = "<h3>Response Data:</h3>";
//             dataElement.textContent = JSON.stringify(data, null, 2);
//             checkboxValuesDiv.appendChild(dataElement);

//             alert("Relevant checkboxes have been selected!");
//         }
//     } catch (error) {
//         console.error("Failed to generate study information", error);
//         alert("Failed to generate study information.");
//     }
// });

document.getElementById("generate-study-btn").addEventListener("click", async () => {
    try {
        // 127.0.0.1:5000
        const response = await fetch("https://rossa.soc.uconn.edu/api/simultaneous_generate_text_2", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({})
        }); // generate the response. 
        const data = await response.json(); // retrieve the response. 

        const saveResponse = await fetch("https://rossa.soc.uconn.edu/api/save_data", { /// save the data into a json file!! 
        method: "POST",
        headers: {
        "Content-Type": "application/json"
        },
        body: JSON.stringify(data)
        });

        if (saveResponse.ok){ // double check whether the data was saved or not. 
            const result = await saveResponse.json();
            console.log("Data saved to:", result.file_path);
        }else{
            console.error("Failed to save data:", saveResponse.statusText);
        }
        alert("Study Information Generated!");

        if (data.subject_areas.list1 && data.subject_areas.list2 && data.subject_areas.list3 && data.subject_areas.list4) {
            // Combine all lists into a single array
            const combinedList = [...data.subject_areas.list1, ...data.subject_areas.list2, ...data.subject_areas.list3, ...data.subject_areas.list4];

            const checkboxValuesDiv = document.getElementById("checkbox-values");
            checkboxValuesDiv.innerHTML = "<h3>Combined List:</h3>";
            const combinedListElement = document.createElement("div");
            combinedListElement.textContent = JSON.stringify(combinedList, null, 2);
            checkboxValuesDiv.appendChild(combinedListElement);

            // Uncheck all checkboxes first (optional, to reset selection)
            document.querySelectorAll('input[name="subject_areas[]"]').forEach(checkbox => {
                checkbox.checked = false;
            });
            

            // Select checkboxes that are in list1
            document.querySelectorAll('input[name="subject_areas[]"]').forEach(checkbox => {
                if (combinedList.includes(checkbox.value)) {
                    checkbox.checked = true;
                } else {
                    checkbox.checked = false; // Uncheck others
                }

                const valueElement = document.createElement("div");
                valueElement.textContent = checkbox.value + ": " + (checkbox.checked ? "checked" : "unchecked");
                checkboxValuesDiv.appendChild(valueElement);
            });
            
            const dataElement = document.createElement("div");
            dataElement.innerHTML = "<h3>Response Data:</h3>";
            dataElement.textContent = JSON.stringify(data, null, 2);
            checkboxValuesDiv.appendChild(dataElement);


            await fetch("https://rossa.soc.uconn.edu/api/clear_saved_data", { /// clear the saved data after the data has been saved. 
            method: "POST"
            }); 
            alert("Relevant checkboxes have been selected!"); 

        }
    } catch (error) {
        console.error("Failed to generate study information", error); 
        alert("Failed to generate study information."); 
    }
});


// document.getElementById("generate-study-btn").addEventListener("click", async () => {
//     try {
//         // 127.0.0.1:5000
//         const response = await fetch("https://rossa.soc.uconn.edu/api/generate-study-2", {
//             method: "POST",
//             headers: {
//                 "Content-Type": "application/json"
//             },
//             body: JSON.stringify({})
//         });

//         const data = await response.json();
            
//         // Assuming your backend returns studyTitle and studySummary
            
//         if (data.subjectAreas && Array.isArray(data.subjectAreas)) {
//         // Uncheck all checkboxes first (optional, to reset selection)
//         document.querySelectorAll('input[name="subject_areas[]"]').forEach(checkbox => {
//             checkbox.checked = false;
//         });

//         list1 = ["Aging", "Autophagy", "Bone Development", "Bone Metabolism", "Bone Remodeling", "Circadian Rhythm"]
//         list2 = ["Adipose Tissue", "Digestive System", "Endocrine System", "Immune System"]
//         list3 = ["Bone Lining Cells", "Chondrocyte", "Osteoblast"]
//         list4 = ["Osteopenia", "Osteoporosis", "Osteopetrosis"]

//          // **Selecting Checkboxes if any output message matches list_message**
//         if (data.list1 && data.list2 && data.list3 && data.list4) {
//         const outputValues = [data.list1, data.list2, data.list3, data.list4];

//         document.querySelectorAll('input[name="subject_areas[]"]').forEach(checkbox => {
//             if (outputValues.includes(checkbox.value)) {
//                 checkbox.checked = true;
//             } else {
//                 checkbox.checked = false; // Reset others//             }
//         });
//     }
                        
//         alert("Study Information Generated!");
//     } catch (error) {
//         console.error("Failed to generate study information", error);
//         alert("Failed to generate study information.");
//     }
// }});

</script>

 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->

</body>
</html>
@endsection