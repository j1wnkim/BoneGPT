@extends('layout')

@section('title', 'Study Information')

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
    <h1 class="mb-4">Study Information</h1>

    <!-- Action is just a placeholder since we won't store the data -->
    <form method="GET" action="{{ route('study.study-information', ['study' => 1]) }}" >
        @csrf
        
        <div class="mb-3">
            <label for="title" class="form-label">Study Title</label>
            <input type="text" class="form-control" 
                   id="title" name="title" value="" >
        </div>

        <div class="mb-3">
            <label for="summary" class="form-label">Study Summary</label>
            <div class="d-flex">
                <textarea class="form-control" 
                        id="summary" name="summary" rows="4" ></textarea>
                <button type="button" class="btn btn-info ms-2" id="toggle-info">View abstract</button>
            </div>
        </div>
        
        <div id="study-info-box" class="p-3 border rounded bg-light mt-2" style="display: none;">
            <h5>Abstract</h5>
            <p id="study-info-content">No information available.</p>
        </div>


        <div class="mb-3">
            <label for="funding_sources" class="form-label">Funding Sourcess</label>
            <textarea class="form-control" id="funding_sources" name="funding_sources" rows="2" ></textarea>
        </div>

        <div class="mb-3">
            <label for="conflicts" class="form-label">Conflicts of Interest</label>
            <textarea class="form-control" id="conflicts" name="conflicts" rows="2" ></textarea>
        </div>

        <div class="mb-3">
            <label for="completion_date" class="form-label">Study Completion Date</label>
            <input class="form-control" 
                   id="completion_date" name="completion_date" 
                   value="" >
        </div>

        <h2 class="h4 mt-5 mb-4">Publication Information</h2>

        <div x-data="{ 
            isPublished: {'false')},
            publicationPlan: '{{ old('is_published') == '1' ? '' : (old('publication_plan', $study->publication_plan ?? '')) }}',
            showSpecialIssueInfo() { return this.publicationPlan === 'special_issue' },
            showEmbargoField() { return this.publicationPlan === 'different_journal' }
        }">
            <div class="mb-3">
                <label class="form-label">Has this study been published?</label>
                <div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" 
                               name="is_published" id="published_yes" value="1"
                               x-model="isPublished" >
                        <label class="form-check-label" for="published_yes">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" 
                               name="is_published" id="published_no" value="0"
                               x-model="isPublished" >
                        <label class="form-check-label" for="published_no">No</label>
                    </div>
                </div>
            </div>
            
        </div>

        <div class="mt-4 d-flex">
            <button type="button" class="btn btn-primary" >Save</button> <!-- Disabled Save Button -->
            
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
            // http://soc-sdp-27.soc.uconn.edu/api/chatbot
            // Send user input to the backend LLM API
            // original url: http://127.0.0.1:5000/chatbot
            //https://rossa.soc.uconn.edu/api/rag-upload
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

    document.getElementById("toggle-info").addEventListener("click", function () {
        let infoBox = document.getElementById("study-info-box");
        if (infoBox.style.display === "none" || infoBox.style.display === "") {
            infoBox.style.display = "block"; // Show box
            document.getElementById("study-info-content").innerText = "This study focuses on ... (you can dynamically load data here)";
        } else {
            infoBox.style.display = "none"; // Hide box
        }
    });

    // Handle file upload for RAG
    document.getElementById("upload-form").addEventListener("submit", async (e) => {
        e.preventDefault();
        
        const formData = new FormData(); // hey this is JiWon 
        const ragFile = document.getElementById("rag-file").files[0];

        if (ragFile) {
            formData.append("file", ragFile);
            // this is JiWon 
            try {
                // "http://127.0.0.1:5000/data-chatbot"
                //
                //127.0.0.1:5000
                //http://soc-sdp-27.soc.uconn.edu/api/rag-upload
                const response = await fetch("https://rossa.soc.uconn.edu/api/rag-upload", {
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
    document.getElementById("generate-study-btn").addEventListener("click", async () => {
        try {
            //http://soc-sdp-27.soc.uconn.edu/api
            // 127.0.0.1:5000
            const response = await fetch("https://rossa.soc.uconn.edu/api/simultaneous_generate_text", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({})
            });
        
            const data = await response.json();
            alert("Study information genearated!")
            document.getElementById("title").value = data.study_information.studyTitle || "No Title Generated, Ensure you upload RAG document first";
            document.getElementById("summary").value = data.study_information.studySummary || "No Summary Generated, Ensure you upload RAG document first";
            document.getElementById("funding_sources").value = data.study_information.funding || "No Funding Generated, Ensure you upload RAG document first";
            document.getElementById("conflicts").value = data.study_information.conflicts || "No Funding Generated, Ensure you upload RAG document first";
            document.getElementById("completion_date").value = data.study_information.Date;
            if (data.published == 1) {
                document.getElementById("published_yes").checked = true;
            } 
            else {
                document.getElementById("published_no").checked = true;
            }
                    
        } catch (error) {
            console.error("Failed to generate study information", error);
            alert("Failed to generate study information.");
        }
    });

    document.addEventListener("DOMContentLoaded", () => {
    // Function to populate fields from output_answer.json
    async function populateFields() {
        try {
            const response = await fetch("/home/sdp/laravel-app/output_answer.json");
            const data = await response.json();

            // Populate fields
            document.getElementById("title").value = data.study_information.studyTitle || "No Title Available";
            document.getElementById("summary").value = data.study_information.studySummary || "No Summary Available";
            document.getElementById("funding_sources").value = data.study_information.funding || "No Funding Information";
            document.getElementById("conflicts").value = data.study_information.conflicts || "No Conflict Information";
            document.getElementById("completion_date").value = data.study_information.Date || "No Completion Date";

            // Handle published status
            if (data.published == 1) {
                document.getElementById("published_yes").checked = true;
            } else {
                document.getElementById("published_no").checked = true;
            }
        } catch (error) {
            console.error("Failed to load study information from output_answer.json", error);
        }
    }

    // Event listener for tab switching
    document.getElementById("study-information-tab").addEventListener("click", () => {
        populateFields();
    });
});






    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
@endsection
