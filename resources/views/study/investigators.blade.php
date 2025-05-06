@extends('layout')

@section('title', 'Investigators')

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
    <h1 class="mb-4">Investigator Information</h1>

    <!-- Investigator Form -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Add New Investigator</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="firstName">First Name</label>
                    <input type="text" class="form-control" id="firstName" wire:model="newInvestigator.first_name">
                    @error('newInvestigator.first_name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="lastName">Last Name</label>
                    <input type="text" class="form-control" id="lastName" wire:model="newInvestigator.last_name">
                    @error('newInvestigator.last_name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" wire:model="newInvestigator.email">
                    @error('newInvestigator.email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="department">Department</label>
                    <input type="text" class="form-control" id="department" wire:model="newInvestigator.department">
                    @error('newInvestigator.department') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
				
                <div class="col-md-4 mb-3">
					<label for="organization">Organization</label>
                    <input type="text" class="form-control" id="organization" wire:model="newInvestigator.organization">
                    @error('newInvestigator.organization') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
				
                <div class="col-md-4 mb-3">
                    <label for="country">Country</label>
                    <select class="form-select" id="country" wire:model.live="newInvestigator.country">
                        <option value="">Select Country...</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->code }}">{{ $country->name }}</option>
                        @endforeach
                    </select>
                    @error('newInvestigator.country') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                
				<div class="col-md-4 mb-3">
					<div class="form-check mt-4">
						<input type="checkbox" class="form-check-input" wire:model="newInvestigator.is_corresponding" id="isCorresponding">
						<label class="form-check-label" for="isCorresponding">Corresponding Investigator</label>
					</div>
				</div>
            </div>

            <button type="button" class="btn btn-primary mt-4" wire:click="addInvestigator">
                Add Investigator
            </button>
        </div>
    </div>

    <!-- Investigators Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Investigators</h5>
        </div>
        <div class="card-body">
            @if(count($investigators) > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Department</th>
                                <th>Organization</th>
                                <th>Location</th>
                                <th>Corresponding</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($investigators as $investigator)
                                <tr>
                                    <td>{{ $investigator->first_name }} {{ $investigator->last_name }}</td>
                                    <td>{{ $investigator->email }}</td>
                                    <td>{{ $investigator->department }}</td>
                                    <td>{{ $investigator->organization }}</td>
                                    <td>{{ $investigator->state ? $investigator->state . ', ' : '' }}{{ $investigator->country }}</td>
                                    <td>{{ $investigator->is_corresponding ? 'Yes' : 'No' }}</td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm" 
                                                wire:click="removeInvestigator({{ $investigator->id }})">
                                            Remove
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted mb-0">No investigators have been added yet. Use the form above to add a new investigator.</p>
            @endif
        </div>
    </div>
   
        <div class="mt-4 d-flex">
            <button type="submit" class="btn btn-primary">Save</button>
            <a  class="ms-4 btn btn-secondary">Continue to Animal Experimentation <i class="bi-arrow-right"></i></a>
        </div>
    
</div>
@endsection