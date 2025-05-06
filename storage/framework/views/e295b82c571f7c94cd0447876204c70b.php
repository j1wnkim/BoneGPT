<?php $__env->startSection('title', 'Animal Experimentation'); ?>

<?php $__env->startSection('content'); ?>
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

    <form action="<?php echo e(route('study.save-animal-experimentation', ['study' => 1])); ?>" method="POST" data-confirmchanges x-data="{
			
            study_is_genetically_modified: ,
            study_performs_drug_treatment: ,
            study_performs_mechanical_procedure: ,
            study_performs_gonadectomy: ,
            study_performs_diet_modification: ,
            study_controls_light_dark_cycle: ,
			study_compares_mouse_strains: ,
			
			gm_global_knockout: ,
			gm_induced_mutation: ,
			gm_insertional_mutagenesis: ,
			gm_conditional_knockout: ,
			gm_conditional_knockin_safe_harbor: ,
			gm_transgene: ,

			
			gm_gko_has_second_animal_line: ,

			
			gm_cond_knockout_cre_system_used: ,
			gm_cond_knockout_tamoxifen_tamoxifen_type: ,
			gm_cond_knockout_doxy_doxycycline_type: ,

			
			gm_cond_knockin_safe_harbor_cre_system_used: ,

			
			gm_random_genome_utilizes_drug_inducible_mechanism: ,
			gm_random_genome_second_animal_line: ,
			gm_random_genome_utilizes_drug_inducible_mechanism_2: ,
			}">
            <?php echo csrf_field(); ?>

            <input type="hidden" name="study_id" value="<?php echo e(1); ?>">

            <!-- Study Categories Card -->
			<div class="card mb-4 bg-light">
				<div class="card-header d-flex flex-wrap align-items-baseline">
					<span class="fw-bold fs-4 me-2">Experimental Categories</span>
					<span class="text-muted fs-6">(From the categories below, please select all that apply)</span>
				</div>
				<div class="card-body">
				
					<h5>This Study:</h5>
					
					<?php if (isset($component)) { $__componentOriginal0c46e9ed331cf390c83c2e9d74a58679 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0c46e9ed331cf390c83c2e9d74a58679 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.checkbox-with-examples','data' => ['id' => 'study_is_genetically_modified','label' => 'Uses genetically modified mice to investigate the role of a gene or cell population on the skeleton.','model' => 'study_is_genetically_modified','examples' => 'Global or conditional knockout mice, global or conditional knockin mice, transgenic mice, chemical or X-Ray generated mutants, insertional mutants generated by gene traps, transposable elements, or retroviruses','buttonText' => 'Examples of Genetic Modifications']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.checkbox-with-examples'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'study_is_genetically_modified','label' => 'Uses genetically modified mice to investigate the role of a gene or cell population on the skeleton.','model' => 'study_is_genetically_modified','examples' => 'Global or conditional knockout mice, global or conditional knockin mice, transgenic mice, chemical or X-Ray generated mutants, insertional mutants generated by gene traps, transposable elements, or retroviruses','buttonText' => 'Examples of Genetic Modifications']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0c46e9ed331cf390c83c2e9d74a58679)): ?>
<?php $attributes = $__attributesOriginal0c46e9ed331cf390c83c2e9d74a58679; ?>
<?php unset($__attributesOriginal0c46e9ed331cf390c83c2e9d74a58679); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0c46e9ed331cf390c83c2e9d74a58679)): ?>
<?php $component = $__componentOriginal0c46e9ed331cf390c83c2e9d74a58679; ?>
<?php unset($__componentOriginal0c46e9ed331cf390c83c2e9d74a58679); ?>
<?php endif; ?>

					
					<?php if (isset($component)) { $__componentOriginal0c46e9ed331cf390c83c2e9d74a58679 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0c46e9ed331cf390c83c2e9d74a58679 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.checkbox-with-examples','data' => ['id' => 'study_performs_drug_treatment','label' => 'Investigates the impact of a drug treatment on the skeleton.','model' => 'study_performs_drug_treatment','examples' => 'Drug treatment is defined as the delivery of a small molecule, biologic, antisense oligonucleotides, shRNA, Cas9/guideRNA)','buttonText' => 'Examples of Drug Treatments']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.checkbox-with-examples'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'study_performs_drug_treatment','label' => 'Investigates the impact of a drug treatment on the skeleton.','model' => 'study_performs_drug_treatment','examples' => 'Drug treatment is defined as the delivery of a small molecule, biologic, antisense oligonucleotides, shRNA, Cas9/guideRNA)','buttonText' => 'Examples of Drug Treatments']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0c46e9ed331cf390c83c2e9d74a58679)): ?>
