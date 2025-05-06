<div x-data="{
	
}">
    <div class="space-y-4">
        <!-- Knockin Safe Harbor Locus Name -->
        <div class="form-group mb-3">
            <label for="gm_cond_knockin_safe_harbor_locus_name" class="form-label">Locus Name of Safe Harbor Site</label>
            <input type="text" 
                name="gm_cond_knockin_safe_harbor_locus_name" 
                id="gm_cond_knockin_safe_harbor_locus_name" 
                class="form-control" 
                x-model="locusName">
        </div>

        <!-- Animal Model Name -->
        <div class="form-group mb-3">
            <label for="{{ $prefix }}_animal_model_name" class="form-label">Name of Animal Model</label>
            <input type="text" 
                name="{{ $prefix }}_animal_model_name" 
                id="{{ $prefix }}_animal_model_name" 
                class="form-control" 
                x-model="animalModelName">
        </div>

        <!-- Abbreviate Name of Animal Model -->
        <div class="form-group mb-3">
            <label for="{{ $prefix }}_abbreviated_name" class="form-label">Abbreviate Name of Animal Model</label>
            <input type="text" 
                name="{{ $prefix }}_abbreviated_name" 
                id="{{ $prefix }}_abbreviated_name" 
                class="form-control" 
                x-model="abbreviatedName">
            <small class="form-text text-muted">Used to identify animal model in figures</small>
        </div>

		{{-- Name of Investigator --}}
		<div class="form-group mb-3">
			<label for="{{ $prefix }}_investigator_name" class="form-label">
				Full Name of Investigator from which Animal Model Originated
			</label>
			<input type="text" name="{{ $prefix }}_investigator_name" id="{{ $prefix }}_investigator_name" class="form-control" x-model="investigatorName">
		</div>

        <!-- Gene Product -->
        <div class="form-group mb-3">
            <label for="{{ $prefix }}_gene_product" class="form-label">Name of the Gene Product being expressed</label>
            <input type="text" 
                name="{{ $prefix }}_gene_product" 
                id="{{ $prefix }}_gene_product" 
                class="form-control" 
                x-model="geneProduct">
        </div>

		{{-- Allele Schema --}}
		<div class="form-group mb-3">
			<label for="{{ $prefix }}_allele_schema" class="form-label">Mutant Allele Schema to Follow</label>
			<select name="{{ $prefix }}_allele_schema" id="{{ $prefix }}_allele_schema" class="form-select" x-model="alleleSchema">
				<option value="">Select schema...</option>
				@foreach($alleleSchemas as $value => $label)
					<option value="{{ $value }}">{{ $label }}</option>
				@endforeach
			</select>

			<div class="form-group mt-3" x-show="alleleSchema === 'other'">
				<label for="{{ $prefix }}_other_allele_schema" class="form-label">Other Allele Schema</label>
				<input type="text" name="{{ $prefix }}_other_allele_schema" id="{{ $prefix }}_other_allele_schema" class="form-control" x-model="otherAlleleSchema">
			</div>
		</div>
		
        <!-- Transgene Function -->
        <div class="form-group mb-3">
            <label for="{{ $prefix }}_transgene_function" class="form-label">Function of the Transgene</label>
            <select name="{{ $prefix }}_transgene_function" 
                id="{{ $prefix }}_transgene_function" 
                class="form-select" 
                x-model="transgeneFunction">
                <option value="">Select function...</option>
                @foreach($transgeneFunction as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <!-- Coding Sequence Type -->
        <div class="form-group mb-3">
            <label for="{{ $prefix }}_coding_sequence_type" class="form-label">Type of coding sequence</label>
            <select name="{{ $prefix }}_coding_sequence_type" 
                id="{{ $prefix }}_coding_sequence_type" 
                class="form-select" 
                x-model="codingSequenceType">
                <option value="">Select type...</option>
                @foreach($codingSequenceTypes as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <!-- Animal Strain -->
        <div class="form-group mb-3">
            <label for="{{ $prefix }}_animal_strain" class="form-label">Animal Strain</label>
            <select name="{{ $prefix }}_animal_strain" 
                id="{{ $prefix }}_animal_strain" 
                class="form-select" 
                x-model="animalStrain">
                <option value="">Select strain...</option>
                @foreach($animalStrains as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>