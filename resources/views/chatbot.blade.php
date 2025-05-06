<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ROSSA | Welcome to ROSSA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preload" as="style" href="https://rossa.dev.i3.uconn.edu/build/assets/app-DZym_wcr.css" />
    <link rel="modulepreload" href="https://rossa.dev.i3.uconn.edu/build/assets/app-z-Rg4TxU.js" />
    <link rel="stylesheet" href="https://rossa.dev.i3.uconn.edu/build/assets/app-DZym_wcr.css" data-navigate-track="reload" />
    <script type="module" src="https://rossa.dev.i3.uconn.edu/build/assets/app-z-Rg4TxU.js" data-navigate-track="reload"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    
    <!-- Livewire Styles -->
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

<body>
    <!-- Main Content of the Page -->
    <header class="mb-4">
        <nav class="navbar navbar-light bg-white">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img src="https://rossa.dev.i3.uconn.edu/images/ROSSA-logo3.png" alt="ROSSA Logo" class="img-fluid" style="max-height: 60px;">
                </a>
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link text-primary fw-bold" href="https://rossa.dev.i3.uconn.edu">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary opacity-75" href="https://rossa.dev.i3.uconn.edu/data-submission">Data Submission</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-primary opacity-75" href="#" id="coreFacilityDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Core Facility Registry
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="coreFacilityDropdown">
                            <li><a class="dropdown-item" href="https://rossa.dev.i3.uconn.edu/core-facility">View Facilities</a></li>
                            <li><a class="dropdown-item" href="https://rossa.dev.i3.uconn.edu/core-facility/create">Register New Facility</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary opacity-75" href="https://rossa.dev.i3.uconn.edu/team">Team Members</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary opacity-75" href="https://rossa.dev.i3.uconn.edu/terms-of-use">Terms of Use</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary opacity-75" href="https://rossa.dev.i3.uconn.edu/contact">Contact Us</a>
                    </li>
                    <!-- Add the gear icon here -->
                    <li class="nav-item">
                        <a href="{{ route('settings') }}" class="nav-link text-primary opacity-75">
                            <i class="fas fa-cog"></i> <!-- Font Awesome gear icon -->
                        </a>
                    </li>
                </ul>
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link text-primary opacity-75" href="https://rossa.dev.i3.uconn.edu">Login</a>
                    <li>
                </ul>
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link text-primary opacity-75" href="https://rossa.dev.i3.uconn.edu">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary opacity-75" href="https://rossa.dev.i3.uconn.edu">Create Account</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <main class="py-4">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h1 class="display-4">Welcome to the Rodent Open Science Skeletal Archive</h1>
                <p class="lead">Your gateway to advancing skeletal biology research through data sharing, collaboration, and innovation.</p>
            </div>

            <div class="row mb-5">
                <div class="col-md-12">
                    <p class="fs-5">The Rodent Open Science Skeletal Archive (ROSSA) is designed to preserve, share, and connect. Our platform offers researchers and institutions powerful tools to contribute, access, and collaborate in the pursuit of better treatments for skeletal diseases.</p>
                </div>
            </div>

            <div class="row">
                <!-- Feature 1: Contribute Your Data -->
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h3 class="card-title">Contribute Your Data</h3>
                            <p class="card-text">
                                Our streamlined data ingestion system allows researchers to submit skeletal phenotyping data effortlessly. We support various data types and ensure they are standardized and accessible, helping to build a global resource to accelerate discovery in skeletal biology.
                            </p>
                            <p class="card-text text-muted"><strong>Coming Soon:</strong> Detailed guidelines and tools to assist with data preparation and submission.</p>
                        </div>
                    </div>
                </div>

                <!-- Feature 2: Explore and Share Data -->
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h3 class="card-title">Explore and Share Data</h3>
                            <p class="card-text">
                                We’re developing a robust data center that will revolutionize how researchers interact with skeletal phenotyping data. The future data center will offer powerful tools for search, visualization, and sharing, making it easier than ever to access and utilize groundbreaking datasets.
                            </p>
                            <p class="card-text text-muted"><strong>Stay Tuned:</strong> Exciting features are in development and will be released soon.</p>
                        </div>
                    </div>
                </div>

                <!-- Feature 3: Core Facility Registry -->
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h3 class="card-title">Core Facility Registry</h3>
                            <p class="card-text">
                                The Core Facility Registry connects researchers with specialized resources. Core facilities can register to showcase their capabilities, and researchers can find the support they need for projects involving imaging, histology, or advanced computational services.
                            </p>
                            <p class="card-text text-muted"><strong>Get Involved:</strong> Whether managing a facility or searching for one, this registry will support your research goals.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <h2>Join Us in Advancing Skeletal Biology</h2>
                <p class="fs-5">ROSSA is more than a database—it’s a community-driven platform built to empower researchers, foster collaboration, and drive innovation in skeletal biology.</p>
                <a href="https://rossa.dev.i3.uconn.edu/contact" class="btn btn-primary btn-lg">Contact Us</a>
            </div>
        </div>
    </main>

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
        <a class="nav-link" id="chat-s-tab" data-bs-toggle="tab" href="#chat-s" role="tab">Chat-S</a>
    </li>
</ul>
<div class="tab-content" id="chatbot-tabs-content">
    <!-- Chat-R Tab -->
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
    <!-- Chat-S Tab -->
    <div class="tab-pane fade" id="chat-s" role="tabpanel">
        <div id="chatbot-s-messages" class="chatbot-messages"></div>
        <div class="chatbot-input-container">
            <input id="user-input-s" class="chatbot-input" type="text" placeholder="Type a message..." autocomplete="off">
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
            try {
                const response = await fetch("http://localhost:5000/chatbot", {
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
            // Scroll to the latest message
    }

    // Handle user input for Chat-S
const userInputS = document.getElementById("user-input-s");
const chatMessagesS = document.getElementById("chatbot-s-messages");

userInputS.addEventListener("keypress", async (e) => {
    if (e.key === "Enter") {
        e.preventDefault();
        const userMessage = userInputS.value.trim();
        if (userMessage === "") return;

        appendMessage(userMessage, "user", chatMessagesS);
        userInputS.value = ""; // Clear the input

        // Send user input to the backend LLM API for Chat-S
        try {
            const response = await fetch("http://localhost:5000/chatbot-s", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: new URLSearchParams({ message: userMessage }),
            });

            const data = await response.json();
            appendMessage(data.reply, "bot", chatMessagesS);
        } catch (error) {
            console.error("Error:", error);
            appendMessage("Could not get response.", "bot", chatMessagesS);
        }
    }
});

// Function to append messages to the correct chat container
function appendMessage(message, sender, container) {
    const div = document.createElement("div");
    div.classList.add("chat-bubble", sender);
    div.innerText = message;
    container.appendChild(div);
    setTimeout(() => {
        container.scrollTop = container.scrollHeight;
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
                const response = await fetch("http://localhost:5000/rag-upload", {
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
    </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>

</html>
