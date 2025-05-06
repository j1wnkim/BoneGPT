@extends('layout')

@section('title', 'Phenotype Analysis')

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
    <h1 class="mb-3">Phenotype Analysis</h1>

    <form action="{{ route('study.save-phenotype-analysis', ['study' => 1]) }}" method="POST" x-data="{
    dexa: false,
    micro_ct: false,
    bone_histomorphometry: false,
    mechanical_testing: false,
    clinical_biochemistry: false,

    dexa_whole_body: false,
    dexa_femur: false,
    dexa_tibia: false,
    dexa_vertebra: false,

    micro_ct_femur_trabecular: false,
    micro_ct_femur_cortical: false,
    micro_ct_tibia_trabecular: false,
    micro_ct_tibia_cortical: false,
    micro_ct_vertebra_trabecular: false,
    
    bone_histomorphometry_femur_trabecular: false,
    bone_histomorphometry_femur_cortical: false,
    bone_histomorphometry_tibia_trabecular: false,
    bone_histomorphometry_tibia_cortical: false,
    bone_histomorphometry_vertebra_trabecular: false
}">
        @csrf
        <input type="hidden" name="study_id" value="">

        {{-- Restructured Analysis Selection Area --}}
        <div class="row mb-4">
            {{-- Main Analysis Types (Left) --}}
            <div class="col-md-4">
                <div class="card bg-light h-100">
                    <div class="card-body">
                        <h5>Select the Type of Analyses Performed to Phenotype Mice</h5>

                        <x-forms.checkbox id="dexa" label="Dual-Energy X-Ray Absorptiometry (DEXA)" name="dexa" model="dexa" />
                        <x-forms.checkbox id="micro_ct" label="Microcomputed Tomography (µCT)" name="micro_ct" model="micro_ct" />
                        <x-forms.checkbox id="bone_histomorphometry" label="Bone Histomorphometry" name="bone_histomorphometry" model="bone_histomorphometry" />
                        <x-forms.checkbox id="mechanical_testing" label="Mechanical Strength Testing" name="mechanical_testing" model="mechanical_testing" />
                        <x-forms.checkbox id="clinical_biochemistry" label="Clinical Biochemistry / Biomarkers" name="clinical_biochemistry" model="clinical_biochemistry" />
                    </div>
                </div>
            </div>

            {{-- Detailed Options (Right) --}}
            <div class="col-md-8">
                {{-- DEXA Card --}}
                <div class="card mb-3 bg-light" x-show="dexa">
                    <div class="card-body">
                        <h5><strong>DEXA</strong></h5>
                        <div class="d-flex flex-wrap gap-3">
                            <x-forms.checkbox id="dexa_whole_body" label="Whole Body" name="dexa_whole_body" model="dexa_whole_body" />
                            <x-forms.checkbox id="dexa_femur" label="Femur" name="dexa_femur" model="dexa_femur" />
                            <x-forms.checkbox id="dexa_tibia" label="Tibia" name="dexa_tibia" model="dexa_tibia" />
                            <x-forms.checkbox id="dexa_vertebra" label="Vertebra" name="dexa_vertebra" model="dexa_vertebra" />
                        </div>
                    </div>
                </div>

                {{-- µCT Card --}}
                <div class="card mb-3 bg-light" x-show="micro_ct">
                    <div class="card-body">
                        <h5><strong>Microcomputed Tomography (µCT)</strong></h5>
                        <div class="d-flex flex-wrap gap-3">
                            <x-forms.checkbox id="micro_ct_femur_trabecular" label="Femur Trabecular Bone" name="micro_ct_femur_trabecular" model="micro_ct_femur_trabecular" />
                            <x-forms.checkbox id="micro_ct_femur_cortical" label="Femur Cortical Bone" name="micro_ct_femur_cortical" model="micro_ct_femur_cortical" />
                            <x-forms.checkbox id="micro_ct_tibia_trabecular" label="Tibia Trabecular Bone" name="micro_ct_tibia_trabecular" model="micro_ct_tibia_trabecular" />
                            <x-forms.checkbox id="micro_ct_tibia_cortical" label="Tibia Cortical Bone" name="micro_ct_tibia_cortical" model="micro_ct_tibia_cortical" />
                            <x-forms.checkbox id="micro_ct_vertebra_trabecular" label="Vertebra Trabecular Bone" name="micro_ct_vertebra_trabecular" model="micro_ct_vertebra_trabecular" />
                        </div>
                    </div>
                </div>

                {{-- Similar pattern for other cards... --}}

                <div class="row mb-4">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Save Analysis Selection</button>
                    </div>
                </div>
            </div>
        </div>

        
    </form>

    
    <div class="row">
        <div class="col-12">
            <livewire:data-uploader :study="" />
        </div>
    </div>
</div>
@endsection
