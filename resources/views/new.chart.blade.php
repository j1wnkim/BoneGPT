{{-- resources/views/new.chart.blade.php --}}
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
    </script>
</body>
</html>
