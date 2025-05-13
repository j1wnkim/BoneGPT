# Laravel Application

This is a Laravel-based web application. It includes various features and controllers to handle different functionalities. Below is an overview of the project structure, setup instructions, and usage.

---

## Features
- **Controllers**: Handles various functionalities such as data processing, user authentication, and more; can be found in 'app/Http/Controllers'
- **Routing**: Defined in `routes/web.php` to manage application endpoints.
- **Blade Templates**: Used for rendering dynamic views; these can be found in 'resources/views/'
- **Middleware**: Provides request filtering and authentication mechanisms; can be found in 'app/Http/Middleware'
- **Database Migrations**: Manages database schema changes; can be found in 'database/'

---

## Requirements
- PHP >= 8.0
- Composer
- Laravel >= 9.x
- MySQL or any supported database
- Node.js and npm (for frontend assets)

---

# Gene Data Visualization Tool

Visualizing gene expression or sample-based data using interactive charts powered by [Chart.js](https://www.chartjs.org/). Supports scatter, bar, line, and pie charts with point-specific highlighting and detailed data inspection, along with the use of chatbot to query information about database

---

## Features

- Interactive scatter plots with color-coded gene symbols or sample names.
- Clickable points to reveal detailed data in a modal popup.
- Highlight mode: visually emphasize clicked points with custom styling.
- Dynamic chart switching (Scatter, Bar, Line, Pie).
- Axios-based logging to backend endpoints (e.g., `/log-js-event`).
- Integrated chatbot that answers queries relating to the database
- Custom color mapping for distinct gene/sample identifiers.
- Chart.js 4+ compatible, with full use of `parsing: false` for individual point control.

## Main Component Files

- 'resources/views/dashboard.blade.php'
- Routes: '/tables' Can be found in `routes/web.php` lines 104-106
- 'app/Http/Controllers/DataController.php'
- 'llm_backend.py'
- 'api_backend_rag.py' 

### Prerequisites

- HTML/CSS/JavaScript environment
- A modern browser supporting ES6+
- Backend endpoint to receive logging `/log-js-event`

# Study Information Tool

Allows users to manage study metadata and interact with an AI-powered chatbot. The chatbot supports file uploads for RAG-based search, dynamic data generation, and general conversation through multiple tabs.

## Features

- Input and edit study title, summary, funding, conflicts, completion date and various study sections.
- Integrated chatbot with three modes:
  - RAG: Upload PDFs for retrieval-augmented generation.
  - Chat-R: Query chatbot about uploaded pdf.
- File upload system using FastAPI as a backend processor.
- Automatically generate study details from uploaded documents.
- UI optimized with Bootstrap 5 and Alpine.js interactivity.

## Main Component Files

- 'resources/views/study/'
- Routes: '/tables' Can be found in `routes/web.php` lines 58-91
- 'app/Http/Controllers/'
- 'api_backend_rag_compliment.py'
- 'api_backend_rag.py' 

## Technologies Used

- Laravel (Blade templating)
- Bootstrap 5
- FastAPI (Python backend)
- NGINX (Proxying requests)
  - refer to: 'defaultc.conf' for configuration 
- JavaScript (Fetch API, dynamic DOM handling)
- Docker
  - refer to:'docker-compose.yml' and 'Dockerfile'

## Missing
- Glove embedding text file is not included because it is too large
- Download the Glove embeddings through https://www.kaggle.com/datasets/thanakomsn/glove6b300dtxt
- Possible improvement: Go try to implement OpenAI's API embedding.  
## Installation

### 1. Clone the Repository
git clone https://github.com/Josiah-Mendez-CS/BoneGPT.git
