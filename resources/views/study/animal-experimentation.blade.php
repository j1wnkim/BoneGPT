@extends('layout')

@section('title', 'Animal Experimentation')

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
    <h1 class="mb-3">Animal Experimentation</h1>

    <form action="{{ route('study.save-animal-experimentation', ['study' => 1]) }}" method="POST" data-confirmchanges x-data="{
			{{-- Study Categories --}}
            study_is_genetically_modified: ,
            study_performs_drug_treatment: ,
            study_performs_mechanical_procedure: ,
            study_performs_gonadectomy: ,
            study_performs_diet_modification: ,
            study_controls_light_dark_cycle: ,
			study_compares_mouse_strains: ,
			{{-- Genetic Modification --}}
			gm_global_knockout: ,
			gm_induced_mutation: ,
			gm_insertional_mutagenesis: ,
			gm_conditional_knockout: ,
			gm_conditional_knockin_safe_harbor: ,
			gm_transgene: ,

			{{-- Global Knockout --}}
			gm_gko_has_second_animal_line: ,

			{{-- Conditional Knockout Cre System --}}
			gm_cond_knockout_cre_system_used: ,
			gm_cond_knockout_tamoxifen_tamoxifen_type: ,
			gm_cond_knockout_doxy_doxycycline_type: ,

			{{-- Conditional Knock-in Safe Harbor --}}
			gm_cond_knockin_safe_harbor_cre_system_used: ,

			{{-- Transgene Drug Inducible Mechanism --}}
			gm_random_genome_utilizes_drug_inducible_mechanism: ,
			gm_random_genome_second_animal_line: ,
			gm_random_genome_utilizes_drug_inducible_mechanism_2: ,
			}">
            @csrf

            <input type="hidden" name="study_id" value="{{ 1 }}">

            <!-- Study Categories Card -->
			<div class="card mb-4 bg-light">
				<div class="card-header d-flex flex-wrap align-items-baseline">
					<span class="fw-bold fs-4 me-2">Experimental Categories</span>
					<span class="text-muted fs-6">(From the categories below, please select all that apply)</span>
				</div>
				<div class="card-body">
				
					<h5>This Study:</h5>
					{{-- Genetically Modified Mice study Category Checkbox --}}
					<x-forms.checkbox-with-examples
						id="study_is_genetically_modified"
						label="Uses genetically modified mice to investigate the role of a gene or cell population on the skeleton."
						model="study_is_genetically_modified"
						examples="Global or conditional knockout mice, global or conditional knockin mice, transgenic mice, chemical or X-Ray generated mutants, insertional mutants generated by gene traps, transposable elements, or retroviruses"
						buttonText="Examples of Genetic Modifications"
					/>

					{{-- Drug Treatment Study Category Checkbox --}}
					<x-forms.checkbox-with-examples
						id="study_performs_drug_treatment"
						label="Investigates the impact of a drug treatment on the skeleton."
						model="study_performs_drug_treatment"
						examples="Drug treatment is defined as the delivery of a small molecule, biologic, antisense oligonucleotides, shRNA, Cas9/guideRNA)"
						buttonText="Examples of Drug Treatments"
					/>

					<!-- Mechanical Loading/Unloading Procedures Category Checkbox -->
					<x-forms.checkbox-with-examples
						id="study_performs_mechanical_procedure"
						label="Performs a mechanical loading/unloading procedure."
						model="study_performs_mechanical_procedure"
						examples="Performed on living mice such as axial tibia loading, ulnar loading, hind limb suspension, space flight"
						buttonText="Show Examples"
					/>

					{{-- Gonadectomy Category Checkbox --}}
					<x-forms.checkbox-with-examples
						id="study_performs_gonadectomy"
						label="Performs a gonadectomy"
						model="study_performs_gonadectomy"
					/>

					{{-- Alters the Animal Diet Category Checkbox --}}
					<x-forms.checkbox-with-examples
						id="study_performs_diet_modification"
						label="Compares different animal diet conditions (testing of Nutrients, Phytochemicals, Probiotics)"
						model="study_performs_diet_modification"
						examples="High fat, high sugar, high phosphate, Calcium-Vitamin D supplementation, Caloric Restriction, Soy, Phytoestrogens, alcohol, probiotics, high salt, micronutrients, special diets"
						buttonText="Example Dietary Changes"
					/>

					{{-- Alters Light/Dark Cycle Category Checkbox --}}
					<x-forms.checkbox-with-examples
						id="study_controls_light_dark_cycle"
						label="Compares different light/dark cycles"
						model="study_controls_light_dark_cycle"
					/>

					{{-- Compares different mouse strains --}}
					<x-forms.checkbox
						id="study_compares_mouse_strains"
						label="Compares different mouse strains"
						model="study_compares_mouse_strains"
					/>
				</div>
			</div>
			<!-- End of Study Categories Card -->


            <!-- Genetic Modification Card -->
			<div class="card mb-4 bg-light" x-show="study_is_genetically_modified">
				<div class="card-header">
					<h4 class="fw-bold mb-0">What best describes the genetically modified animal model(s) in your study?</h4>
				</div>
				<div class="card-body">
					{{-- Global Gene Mutation --}}
					<h4 >Global Gene Mutation (every cell in the animal carries the functional change)</h4>
                    <x-forms.checkbox
                        id="gm_global_knockout"
                        label="Global targeted knockout or knock-in to alter an endogeneous gene's function"
                        model="gm_global_knockout"
                    />

					<x-forms.checkbox
                        id="gm_induced_mutation"
                        label="Spontaneous, Chemical or X-Ray Induced Mutation (randomly generated point mutation or deletion that has been mapped)"
                        model="gm_induced_mutation"
                    />

					<x-forms.checkbox
                        id="gm_insertional_mutagenesis"
                        label="Insertional Mutagenesis: Gene Trap, Retroviral, or Transposon Mediated Mutagenesis."
                        model="gm_insertional_mutagenesis"
                    />

					{{-- Conditional Engineered Mouse --}}
					<h4 class="mt-3">Conditionally Engineered Mouse Model (where genetic changes are implemented in a specific cell lineage)</h4>
					<x-forms.checkbox
                        id="gm_conditional_knockout"
                        label="Conditional Knockout or Knockin to alter an endogeneous gene's function in a specific cell lineage typically when intercrossed with Cre transgenic Mice (tissue/lineage specific loss of function)"
                        model="gm_conditional_knockout"
                    />

                    <x-forms.checkbox
                        id="gm_conditional_knockin_safe_harbor"
                        label='Conditional Knock-in into a specific gene or "Safe Harbor" site such as the Rosa Locus'
                        model="gm_conditional_knockin_safe_harbor"
                    />

                    {{-- Transgenic Mouse --}}
                    <h4 class="mt-3">Transgenic Mouse Model</h4>
                    <x-forms.checkbox
                        id="gm_transgene"
                        label="Random Genome Integration of a Transgene (i.e. over expression of a coding sequence controlled by tissue specific regulatory sequences)"
                        model="gm_transgene"
                    />
				</div>
			</div>
			{{-- End of Genetic Modification Card --}}

        </form>
    </div>
</div>
@endsection