<?php $attributes = $__attributesOriginal0c46e9ed331cf390c83c2e9d74a58679; ?>
<?php unset($__attributesOriginal0c46e9ed331cf390c83c2e9d74a58679); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0c46e9ed331cf390c83c2e9d74a58679)): ?>
<?php $component = $__componentOriginal0c46e9ed331cf390c83c2e9d74a58679; ?>
<?php unset($__componentOriginal0c46e9ed331cf390c83c2e9d74a58679); ?>
<?php endif; ?>

					<!-- Mechanical Loading/Unloading Procedures Category Checkbox -->
					<?php if (isset($component)) { $__componentOriginal0c46e9ed331cf390c83c2e9d74a58679 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0c46e9ed331cf390c83c2e9d74a58679 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.checkbox-with-examples','data' => ['id' => 'study_performs_mechanical_procedure','label' => 'Performs a mechanical loading/unloading procedure.','model' => 'study_performs_mechanical_procedure','examples' => 'Performed on living mice such as axial tibia loading, ulnar loading, hind limb suspension, space flight','buttonText' => 'Show Examples']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.checkbox-with-examples'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'study_performs_mechanical_procedure','label' => 'Performs a mechanical loading/unloading procedure.','model' => 'study_performs_mechanical_procedure','examples' => 'Performed on living mice such as axial tibia loading, ulnar loading, hind limb suspension, space flight','buttonText' => 'Show Examples']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0c46e9ed331cf390c83c2e9d74a58679)): ?>
<?php $attributes = $__attributesOriginal0c46e9ed331cf390c83c2e9d74a58679; ?>
<?php unset($__attributesOriginal0c46e9ed331cf390c83c2e9d74a58679); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0c46e9ed331cf390c83c2e9d74a58679)): ?>
<?php $component = $__componentOriginal0c46e9ed331cf390c83c2e9d74a58679; ?>
<?php unset($__componentOriginal0c46e9ed331cf390c83c2e9d74a58679); ?>
<?php endif; ?>

					
					<?php if (isset($component)) { $__componentOriginal0c46e9ed331cf390c83c2e9d74a58679 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0c46e9ed331cf390c83c2e9d74a58679 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.checkbox-with-examples','data' => ['id' => 'study_performs_gonadectomy','label' => 'Performs a gonadectomy','model' => 'study_performs_gonadectomy']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.checkbox-with-examples'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'study_performs_gonadectomy','label' => 'Performs a gonadectomy','model' => 'study_performs_gonadectomy']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0c46e9ed331cf390c83c2e9d74a58679)): ?>
<?php $attributes = $__attributesOriginal0c46e9ed331cf390c83c2e9d74a58679; ?>
<?php unset($__attributesOriginal0c46e9ed331cf390c83c2e9d74a58679); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0c46e9ed331cf390c83c2e9d74a58679)): ?>
<?php $component = $__componentOriginal0c46e9ed331cf390c83c2e9d74a58679; ?>
<?php unset($__componentOriginal0c46e9ed331cf390c83c2e9d74a58679); ?>
<?php endif; ?>

					
					<?php if (isset($component)) { $__componentOriginal0c46e9ed331cf390c83c2e9d74a58679 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0c46e9ed331cf390c83c2e9d74a58679 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.checkbox-with-examples','data' => ['id' => 'study_performs_diet_modification','label' => 'Compares different animal diet conditions (testing of Nutrients, Phytochemicals, Probiotics)','model' => 'study_performs_diet_modification','examples' => 'High fat, high sugar, high phosphate, Calcium-Vitamin D supplementation, Caloric Restriction, Soy, Phytoestrogens, alcohol, probiotics, high salt, micronutrients, special diets','buttonText' => 'Example Dietary Changes']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.checkbox-with-examples'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'study_performs_diet_modification','label' => 'Compares different animal diet conditions (testing of Nutrients, Phytochemicals, Probiotics)','model' => 'study_performs_diet_modification','examples' => 'High fat, high sugar, high phosphate, Calcium-Vitamin D supplementation, Caloric Restriction, Soy, Phytoestrogens, alcohol, probiotics, high salt, micronutrients, special diets','buttonText' => 'Example Dietary Changes']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0c46e9ed331cf390c83c2e9d74a58679)): ?>
<?php $attributes = $__attributesOriginal0c46e9ed331cf390c83c2e9d74a58679; ?>
<?php unset($__attributesOriginal0c46e9ed331cf390c83c2e9d74a58679); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0c46e9ed331cf390c83c2e9d74a58679)): ?>
<?php $component = $__componentOriginal0c46e9ed331cf390c83c2e9d74a58679; ?>
<?php unset($__componentOriginal0c46e9ed331cf390c83c2e9d74a58679); ?>
<?php endif; ?>

					
					<?php if (isset($component)) { $__componentOriginal0c46e9ed331cf390c83c2e9d74a58679 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0c46e9ed331cf390c83c2e9d74a58679 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.checkbox-with-examples','data' => ['id' => 'study_controls_light_dark_cycle','label' => 'Compares different light/dark cycles','model' => 'study_controls_light_dark_cycle']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.checkbox-with-examples'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'study_controls_light_dark_cycle','label' => 'Compares different light/dark cycles','model' => 'study_controls_light_dark_cycle']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0c46e9ed331cf390c83c2e9d74a58679)): ?>
