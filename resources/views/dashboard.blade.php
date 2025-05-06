<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Gene Data Visualization</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <style>
            canvas {
                max-height: 600px;
                width: 100%;
            }
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 20px;
                background-color: #f4f4f9;
            }
            .container {
                max-width: 600px;
                margin: 0 auto;
                background-color: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                margin-bottom: 20px;
            }
            h1 {
                text-align: center;
                color: #333;
            }
            label {
                display: block;
                margin-bottom: 8px;
                font-weight: bold;
                color: #555;
            }
            input, textarea {
                width: 100%;
                padding: 8px;
                margin-bottom: 15px;
                border: 1px solid #ccc;
                border-radius: 4px;
                font-size: 14px;
            }
            textarea {
                resize: vertical;
            }
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
            .highlight {
                background-color: yellow; /* Highlight background */
                border: 2px solid red; /* Add a red border */
                border-radius: 5px; /* Optional: rounded corners */
                padding: 5px; /* Optional: add padding */
                transition: all 0.3s ease-in-out; /* Smooth transition */
            }

            .highlight:hover {
                background-color: orange; /* Change to orange on hover */
                border-color: blue; /* Change border to blue */
            }

        </style>
    </head>
    <body class="p-4">
        <h2>Gene Data Visualization Dashboard</h2>

            <!-- Database Selection Tabs
        <ul class="nav nav-tabs" id="database-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="database-tab" data-bs-toggle="tab" href="#database-section" role="tab">Database</a>
            </li>
        </ul> -->

        <div class="tab-content" id="database-tabs-content">
            <!-- Database Selection Tab -->
            <div class="tab-pane fade show active" id="database-section" role="tabpanel">
                <div class="mb-3">
                    <label for="databaseSelector" class="form-label">Select Database</label>
                    <select id="databaseSelector" class="form-select" onchange="loadTables()">
                        <option value="">-- Select Database --</option>
                        <option value="het50">het50</option>
                        <option value="komp220">komp220</option>
                    </select>
                    <div id="loadingIndicator" style="display: none; margin-top: 10px;">
                        <span class="spinner-border spinner-border-sm text-primary" role="status" aria-hidden="true"></span>
                        Loading tables...
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="tableSelector" class="form-label">Select Table</label>
            <select id="tableSelector" class="form-select" onchange="loadTableColumns()">
                <option value="">-- Select Table --</option>
                @foreach($tables as $table)
                    <option value="{{ $table }}">{{ $table }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="xAxisSelector" class="form-label">Select X-Axis Column</label>
            <select id="xAxisSelector" class="form-select">
                <option value="">-- Select Column --</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="yAxisSelector" class="form-label">Select Y-Axis Column</label>
            <select id="yAxisSelector" class="form-select">
                <option value="">-- Select Column --</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="chartTypeSelector" class="form-label">Select Chart Type</label>
            <select id="chartTypeSelector" class="form-select">
                <option value="bar">Bar Chart</option>
                <option value="line">Line Chart</option>
                <option value="pie">Pie Chart</option>
                <option value="scatter">Scatter Plot</option>
            </select>
        </div>

        <div class="mb-3">
            <button class="btn btn-primary" onclick="loadAndPlot()">Load Data & Plot</button>
        </div>

        <div class="mt-4">
            <canvas id="geneChart"></canvas>
        </div>

        <!-- Chatbot Bubble and Container -->
        <div id="chatbot-bubble" class="chatbot-bubble">
            ?
        </div>

        <!-- Chatbot Toggle Button -->
        <!-- <div id="toggle-chatbot-button" class="toggle-chatbot-button" onclick="toggleChatWindow()">Chat</div> -->


        <div id="chatbot-container" class="chatbot-container">
            <div class="chatbot-header">
                <span>Chatbot</span>
                <button id="close-chatbot">×</button>
            </div>
            <!-- Tabs for Chat and RAG -->
            <ul class="nav nav-tabs" id="chatbot-tabs" role="tablist">


                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="new-chat-tab" data-bs-toggle="tab" href="#new-chat" role="tab">Chat-S</a>
                </li>
                <!-- Dropdown Menu -->
                <li class="nav-item dropdown" role="presentation">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        Database Queries
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" id="dropdown-options">
                        <!-- Buttons will appear here dynamically -->
                        <li><button class="dropdown-item option-btn">What are the sexual dimorphism genes?</button></li>
                        <li><button class="dropdown-item option-btn">Which ones are transcription factor genes?</button></li>
                        <li><button class="dropdown-item option-btn">Which ones are involved in Wnt pathway?</button></li>
                        <li><button class="dropdown-item option-btn">Which ones are immune related genes?</button></li>
                        <li><button class="dropdown-item option-btn">Which ones have both BV/TV and BS/TV at top 5%?</button></li>
                    </ul>
                </li>


            </ul>
            <div class="tab-content" id="chatbot-tabs-content">
                <!-- Chat Tab -->
                <div class="tab-pane fade show active" id="chat" role="tabpanel">
                    <div id="chatbot-messages" class="chatbot-messages"></div>
                    <div class="chatbot-input-container">
                        <input id="user-input" class="chatbot-input" type="text" placeholder="Type a message..." autocomplete="off">
                    </div>
                </div>
                <!-- RAG Tab -->

                <div class="tab-pane fade" id="new-chat" role="tabpanel">
                    <div id="new-chat-messages" class="chatbot-messages"></div>
                        <div class="chatbot-input-container">
                            <input id="new-chat-input" class="chatbot-input" type="text" placeholder="Type a message..." autocomplete="off">
                        </div>
                </div>
            </div>
        </div>

        <div style="position: fixed; bottom: 20px; right: 60px; z-index: 10000;">
        <button id="toggle-chatbot-button" class="btn btn-success" onclick="toggleChatWindow()"
                style="display: block; visibility: visible;
                       background-color: rgba(0, 128, 0, 0.5); /* Transparent green */
                       border: 2px solid rgba(0, 128, 0, 0.7); /* Green border */
                       color: white; /* Text color */
                       font-size: 12px; /* Smaller text */
                       padding: 8px 16px; /* Smaller padding */
                       border-radius: 8px; /* Rounded corners */
                       opacity: 0.8; /* Semi-transparent button */
                       transition: opacity 0.3s ease-in-out;">
            Open Chat
        </button>
    </div>
    <div style="position: fixed; bottom: 20px; left: 60px; z-index: 10000;">
        <button id="highlightModeToggle" class="btn btn-secondary">Enable Highlight Mode</button>
    </div>



    <!-- Modal for displaying point data -->
    <div class="modal fade" id="pointDataModal" tabindex="-1" aria-labelledby="pointDataModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pointDataModalLabel">Point Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="pointDataContent">
                        <!-- Data will be dynamically inserted here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="showInfoButton">Show Image</button>
                    <button type="button" class="btn btn-info" id="showGeneSummaryButton" onclick="navigateToGeneSummary()">Show Gene Summary</button>
                    <button type="button" class="btn btn-danger" onclick="clearSelectedPoints()">Clear Selection</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let chartInstance = null;

        function loadTableColumns() {
            const loadingIndicator = document.getElementById('loadingIndicator');
            const tableName = document.getElementById('tableSelector').value;
            if (!tableName) {
                alert('Please select a table first');
                return;
            }

            axios.get(`/tables/columns/${tableName}`)
                .then(response => {
                    const columns = response.data;

                    axios.post('/log', {
                        message: `Response from ${columns}`,
                        level: 'info',
                        response: columns
                    });

                    // Selectors for X and Y axes
                    const xAxisSelector = document.getElementById('xAxisSelector');
                    const yAxisSelector = document.getElementById('yAxisSelector');

                    // Reset existing options for both dropdowns
                    xAxisSelector.innerHTML = '<option value="">-- Select Column --</option>';
                    yAxisSelector.innerHTML = '<option value="">-- Select Column --</option>';

                    // Populate both dropdowns
                    columns.forEach(column => {
                        // Add option for X-axis
                        const xOption = document.createElement('option');
                        xOption.value = column;
                        xOption.textContent = column;
                        xAxisSelector.appendChild(xOption);

                        // Add option for Y-axis
                        const yOption = document.createElement('option');
                        yOption.value = column;
                        yOption.textContent = column;
                        yAxisSelector.appendChild(yOption);
                    });

                    // Log success to Laravel logs
                    axios.post('/log', {
                        message: `Columns loaded successfully for table: ${tableName}`,
                        level: 'info',
                        xAxisOptions: Array.from(xAxisSelector.options).map(option => option.textContent),
                        yAxisOptions: Array.from(yAxisSelector.options).map(option => option.textContent)
                    });
                })
                .catch(error => {
                    // Log error details to Laravel logs
                    axios.post('/log', {
                        message: `Error loading columns for table: ${tableName}`,
                        level: 'error',
                        details: error.response ? error.response.data : error.message
                    });

                    alert('Failed to load columns. Please check the console for more details.');
                })
                .finally(() => {
                    // Hide the loading indicator
                    loadingIndicator.style.display = 'none';
                });
        }

        function highlightDropdownOption(selectorId) {
            const dropdown = document.getElementById(selectorId);
            const selectedOption = dropdown.options[dropdown.selectedIndex];

            // Remove highlight from all options
            Array.from(dropdown.options).forEach(option => option.classList.remove('highlight'));

            // Add highlight to the selected option
            selectedOption.classList.add('highlight');
        }

        document.getElementById('databaseSelector').addEventListener('change', () => {
            highlightDropdownOption('databaseSelector');
        });

        function loadAndPlot() {
            const databaseName = document.getElementById('databaseSelector').value;
            const tableName = document.getElementById('tableSelector').value;
            const xAxisColumn = document.getElementById('xAxisSelector').value;
            const yAxisColumn = document.getElementById('yAxisSelector').value;

            if (!databaseName) {
                alert("Please select a database");
                return;
            }

            if (!tableName || !xAxisColumn || !yAxisColumn) {
                alert('Please select table and columns first');
                return;
            }

            axios.post('/save-columns', {
                databaseName: databaseName,
                tableName: tableName,
                xAxisColumn: xAxisColumn,
                yAxisColumn: yAxisColumn
            })
            .then(response => {
                alert('Data saved successfully!');
            })
            .catch(error => {
                console.error('Error saving data:', error);

                axios.post('/log-js-error', {
                    message: 'Error saving data',
                    details: error.response ? error.response.data : error.message
                }).catch(logError => {
                    console.error('Failed to log error to Laravel:', logError);
                });
                alert('Failed to save data.', error);
            });

            axios.get(`/tables/data/${tableName}`)
                .then(response => {
                    const data = response.data;
                    if (data.length === 0) {
                        alert('No data found for this table.');
                        return;
                    }

                    plotGeneChart(data, xAxisColumn, yAxisColumn);
                })
                .catch(error => {
                    console.error('Error loading table data:', error);
                    alert('Failed to load table data.');
                });
        }

        let selectedPoints = new Set(); // Array to store selected points

        let highlightMode = false;

        document.getElementById('highlightModeToggle').addEventListener('click', () => {
            highlightMode = !highlightMode;
            const button = document.getElementById('highlightModeToggle');
            button.textContent = highlightMode ? 'Disable Highlight Mode' : 'Enable Highlight Mode';
            button.classList.toggle('btn-success', highlightMode);
            button.classList.toggle('btn-secondary', !highlightMode);
        });

        function plotGeneChart(data, xAxisColumn, yAxisColumn) {
            const chartType = document.getElementById('chartTypeSelector').value;
            const ctx = document.getElementById('geneChart').getContext('2d');

            selectedPoints.clear();

            if (chartInstance) {
                chartInstance.destroy();
            }

            // Check if 'gene_symbol' exists in the data, otherwise fallback to 'Sample Name'
            const geneColumn = data[0].hasOwnProperty('gene_symbol') ? 'gene_symbol' : 'Sample Name';

            // Scatter plot should remain unchanged
            if (chartType === 'scatter') {
                /* const geneSymbols = [...new Set(data.map(row => row[geneColumn]))];
                const colorMap = {};

                geneSymbols.forEach((symbol, index) => {
                    colorMap[symbol] = `hsl(${(index * 137) % 360}, 100%, 50%)`;
                });

                const scatterData = data.map(row => ({
                    x: parseFloat(row[xAxisColumn]),
                    y: parseFloat(row[yAxisColumn]), // Ensure y is parsed as a float
                    backgroundColor: colorMap[row[geneColumn]],
                    radius: 15,
                    borderColor: 'transparent', // Individual border color (empty by default)
                    borderWidth: 1,
                    gene_column_value: row[geneColumn],
                    fullData: row // Include the full row data here
                }));

                const datasets = geneSymbols.map(symbol => {
                    const symbolData = scatterData.filter(row => row.gene_column_value === symbol);
                    return {
                        label: symbol,
                        data: symbolData,
                        backgroundColor: colorMap[symbol],
                        radius: 12,
                        parsing: false

                    };
                }); */
                const geneSymbols = [...new Set(data.map(row => row[geneColumn]))];
                const colorMap = {};

                geneSymbols.forEach((symbol, index) => {
                    colorMap[symbol] = `hsl(${(index * 137) % 360}, 100%, 50%)`;
                });

                const backgroundColor = data.map((row, index) => {
                    return `hsl(${(index * 137) % 360}, 100%, 50%)`;
                });

                const scatterData = data.map(row => ({
                    x: parseFloat(row[xAxisColumn]),
                    y: parseFloat(row[yAxisColumn]), // Ensure y is parsed as a float
                    // backgroundColor: colorMap[row[geneColumn]],
                    // radius: 15,
                    // borderColor: 'transparent', // Individual border color (empty by default)
                    // borderWidth: 1,
                    gene_column_value: row[geneColumn],
                    fullData: row // Include the full row data here
                }));

                const datasets = geneSymbols.map(symbol => {
                    const symbolData = scatterData.filter(row => row.gene_column_value === symbol);
                    return {
                        label: symbol,
                        data: symbolData,
                        backgroundColor: colorMap[symbol],
                        // radius: 15,
                        pointRadius: function(context) {
                            const name = context.raw.gene_column_value;

                            if (selectedPoints.has(name)) {
                                return 50;
                            } else {
                                return 15;
                            }
                            // const index = context.dataIndex;
                            // const value = context.dataset.data[index];
                            return 15;
                        },
                        pointHoverRadius: function(ctx) {
                            return 20;
                        },
                        // parsing: false

                    };
                });

                // console.log(datasets)

                chartInstance = new Chart(ctx, {
                    type: 'scatter',
                    data: {datasets},
                    // data: {
                    //     datasets: [{
                    //         label: geneSymbols,
                    //         data: scatterData,
                    //         backgroundColor: backgroundColor
                    //         // pointRadius: [500],
                    //     }],
                    // },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        /* elements: {
                            point: {
                                // radius: 15, // Default radius
                                // hoverRadius: 15, // Prevent radius change on hover
                                borderWidth: 1 // Default border width
                            }
                        }, */
                        scales: {
                            x: { type: 'linear', title: { display: true, text: xAxisColumn } },
                            y: { title: { display: true, text: yAxisColumn } }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                labels: { usePointStyle: true, boxWidth: 10, font: { size: 12 } },
                                title: { display: true, text: geneColumn === 'gene_symbol' ? 'Gene Symbols' : 'Sample Names', font: { size: 14 } }
                            }
                        },
                        /* elements:{
                            point:{
                                radius: 8,
                                borderColor: '', // Individual border color (empty by default)
                                borderWidth: 0
                            }
                        }, */
                        onClick: (event, elements) => {
                            axios.post('/log-js-event', {
                                message: 'onClick event triggered.',
                                event: {
                                    type: event.type,
                                },
                                elements: elements.map(el => ({
                                    datasetIndex: el.datasetIndex,
                                    index: el.index
                                })),
                                highlightMode: highlightMode // Add highlightMode
                            }).catch(error => {
                                console.error('Error logging onClick event:', error);
                            });

                            if (elements.length > 0) {
                                if (highlightMode) {
                                    axios.post('/log-js-event', { message: 'Highlight click detected.' });

                                    const datasetIndex = elements[0].datasetIndex;
                                    const dataIndex = elements[0].index;

                                    // console.log(chartInstance.data.datasets[datasetIndex].data[dataIndex]);
                                    // chartInstance.data.datasets[datasetIndex].data[dataIndex].radius = 100;
                                    // chartInstance.data.datasets[datasetIndex].data[dataIndex].borderColor = 'red';
                                    // chartInstance.data.datasets[datasetIndex].data[dataIndex].borderWidth = 100;

                                    // chartInstance.data.datasets.forEach(dataset => {
                                    //     dataset.data.forEach(point => {
                                    //         point.radius = 15;
                                    //         point.borderColor = 'transparent';
                                    //         point.borderWidth = 1;
                                    //     });
                                    // });

                                    // Highlight clicked point
                                    const point = chartInstance.data.datasets[datasetIndex].data[dataIndex].gene_column_value;

                                    if (selectedPoints.has(point)) {
                                        selectedPoints.delete(point);
                                    } else {
                                        selectedPoints.add(point);
                                    }
                                    // console.log(selectedPoints);

                                    // chartInstance.data.datasets.forEach(dataset => {
                                    //     dataset.data.forEach(point => {
                                    //         if (selectedPoints.has(point)) {
                                    //             point.radius = 120;
                                    //             point.borderColor = 'red';
                                    //             point.borderWidth = 125;
                                    //         } else {
                                    //             point.radius = 15;
                                    //             point.borderColor = 'transparent';
                                    //             point.borderWidth = 1;
                                    //         }
                                    //     });
                                    // });

                                    // let data = chartInstance.config.data.datasets[datasetIndex].data;

                                    // console.log(data[dataIndex]);
                                    // data[dataIndex].radius = 999;
                                    // console.log(data[dataIndex]);
                                    // chartInstance.config.data.datasets[datasetIndex] = data;

                                    // Update the chart to reflect the changes
                                    chartInstance.update();
                                    // chartInstance.update('active');

                                    axios.post('/log-js-event', {
                                        message: 'Chart.js version detected.',
                                        version: Chart.version
                                        })
                                        .catch(error => {
                                            console.error('Error logging Chart.js version:', error);
                                        });
                                } else {
                                    axios.post('/log-js-event', { message: 'Regular click detected.' });
                                    const datasetIndex = elements[0].datasetIndex;
                                    const dataIndex = elements[0].index;
                                    const clickedData = chartInstance.data.datasets[datasetIndex].data[dataIndex].fullData;

                                    // Populate the modal with the clicked point's data
                                    const pointDataContent = document.getElementById('pointDataContent');
                                    pointDataContent.innerHTML = `
                                        <p><strong>X-Axis:</strong> ${clickedData[xAxisColumn]}</p>
                                        <p><strong>Y-Axis:</strong> ${clickedData[yAxisColumn]}</p>
                                        <p><strong>Gene Column:</strong> ${clickedData[geneColumn]}</p>
                                        <p><strong>Full Data:</strong> ${JSON.stringify(clickedData, null, 2)}</p>
                                        `;

                                    // Add functionality to the "Show Information" button
                                    const showInfoButton = document.getElementById('showInfoButton');
                                    showInfoButton.onclick = () => {
                                        alert(JSON.stringify(clickedData, null, 2));
                                    };

                                    // Show the modal
                                    const pointDataModal = new bootstrap.Modal(document.getElementById('pointDataModal'));
                                    pointDataModal.show();
                                }
                            }
                        }
                    }
                });

                return;
            }

            // Non-scatter chart types (Bar, Line, Pie)
            const labels = data.map(row => row[xAxisColumn]);
            const values = data.map(row => parseFloat(row[yAxisColumn]));
            const geneValues = data.map(row => row[geneColumn]); // Store gene symbol/sample name

            let chartData = {};
            let chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: { title: { display: true, text: xAxisColumn } },
                    y: { title: { display: true, text: yAxisColumn } }
                }
            };

            if (chartType === 'bar' || chartType === 'line') {
                chartData = {
                    labels,
                    datasets: [{
                        label: yAxisColumn,
                        data: values,
                        backgroundColor: 'rgba(59, 130, 246, 0.5)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 1
                    }]
                };
            } else if (chartType === 'pie') {
                chartData = {
                    labels,
                    datasets: [{
                        label: yAxisColumn,
                        data: values,
                        backgroundColor: labels.map((_, index) => `hsl(${(index * 137) % 360}, 100%, 50%)`)
                    }]
                };
                chartOptions = {}; // Pie charts don't need x/y axes
            }

            chartInstance = new Chart(ctx, {
                type: chartType,
                data: chartData,
                options: chartOptions
            });
        }

        const chatbotBubble = document.getElementById("chatbot-bubble");
        const chatbotContainer = document.getElementById("chatbot-container");
        const closeButton = document.getElementById("close-chatbot");
        const chatMessages = document.getElementById("chatbot-messages");
        const userInput = document.getElementById("user-input");
        const navigateGraph = document.getElementById("navigate-graph");
        const toggle = document.getElementById("toggle-chatbot-button")
        const dropdownItems = document.querySelectorAll('.option-btn');
        const buttonsContainer = document.getElementById('option-buttons-container');

        // Function to toggle chat window visibility
        function toggleChatWindow() {
            if (chatbotContainer.style.display === "none") {
                chatbotContainer.style.display = "flex";
                toggle.style.display = "none";
            } else {
                chatbotContainer.style.display = "none";
                toggle.style.display = "flex";
            }
        }

        dropdownItems.forEach(item => {
            item.addEventListener('click', function() {
                // Get the text of the clicked dropdown item
                const selectedOption = item.textContent;

                // Set the selected option as the value of the chat input field
                userInput.value = selectedOption;
            });
        });

        // Function to create the button rows dynamically
        function createOptionButtons(option) {
            let rowCount = 3; // Set how many buttons you want in each row
            let totalButtons = 6; // Total number of buttons you want for each option

            // Loop to create a set of buttons based on the selected option
            for (let i = 0; i < totalButtons; i++) {
                let button = document.createElement('button');
                button.className = 'btn btn-primary m-1';  // Style the buttons
                button.textContent = `${option} Button ${i + 1}`;

                // Append button to the container
                buttonsContainer.appendChild(button);
            }
        }

        // Ensure that the chat window starts hidden
        // chatbotContainer.style.display = "none";

        // Open chatbot container
        chatbotBubble.addEventListener("click", () => {
            chatbotContainer.style.display = "flex";
            chatbotBubble.style.display = "none";
        });

        // Close chatbot container
        closeButton.addEventListener("click", () => {
            toggleChatWindow();
        });

        // Initially, make sure the bubble is visible
        chatbotContainer.style.display = "none";
        // Initially, show the bubble and hide the chatbot container
        // closeChatWindow(); // Hide chat window and show bubble on page load

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
                //https://rossa.soc.uconn.edu/api/rag-upload
                try {
                    const response = await fetch("https://rossa.soc.uconn.edu/api/data-chatbot", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded",
                        },
                        body: new URLSearchParams({ message: userMessage }),
                    });

                    const data = await response.json();
                    appendMessage(data.reply, "bot");

                    highlightPointsFromJSON();
                } catch (error) {
                    console.error("Error:", error);
                    appendMessage("Could not get response.", "bot");
                }
            }
        });

        async function highlightPointsFromJSON() {
            await axios.post('/log', {
                message: 'HERE',
                level: 'info'
            });

            let response;
            try {
                response = await fetch('https://rossa.soc.uconn.edu/highlight-data'); // Replace with the actual path to your JSON file
                await axios.post('/log', {
                    message: 'Fetch request sent to /highlight-data',
                    level: 'info'
                });
            } catch (fetchError) {
                await axios.post('/log', {
                    message: 'Error during fetch request to /highlight-data',
                    level: 'error',
                    error: fetchError.message
                });
                throw fetchError; // Re-throw the error to be caught by the outer catch block
            }

            if (!response.ok) {
                await axios.post('/log', {
                    message: `Failed to load JSON file. Status: ${response.status}`,
                    level: 'error'
                });
                throw new Error('Failed to load JSON file');
            }

            const jsonData = await response.json();

            await axios.post('/log', {
                message: 'Fetched JSON data successfully',
                level: 'info',
                data: jsonData
            });

            // Assuming the JSON file contains an array of points with x and y values
            const pointsToHighlight = jsonData.points; // Adjust based on your JSON structure
            await axios.post('/log', {
                message: 'Points to highlight',
                level: 'info',
                pointsToHighlight: pointsToHighlight
            });

            // Reset all points to default appearance
            // chartInstance.data.datasets.forEach(dataset => {
            //     dataset.data.forEach(point => {
            //         point.radius = 15;
            //         point.borderColor = 'transparent';
            //         point.borderWidth = 1;
            //     });
            // });

            // Log the reset action
            await axios.post('/log', {
                message: 'Reset all points to default appearance',
                level: 'info'
            });

            if (!pointsToHighlight || pointsToHighlight.length === 0) {
                await axios.post('/log', {
                    message: 'No points to highlight',
                    level: 'warning'
                });
                return; // Exit the function early
            }

            if (!chartInstance.data.datasets || chartInstance.data.datasets.length === 0) {
                await axios.post('/log', {
                    message: 'No datasets found in chartInstance',
                    level: 'warning'
                });
                return; // Exit the function early
            }

            await axios.post('/log', {
                message: 'Points to highlight',
                level: 'info',
                pointsToHighlight: pointsToHighlight
            });

            // await axios.post('/log', {
            //     message: 'Datasets in chartInstance',
            //     level: 'info',
            //     datasets: chartInstance.data.datasets
            // });

            await axios.post('/log', {
                message: 'Datasets in chartInstance',
                level: 'info',
                datasets: chartInstance.data.datasets.map(dataset => ({
                    label: dataset.label,
                    data: dataset.data
                }))
            });

            // Highlight the points listed in the JSON file
            for (const identifier of pointsToHighlight) {
                await axios.post('/log', {
                    message: `Processing identifier: ${identifier}`,
                    level: 'info'
                });

                for (const [datasetIndex, dataset] of chartInstance.data.datasets.entries()) {
                    await axios.post('/log', {
                        message: `Processing dataset at index: ${datasetIndex}`,
                        level: 'info',
                        dataset: dataset.label || `Dataset ${datasetIndex}`
                    });
                    if (!dataset.data || dataset.data.length === 0) {
                        await axios.post('/log', {
                            message: `Dataset at index ${datasetIndex} has no points`,
                            level: 'warning'
                        });
                        continue; // Skip this dataset
                    }

                    for (const [pointIndex, point] of dataset.data.entries()) {
                        await axios.post('/log', {
                            message: `Processing point at index: ${pointIndex}`,
                            level: 'info',
                            point: {
                                gene_column_value: point.gene_column_value,
                                sample_name: point.sample_name,
                                x: point.x,
                                y: point.y
                            }
                        });


                        // Check for both gene symbol and sample name
                        if (point.gene_column_value === identifier || point.sample_name === identifier) {
                            // const point = chartInstance.data.datasets[datasetIndex].data[dataIndex];
                            // point.radius = 120;
                            // point.borderColor = 'red';
                            // point.borderWidth = 125;
                            const previousHighlightMode = highlightMode;
                            highlightMode = true;
                            // point.radius = 120; // Increase the size
                            // point.borderColor = 'red'; // Add a red border
                            // point.borderWidth = 125; // Increase border width

                            chartInstance.options.onClick(
                                { type: 'click' }, // Simulated event object
                                [{ datasetIndex, index: pointIndex }] // Simulated elements array
                            );
                            await axios.post('/log', {
                                message: `Point matched and highlighted`,
                                level: 'info',
                                highlightedPoint: {
                                    gene_column_value: point.gene_column_value,
                                    sample_name: point.sample_name,
                                    x: point.x,
                                    y: point.y
                                }
                            });
                            // chartInstance.update('active');
                            // chartInstance.update();
                            highlightMode = previousHighlightMode;
                        }
                    }
                }
            }

            // Log the highlighting action
            await axios.post('/log', {
                message: 'Highlighted points successfully',
                level: 'info',
                highlightedPoints: pointsToHighlight
            });

            // Update the chart to reflect the changes


            await axios.post('/log', {
                message: 'Chart updated successfully',
                level: 'info'
            });

            const highlightedPoints = [];
            chartInstance.data.datasets.forEach(dataset => {
                dataset.data.forEach(point => {
                    if (point.radius === 120) { // Check if the point is highlighted
                        highlightedPoints.push({
                            gene_column_value: point.gene_column_value,
                            sample_name: point.sample_name,
                            x: point.x,
                            y: point.y,
                            radius: point.radius
                        });
                    }
                });
            });

            await axios.post('/log', {
                message: 'Highlighted points with radius logged',
                level: 'info',
                highlightedPoints: highlightedPoints
            });
        }

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
                document.getElementById("study-title").value = data.studyTitle || "No Title Generated, Ensure you upload RAG document first";
                document.getElementById("study-summary").value = data.studySummary || "No Summary Generated, Ensure you upload RAG document first";

                alert("Study Information Generated!");
            } catch (error) {
                console.error("Failed to generate study information", error);
                alert("Failed to generate study information.");
            }
        });

        function logJsEvent(event, elements) {
            axios.post('/log-js-event', {
                event: {
                    type: event.type,
                    shiftKey: event.nativeEvent.shiftKey,
                },
                elements: elements.map(el => ({
                    datasetIndex: el.datasetIndex,
                    index: el.index,
                }))
            }).catch(error => {
                console.error('Error logging JS event:', error);
            });
        }

        function navigateToGeneSummary() {
            const selectedGeneData = document.getElementById('pointDataContent').innerText.trim(); // Use innerText and trim whitespace
            if (!selectedGeneData) {
                alert('No gene data available. Please select a point first.');
                return;
            }
            const url = new URL('/gene-summary', window.location.origin);
            url.searchParams.append('geneData', selectedGeneData); // Pass raw text data
            window.location.href = url;
        }

        function loadTables() {
            const selectedDatabase = document.getElementById('databaseSelector').value;
            const loadingIndicator = document.getElementById('loadingIndicator');
            if (!selectedDatabase) {
                alert('Please select a database first');
                return;
            }

            // Show the loading indicator
            loadingIndicator.style.display = 'block';

            // Make an AJAX request to the new route in web.php
            axios.get(`/switch-database/${selectedDatabase}`)
                .then(response => {
                    const tables = response.data;

                    // Update the tableSelector dropdown
                    const tableSelector = document.getElementById('tableSelector');
                    tableSelector.innerHTML = '<option value="">-- Select Table --</option>'; // Reset options
                    tables.forEach(table => {
                        const option = document.createElement('option');
                        option.value = table;
                        option.textContent = table;
                        tableSelector.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error loading tables:', error);
                    alert('Failed to load tables.');
                })
                .finally(() => {
                    // Hide the loading indicator
                    loadingIndicator.style.display = 'none';
                });
        }

        </script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    </body>
</html>
