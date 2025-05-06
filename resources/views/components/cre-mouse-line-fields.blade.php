{{-- TODO: Probably want to rename this file. Also take a look at how names, ids, etc. are generated --}}
<div x-data="{
    animalStrain: {{ Js::from($study->{$prefix . '_animal_strain'} ?? '') }},
    creAnimalLineName: {{ Js::from($study->{$prefix . '_cre_animal_line_name'} ?? '') }},
    creAnimalLineAbbreviation: {{ Js::from($study->{$prefix . '_cre_animal_line_abbreviation'} ?? '') }},
    geneName: {{ Js::from($study->{$prefix . '_gene_name'} ?? '') }},
	alleleSchema: {{ Js::from($study->{$prefix . '_allele_schema'} ?? '') }},
    otherAlleleSchema: {{ Js::from($study->{$prefix . '_other_allele_schema'} ?? '') }},
    tissueLineageSpecificity: {{ Js::from($study->{$prefix . '_tissue_lineage_specificity'} ?? '') }},
    otherAnimalStrain: {{ Js::from($study->{$prefix . '_other_animal_strain'} ?? '') }},
    investigatorName: {{ Js::from($study->{$prefix . '_investigator_name'} ?? '') }},
}">
	<h3>{{ $title }}</h3>

	<div class="form-group mb-3">
		<label for="{{ $prefix }}_cre_animal_line_name" class="form-label">Full Name of Cre Recombinase Mouse Line</label>
		<input type="text" name="{{ $prefix }}_cre_animal_line_name" id="{{ $prefix }}_cre_animal_line_name" class="form-control" x-model="creAnimalLineName">
	</div>

	<div class="form-group mb-3">
		<label for="{{ $prefix }}_cre_animal_line_abbreviation" class="form-label">Abbreviate Name of Cre Line</label>
		<input type="text" name="{{ $prefix }}_cre_animal_line_abbreviation" id="{{ $prefix }}_cre_animal_line_abbreviation" class="form-control" x-model="creAnimalLineAbbreviation">
	</div>

	<div class="form-group mb-3">
        <label for="{{ $prefix }}_investigator_name" class="form-label">
            Full Name of Investigator from which Animal Model Originated
        </label>
        <input type="text" name="{{ $prefix }}_investigator_name" id="{{ $prefix }}_investigator_name" class="form-control" x-model="investigatorName">
    </div>

	<div class="form-group mb-3">
		<label for="{{ $prefix }}_gene_name" class="form-label">Name of Gene from which Regulatory Sequences were used to Drive the Expression of the Cre Recombinase</label>
		<input type="text" name="{{ $prefix }}_gene_name" id="{{ $prefix }}_gene_name" class="form-control" x-model="geneName">
	</div>

	<div class="form-group mb-3">
		<label for="{{ $prefix }}_allele_schema" class="form-label">Allele Schema to Follow</label>
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

	<div class="form-group mb-3">
		<label for="{{ $prefix }}_tissue_lineage_specificity" class="form-label">Tissue/Cell Lineage Specificity of Cre Line</label>
		<input type="text" name="{{ $prefix }}_tissue_lineage_specificity" id="{{ $prefix }}_tissue_lineage_specificity" class="form-control" x-model="tissueLineageSpecificity">
	</div>

	<div class="form-group mb-3">
        <label for="{{ $prefix }}_animal_strain" class="form-label">Animal Strain</label>
        <select name="{{ $prefix }}_animal_strain" id="{{ $prefix }}_animal_strain" class="form-control" x-model="animalStrain">
			<option value="">Select strain...</option>
			@foreach($animalStrains as $value => $label)
				<option value="{{ $value }}">{{ $label }}</option>
			@endforeach
        </select>
    </div>

	<div class="form-group mb-3" x-show="animalStrain === 'other'">
        <label for="{{ $prefix }}_other_animal_strain" class="form-label">Other Animal Strain</label>
        <input type="text" name="{{ $prefix }}_other_animal_strain" id="{{ $prefix }}_other_animal_strain" class="form-control" x-model="otherAnimalStrain">
    </div>
</div>