<?php $attributes = $__attributesOriginal0c46e9ed331cf390c83c2e9d74a58679; ?>
<?php unset($__attributesOriginal0c46e9ed331cf390c83c2e9d74a58679); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0c46e9ed331cf390c83c2e9d74a58679)): ?>
<?php $component = $__componentOriginal0c46e9ed331cf390c83c2e9d74a58679; ?>
<?php unset($__componentOriginal0c46e9ed331cf390c83c2e9d74a58679); ?>
<?php endif; ?>

					
					<?php if (isset($component)) { $__componentOriginala6191e173a29d7cb3002715ea2e926a8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala6191e173a29d7cb3002715ea2e926a8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.checkbox','data' => ['id' => 'study_compares_mouse_strains','label' => 'Compares different mouse strains','model' => 'study_compares_mouse_strains']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'study_compares_mouse_strains','label' => 'Compares different mouse strains','model' => 'study_compares_mouse_strains']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala6191e173a29d7cb3002715ea2e926a8)): ?>
<?php $attributes = $__attributesOriginala6191e173a29d7cb3002715ea2e926a8; ?>
<?php unset($__attributesOriginala6191e173a29d7cb3002715ea2e926a8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala6191e173a29d7cb3002715ea2e926a8)): ?>
<?php $component = $__componentOriginala6191e173a29d7cb3002715ea2e926a8; ?>
<?php unset($__componentOriginala6191e173a29d7cb3002715ea2e926a8); ?>
<?php endif; ?>
				</div>
			</div>
			<!-- End of Study Categories Card -->


            <!-- Genetic Modification Card -->
			<div class="card mb-4 bg-light" x-show="study_is_genetically_modified">
				<div class="card-header">
					<h4 class="fw-bold mb-0">What best describes the genetically modified animal model(s) in your study?</h4>
				</div>
				<div class="card-body">
					
					<h4 >Global Gene Mutation (every cell in the animal carries the functional change)</h4>
                    <?php if (isset($component)) { $__componentOriginala6191e173a29d7cb3002715ea2e926a8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala6191e173a29d7cb3002715ea2e926a8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.checkbox','data' => ['id' => 'gm_global_knockout','label' => 'Global targeted knockout or knock-in to alter an endogeneous gene\'s function','model' => 'gm_global_knockout']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'gm_global_knockout','label' => 'Global targeted knockout or knock-in to alter an endogeneous gene\'s function','model' => 'gm_global_knockout']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala6191e173a29d7cb3002715ea2e926a8)): ?>
<?php $attributes = $__attributesOriginala6191e173a29d7cb3002715ea2e926a8; ?>
<?php unset($__attributesOriginala6191e173a29d7cb3002715ea2e926a8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala6191e173a29d7cb3002715ea2e926a8)): ?>
<?php $component = $__componentOriginala6191e173a29d7cb3002715ea2e926a8; ?>
<?php unset($__componentOriginala6191e173a29d7cb3002715ea2e926a8); ?>
<?php endif; ?>

					<?php if (isset($component)) { $__componentOriginala6191e173a29d7cb3002715ea2e926a8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala6191e173a29d7cb3002715ea2e926a8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.checkbox','data' => ['id' => 'gm_induced_mutation','label' => 'Spontaneous, Chemical or X-Ray Induced Mutation (randomly generated point mutation or deletion that has been mapped)','model' => 'gm_induced_mutation']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'gm_induced_mutation','label' => 'Spontaneous, Chemical or X-Ray Induced Mutation (randomly generated point mutation or deletion that has been mapped)','model' => 'gm_induced_mutation']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala6191e173a29d7cb3002715ea2e926a8)): ?>
<?php $attributes = $__attributesOriginala6191e173a29d7cb3002715ea2e926a8; ?>
<?php unset($__attributesOriginala6191e173a29d7cb3002715ea2e926a8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala6191e173a29d7cb3002715ea2e926a8)): ?>
<?php $component = $__componentOriginala6191e173a29d7cb3002715ea2e926a8; ?>
<?php unset($__componentOriginala6191e173a29d7cb3002715ea2e926a8); ?>
<?php endif; ?>

					<?php if (isset($component)) { $__componentOriginala6191e173a29d7cb3002715ea2e926a8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala6191e173a29d7cb3002715ea2e926a8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.checkbox','data' => ['id' => 'gm_insertional_mutagenesis','label' => 'Insertional Mutagenesis: Gene Trap, Retroviral, or Transposon Mediated Mutagenesis.','model' => 'gm_insertional_mutagenesis']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'gm_insertional_mutagenesis','label' => 'Insertional Mutagenesis: Gene Trap, Retroviral, or Transposon Mediated Mutagenesis.','model' => 'gm_insertional_mutagenesis']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala6191e173a29d7cb3002715ea2e926a8)): ?>
<?php $attributes = $__attributesOriginala6191e173a29d7cb3002715ea2e926a8; ?>
<?php unset($__attributesOriginala6191e173a29d7cb3002715ea2e926a8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala6191e173a29d7cb3002715ea2e926a8)): ?>
<?php $component = $__componentOriginala6191e173a29d7cb3002715ea2e926a8; ?>
<?php unset($__componentOriginala6191e173a29d7cb3002715ea2e926a8); ?>
<?php endif; ?>

					
					<h4 class="mt-3">Conditionally Engineered Mouse Model (where genetic changes are implemented in a specific cell lineage)</h4>
					<?php if (isset($component)) { $__componentOriginala6191e173a29d7cb3002715ea2e926a8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala6191e173a29d7cb3002715ea2e926a8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.checkbox','data' => ['id' => 'gm_conditional_knockout','label' => 'Conditional Knockout or Knockin to alter an endogeneous gene\'s function in a specific cell lineage typically when intercrossed with Cre transgenic Mice (tissue/lineage specific loss of function)','model' => 'gm_conditional_knockout']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'gm_conditional_knockout','label' => 'Conditional Knockout or Knockin to alter an endogeneous gene\'s function in a specific cell lineage typically when intercrossed with Cre transgenic Mice (tissue/lineage specific loss of function)','model' => 'gm_conditional_knockout']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala6191e173a29d7cb3002715ea2e926a8)): ?>
