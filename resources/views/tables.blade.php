<!DOCTYPE html>
<html>
<head>
    <title>Dynamic Tables Viewer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
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
</head>
<body class="p-4">

    <h2>Select Table to View</h2>
    <select id="tableSelector" class="form-select" onchange="loadTableData()">
        <option value="">-- Select Table --</option>
        @foreach($tables as $table)
            <option value="{{ $table }}">{{ $table }}</option>
        @endforeach
    </select>

    <h3 class="mt-4">Table Data</h3>
    <div id="tableContainer" class="mt-3">
        <p>Please select a table to view data.</p>
    </div>

    <!-- Chatbot Bubble and Container -->
<!-- Chatbot Bubble and Container -->
<div id="chatbot-bubble" class="chatbot-bubble">?</div>

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



    <script>
    const chatbotBubble = document.getElementById("chatbot-bubble");
    const chatbotContainer = document.getElementById("chatbot-container");
    const closeButton = document.getElementById("close-chatbot");
    const chatMessages = document.getElementById("chatbot-messages");
    const userInput = document.getElementById("user-input");
    const navigateGraph = document.getElementById("navigate-graph");

        function loadTableData() {
            const tableName = document.getElementById('tableSelector').value;
            if (!tableName) {
                document.getElementById('tableContainer').innerHTML = '<p>Please select a table to view data.</p>';
                return;
            }

            axios.get(`/tables/data/${tableName}`)
                .then(response => {
                    const data = response.data;
                    if (data.length === 0) {
                        document.getElementById('tableContainer').innerHTML = '<p>No data found.</p>';
                        return;
                    }

                    // Generate Table
                    let tableHtml = '<table class="table table-bordered table-striped"><thead><tr>';
                    const headers = Object.keys(data[0]);
                    headers.forEach(header => {
                        tableHtml += `<th>${header}</th>`;
                    });
                    tableHtml += '</tr></thead><tbody>';

                    data.forEach(row => {
                        tableHtml += '<tr>';
                        headers.forEach(header => {
                            tableHtml += `<td>${row[header]}</td>`;
                        });
                        tableHtml += '</tr>';
                    });

                    tableHtml += '</tbody></table>';
                    document.getElementById('tableContainer').innerHTML = tableHtml;
                })
                .catch(error => {
                    document.getElementById('tableContainer').innerHTML = `<p class="text-danger">Error loading data.</p>`;
                    console.error('Error loading table data:', error);
                });
        }
    

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
                const response = await fetch("http://127.0.0.1:5000/chatbot", {
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
                const response = await fetch("http://127.0.0.1:5000/rag-upload", {
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
            // 127.0.0.1:5000
            const response = await fetch("http://127.0.0.1:5000/generate-study", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({})
            });

            const data = await response.json();
            
            // Assuming your backend returns studyTitle and studySummary
            document.getElementById("title").value = data.studyTitle || "No Title Generated, Ensure you upload RAG document first";
            document.getElementById("summary").value = data.studySummary || "No Summary Generated, Ensure you upload RAG document first";
            document.getElementById("funding_sources").value = data.funding || "No Funding Generated, Ensure you upload RAG document first";
            document.getElementById("conflicts").value = data.conflicts || "No Funding Generated, Ensure you upload RAG document first";
            document.getElementById("completion_date").value = data.Date;
            if (data.published == 1) {
                document.getElementById("published_yes").checked = true;
            } 
            else {
                document.getElementById("published_no").checked = true;
            }
                        
            alert("Study Information Generated!");
        } catch (error) {
            console.error("Failed to generate study information", error);
            alert("Failed to generate study information.");
        }
    });

    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
