@extends('layout')

@section('title', 'Experimental Groups')

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
    {{-- <livewire:experimental-groups-form :study="$study" :studyInfo="$studyInfo" /> --}}
    <div class="mb-5">
        <h1 class="mb-3">Define Experimental Groups</h1>
        <p>Here you can describe the experimental groups used in your study.  Groups created can be assigned to phenotype analysis measurements in the next section.</p>
    </div>

    <form action="{{ route('study.add-experimental-group', $study)}}" method="POST">
        @csrf

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Experimental Group Generator</h5>
            </div>
            <div class="card-body">
                <div class="row align-items-start mb-3">
                    <div class="col-md-4 mb-3">
                        <h6>Basic Information</h6>
                        <small class="fst-italic">Fields available to all study types.</small>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <x-forms.input-label>Sex</x-forms.input-label>
                                <x-forms.select name="sex">
                                    <option value="">Select Sex...</option>
                                    <option value="male" @selected(old('sex') === 'male')>Male</option>
                                    <option value="female" @selected(old('sex') === 'female')>Female</option>
                                </x-forms.select>
                                <x-forms.input-error :messages="$errors->get('sex')" />
                            </div>
            
                            <div class="col-md-6 mb-3">
                                <x-forms.input-label>Age (weeks)</x-forms.input-label>
                                <x-forms.input-text type="number" name="age" placeholder="Age in weeks" step="1" min="0" max="9999" value="{{ old('age') }}" />
                                <x-forms.input-error :messages="$errors->get('age')" />
                            </div>
    
                        </div>
                    </div>
                </div>


                

                <div class="row">
                    <div class="col">
                        <button type="submit" class="btn btn-primary">Create Group</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Groups Table -->

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Defined Groups</h5>
            </div>
            <div class="card-body">
                
            </div>
        </div>

        <div class="mt-4 d-flex align-items-center">
            <p class="fst-italic mb-0">Experimental Groups are saved automatically.</p>
            <a href="{{ route('study.phenotype-analysis', $study) }}" class="ms-4 btn btn-secondary">Continue to Phenotype Analysis <i class="bi-arrow-right"></i></a>
        </div>
</div>
@endsection