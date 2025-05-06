{{-- resources/views/chart.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TF List Gene Graph</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Basic styling for the page */
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f4f4f4;
        }
        #chart-container {
            max-width: 1000px;
            margin: auto;
            overflow-x: auto; /* Enable horizontal scrolling */
        }
        #gene-info {
            margin-top: 30px;
        }
        #gene-list {
            margin-top: 20px;
            height: 300px;
            overflow-y: scroll; /* Make the list scrollable */
            border: 1px solid #ccc;
            padding: 10px;
        }
        .gene-item {
            padding: 5px;
            cursor: pointer;
        }
        .gene-item:hover {
            background-color: #f0f0f0;
        }
        #search-bar {
            margin-bottom: 20px;
            padding: 8px;
            width: 100%;
            max-width: 300px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

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

    <h1>TF List Gene Graph</h1>

    <!-- Dropdown to switch between chart types -->
    <label for="chart-type">Choose chart type:</label>
    <select id="chart-type" onchange="changeChartType()">
        <option value="bar">Bar Chart</option>
        <option value="scatter">Scatter Plot</option>
        <option value="line">Line Chart</option>
    </select>

    <!-- Canvas for the chart -->
    <div id="chart-container">
        <canvas id="chart" width="1200" height="500"></canvas>
    </div>

    <!-- Search Bar for Genes -->
    <input type="text" id="search-bar" placeholder="Search for a gene..." onkeyup="filterGenes()">

    <!-- Gene List Section -->
    <div id="gene-list">
        <h3>Select a Gene</h3>
        <!-- Dynamically render genes here -->
        <ul id="gene-list-items">
            @foreach($geneSymbols as $gene)
                <li class="gene-item" onclick="showGeneInfo('{{$gene}}')">{{ $gene }}</li>
            @endforeach
        </ul>
    </div>

    <!-- Gene Info Section -->
    <div id="gene-info">
        <h3>Gene Information</h3>
        <p id="gene-details">Select a gene to see more details.</p>
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

    <script>
        // Data passed from the controller
        var geneSymbols = @json($geneSymbols); // Gene symbols for x-axis
        var geneDetails = @json($geneDetails); // Details for each gene

        // Initialize chart type
        var chartType = 'bar';

        // Create the initial chart
        var ctx = document.getElementById('chart').getContext('2d');
        var chartData = {
            labels: geneSymbols, // Gene symbols on the x-axis
            datasets: [{
                label: 'Genes',
                data: geneSymbols.map(function() { return 1; }), // Just assign a dummy value since we don't have frequency
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

        var chartOptions = {
            scales: {
                y: {
                    beginAtZero: true,
                    display: false // Hide y-axis since it's irrelevant here
                },
                x: {
                    ticks: {
                        maxRotation: 90, // Rotate the labels more
                        minRotation: 45, // Rotate the labels to avoid overlapping
                        padding: 20 // Add padding between the bars/labels
                    }
                }
            },
            onClick: function (event, elements) {
                if (elements.length > 0) {
                    var index = elements[0].index;
                    var geneSymbol = geneSymbols[index];
                    var geneInfo = geneDetails[geneSymbol];
                    
                    // Display gene information
                    document.getElementById('gene-details').innerHTML = `
                        <strong>Gene:</strong> ${geneSymbol} <br>
                        <strong>DBD:</strong> ${geneInfo.DBD} <br>
                        <strong>Motif status:</strong> ${geneInfo['Motif status']} <br>
                        <strong>IUPAC Consensus:</strong> ${geneInfo['IUPAC Consensus']}
                    `;
                }
            }
        };

        var myChart = new Chart(ctx, {
            type: chartType, // Default chart type
            data: chartData,
            options: chartOptions
        });

        // Function to change chart type dynamically
        function changeChartType() {
            chartType = document.getElementById('chart-type').value;
            myChart.destroy(); // Destroy the current chart
            myChart = new Chart(ctx, {
                type: chartType, // New chart type
                data: chartData,
                options: chartOptions
            });
        }

        // Function to display gene info when clicked from the list
        function showGeneInfo(gene) {
            var geneInfo = geneDetails[gene];
            document.getElementById('gene-details').innerHTML = `
                <strong>Gene:</strong> ${gene} <br>
                <strong>DBD:</strong> ${geneInfo.DBD} <br>
                <strong>Motif status:</strong> ${geneInfo['Motif status']} <br>
                <strong>IUPAC Consensus:</strong> ${geneInfo['IUPAC Consensus']}
            `;
        }

        // Function to filter genes based on the search input
        function filterGenes() {
            var input = document.getElementById('search-bar').value.toLowerCase();
            var geneItems = document.querySelectorAll('.gene-item');
            
            geneItems.forEach(function(item) {
                var geneName = item.textContent.toLowerCase();
                if (geneName.indexOf(input) > -1) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        }
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