<?php $attributes = $__attributesOriginala6191e173a29d7cb3002715ea2e926a8; ?>
<?php unset($__attributesOriginala6191e173a29d7cb3002715ea2e926a8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala6191e173a29d7cb3002715ea2e926a8)): ?>
<?php $component = $__componentOriginala6191e173a29d7cb3002715ea2e926a8; ?>
<?php unset($__componentOriginala6191e173a29d7cb3002715ea2e926a8); ?>
<?php endif; ?>

                    <?php if (isset($component)) { $__componentOriginala6191e173a29d7cb3002715ea2e926a8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala6191e173a29d7cb3002715ea2e926a8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.checkbox','data' => ['id' => 'gm_conditional_knockin_safe_harbor','label' => 'Conditional Knock-in into a specific gene or "Safe Harbor" site such as the Rosa Locus','model' => 'gm_conditional_knockin_safe_harbor']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'gm_conditional_knockin_safe_harbor','label' => 'Conditional Knock-in into a specific gene or "Safe Harbor" site such as the Rosa Locus','model' => 'gm_conditional_knockin_safe_harbor']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala6191e173a29d7cb3002715ea2e926a8)): ?>
<?php $attributes = $__attributesOriginala6191e173a29d7cb3002715ea2e926a8; ?>
<?php unset($__attributesOriginala6191e173a29d7cb3002715ea2e926a8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala6191e173a29d7cb3002715ea2e926a8)): ?>
<?php $component = $__componentOriginala6191e173a29d7cb3002715ea2e926a8; ?>
<?php unset($__componentOriginala6191e173a29d7cb3002715ea2e926a8); ?>
<?php endif; ?>

                    
                    <h4 class="mt-3">Transgenic Mouse Model</h4>
                    <?php if (isset($component)) { $__componentOriginala6191e173a29d7cb3002715ea2e926a8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala6191e173a29d7cb3002715ea2e926a8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.checkbox','data' => ['id' => 'gm_transgene','label' => 'Random Genome Integration of a Transgene (i.e. over expression of a coding sequence controlled by tissue specific regulatory sequences)','model' => 'gm_transgene']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'gm_transgene','label' => 'Random Genome Integration of a Transgene (i.e. over expression of a coding sequence controlled by tissue specific regulatory sequences)','model' => 'gm_transgene']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala6191e173a29d7cb3002715ea2e926a8)): ?>
<?php $attributes = $__attributesOriginala6191e173a29d7cb3002715ea2e926a8; ?>
<?php unset($__attributesOriginala6191e173a29d7cb3002715ea2e926a8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala6191e173a29d7cb3002715ea2e926a8)): ?>
<?php $component = $__componentOriginala6191e173a29d7cb3002715ea2e926a8; ?>
<?php unset($__componentOriginala6191e173a29d7cb3002715ea2e926a8); ?>
<?php endif; ?>
				</div>
			</div>
			

        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/study/animal-experimentation.blade.php ENDPATH**/ ?>