@extends('layout')

@section('title', 'Study Summary')

@php
    use App\Models\ExperimentalGroup;
@endphp

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
    <h1 class="mb-4">Study Summary</h1>
    <div class="row g-4">
        {{-- Study Information --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">Study Information</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Study ID:</strong></p>
                            <p><strong>Title:</strong></p>
                           
                        </div>
                        <div class="col-md-6">
                           
                                <p><strong>Publication Plan:</strong> 
                                   
                                </p>
                               
                        </div>
                    </div>
                    <div class="mt-3">
                        <h5><strong>Summary</strong></h5>
                        <p></p>
                    </div>
                  
                </div>
            </div>
        </div>

		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title mb-0">Subject Areas</h3>
				</div>
				<div class="card-body">
					
				</div>
			</div>
		</div>

        {{-- Investigators --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">Investigators</h3>
                </div>
                <div class="card-body">
                    
                </div>
            </div>
        </div>

        {{-- Experimental Groups --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">Experimental Groups</h3>
                </div>
                <div class="card-body">
                   
                </div>
            </div>
        </div>

        {{-- Phenotype Analysis Data --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">Phenotype Analysis Data</h3>
                </div>
                <div class="card-body">
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection