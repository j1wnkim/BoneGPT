<div x-data="{
    animalStrain: {{ Js::from($study->{$prefix . '_animal_strain' . ($isSecondLine ? '_2' : '')} ?? '') }},
    animalModelName: {{ Js::from($study->{$prefix . '_animal_model_name' . ($isSecondLine ? '_2' : '')} ?? '') }},
    animalNameAbbreviation: {{ Js::from($study->{$prefix . '_animal_name_abbreviation' . ($isSecondLine ? '_2' : '')} ?? '') }},
    geneName: {{ Js::from($study->{$prefix . '_gene_name' . ($isSecondLine ? '_2' : '')} ?? '') }},
    tissueLineageSpecificity: {{ Js::from($study->{$prefix . '_tissue_lineage_specificity' . ($isSecondLine ? '_2' : '')} ?? '') }},
    geneProductExpressed: {{ Js::from($study->{$prefix . '_gene_product_expressed_by_transgene' . ($isSecondLine ? '_2' : '')} ?? '') }},
    functionOfTransgene: {{ Js::from($study->{$prefix . '_function_of_transgene' . ($isSecondLine ? '_2' : '')} ?? '') }},
    otherFunctionOfTransgene: {{ Js::from($study->{$prefix . '_other_function_of_transgene' . ($isSecondLine ? '_2' : '')} ?? '') }},
    codingSequenceType: {{ Js::from($study->{$prefix . '_coding_sequence_type' . ($isSecondLine ? '_2' : '')} ?? '') }},
    otherCodingSequenceType: {{ Js::from($study->{$prefix . '_other_coding_sequence_type' . ($isSecondLine ? '_2' : '')} ?? '') }},
    otherAnimalStrain: {{ Js::from($study->{$prefix . '_other_animal_strain' . ($isSecondLine ? '_2' : '')} ?? '') }},
	alleleSchema: {{ Js::from($study->{$prefix . '_allele_schema' . ($isSecondLine ? '_2' : '')} ?? '') }},
	otherAlleleSchema: {{ Js::from($study->{$prefix . '_other_allele_schema' . ($isSecondLine ? '_2' : '')} ?? '') }},
	investigatorName: {{ Js::from($study->{$prefix . '_investigator_name' . ($isSecondLine ? '_2' : '')} ?? '') }}
}">
	@if ($title)
		<h3>{{ $title }}</h3>
	@endif

	<div class="form-group mb-3">
		<label for="{{ $prefix }}_animal_model_name{{ $isSecondLine ? '_2' : '' }}" class="form-label">Name of Transgenic Animal Model @if($isSecondLine) 2 @endif</label>
		<input type="text" name="{{ $prefix }}_animal_model_name{{ $isSecondLine ? '_2' : '' }}" id="{{ $prefix }}_animal_model_name{{ $isSecondLine ? '_2' : '' }}" class="form-control" x-model="animalModelName">
	</div>

	<div class="form-group mb-3">
		<label for="{{ $prefix }}_animal_name_abbreviation{{ $isSecondLine ? '_2' : '' }}" class="form-label">Abbreviated Name of Transgenic Mouse Line @if($isSecondLine) 2 @endif</label>
		<input type="text" name="{{ $prefix }}_animal_name_abbreviation{{ $isSecondLine ? '_2' : '' }}" id="{{ $prefix }}_animal_name_abbreviation{{ $isSecondLine ? '_2' : '' }}" class="form-control" x-model="animalNameAbbreviation">
	</div>

	<div class="form-group mb-3">
		<label for="{{ $prefix }}_investigator_name{{ $isSecondLine ? '_2' : '' }}" class="form-label">Full Name of Investigator from which Animal Model Originated @if($isSecondLine) 2 @endif</label>
		<input type="text" name="{{ $prefix }}_investigator_name{{ $isSecondLine ? '_2' : '' }}" id="{{ $prefix }}_investigator_name{{ $isSecondLine ? '_2' : '' }}" class="form-control" x-model="investigatorName">
	</div>

	<div class="form-group mb-3">
		<label for="{{ $prefix }}_gene_name{{ $isSecondLine ? '_2' : '' }}" class="form-label">Name of Gene from which Regulatory Sequences were derived to Drive the Expression of the Desired Product @if($isSecondLine) 2 @endif</label>
		<input type="text" name="{{ $prefix }}_gene_name{{ $isSecondLine ? '_2' : '' }}" id="{{ $prefix }}_gene_name{{ $isSecondLine ? '_2' : '' }}" class="form-control" x-model="geneName">
	</div>

	<div class="form-group mb-3">
		<label for="{{ $prefix }}_tissue_lineage_specificity{{ $isSecondLine ? '_2' : '' }}" class="form-label">Tissue/Cell Lineage Specificity of Transgenic Line @if($isSecondLine) 2 @endif</label>
		<input type="text" name="{{ $prefix }}_tissue_lineage_specificity{{ $isSecondLine ? '_2' : '' }}" id="{{ $prefix }}_tissue_lineage_specificity{{ $isSecondLine ? '_2' : '' }}" class="form-control" x-model="tissueLineageSpecificity">
	</div>

	<div class="form-group mb-3">
		<label for="{{ $prefix }}_allele_schema{{ $isSecondLine ? '_2' : '' }}" class="form-label">Allele Schema @if($isSecondLine) 2 @endif</label>
		<select name="{{ $prefix }}_allele_schema{{ $isSecondLine ? '_2' : '' }}" id="{{ $prefix }}_allele_schema{{ $isSecondLine ? '_2' : '' }}" class="form-control" x-model="alleleSchema">
			<option value="">Select allele schema...</option>
			@foreach($alleleSchemas as $value => $label)
				<option value="{{ $value }}">{{ $label }}</option>
			@endforeach
		</select>

		<div class="form-group mb-3" x-show="alleleSchema === 'other'">
			<label for="{{ $prefix }}_other_allele_schema{{ $isSecondLine ? '_2' : '' }}" class="form-label">Other Allele Schema @if($isSecondLine) 2 @endif</label>
			<input type="text" name="{{ $prefix }}_other_allele_schema{{ $isSecondLine ? '_2' : '' }}" id="{{ $prefix }}_other_allele_schema{{ $isSecondLine ? '_2' : '' }}" class="form-control" x-model="otherAlleleSchema">
		</div>
	</div>

	<div class="form-group mb-3">
		<label for="{{ $prefix }}_gene_product_expressed_by_transgene{{ $isSecondLine ? '_2' : '' }}" class="form-label">Name of the Gene Product being expressed by the transgene @if($isSecondLine) 2 @endif</label>
		<input type="text" name="{{ $prefix }}_gene_product_expressed_by_transgene{{ $isSecondLine ? '_2' : '' }}" id="{{ $prefix }}_gene_product_expressed_by_transgene{{ $isSecondLine ? '_2' : '' }}" class="form-control" x-model="geneProductExpressed">
	</div>

	{{-- Function of the Transgene --}}
	<div class="form-group mb-3">
		<label for="{{ $prefix }}_function_of_transgene{{ $isSecondLine ? '_2' : '' }}" class="form-label">Function of the Transgene @if($isSecondLine) 2 @endif</label>
		<select name="{{ $prefix }}_function_of_transgene{{ $isSecondLine ? '_2' : '' }}" id="{{ $prefix }}_function_of_transgene{{ $isSecondLine ? '_2' : '' }}" class="form-control" x-model="functionOfTransgene">
			<option value="">Select function...</option>
			@foreach($transgeneFunction as $value => $label)
				<option value="{{ $value }}">{{ $label }}</option>
			@endforeach
		</select>
	</div>

	{{-- This might not be needed anymore? --}}
	{{-- Other Function of the Transgene --}}
	<div class="form-group mb-3" x-show="functionOfTransgene === 'other'">
		<label for="{{ $prefix }}_other_function_of_transgene{{ $isSecondLine ? '_2' : '' }}" class="form-label">Other Function of the Transgene @if($isSecondLine) 2 @endif</label>
		<input type="text" name="{{ $prefix }}_other_function_of_transgene{{ $isSecondLine ? '_2' : '' }}" id="{{ $prefix }}_other_function_of_transgene{{ $isSecondLine ? '_2' : '' }}" class="form-control" x-model="otherFunctionOfTransgene">
	</div>

	{{-- Type of Coding Sequence --}}
	<div class="form-group mb-3">
		<label for="{{ $prefix }}_coding_sequence_type{{ $isSecondLine ? '_2' : '' }}" class="form-label">Type of Coding Sequence @if($isSecondLine) 2 @endif</label>
		<select name="{{ $prefix }}_coding_sequence_type{{ $isSecondLine ? '_2' : '' }}" id="{{ $prefix }}_coding_sequence_type{{ $isSecondLine ? '_2' : '' }}" class="form-control" x-model="codingSequenceType">
			<option value="">Select type...</option>
			@foreach($codingSequence as $value => $label)
				<option value="{{ $value }}">{{ $label }}</option>
			@endforeach
		</select>
	</div>

	{{-- Other Type of Coding Sequence --}}
	<div class="form-group mb-3" x-show="codingSequenceType === 'other'">
		<label for="{{ $prefix }}_other_coding_sequence_type{{ $isSecondLine ? '_2' : '' }}" class="form-label">Other Type of Coding Sequence @if($isSecondLine) 2 @endif</label>
		<input type="text" name="{{ $prefix }}_other_coding_sequence_type{{ $isSecondLine ? '_2' : '' }}" id="{{ $prefix }}_other_coding_sequence_type{{ $isSecondLine ? '_2' : '' }}" class="form-control" x-model="otherCodingSequenceType">
	</div>

	{{-- Animal Strain --}}
	<div class="form-group mb-3">
        <label for="{{ $prefix }}_animal_strain{{ $isSecondLine ? '_2' : '' }}" class="form-label">Animal Strain @if($isSecondLine) 2 @endif</label>
        <select name="{{ $prefix }}_animal_strain{{ $isSecondLine ? '_2' : '' }}" id="{{ $prefix }}_animal_strain{{ $isSecondLine ? '_2' : '' }}" class="form-control" x-model="animalStrain">
			<option value="">Select strain...</option>
			@foreach($animalStrains as $value => $label)
				<option value="{{ $value }}">{{ $label }}</option>
			@endforeach
        </select>
    </div>

	{{-- Other Animal Strain --}}
	<div class="form-group mb-3" x-show="animalStrain === 'other'">
        <label for="{{ $prefix }}_other_animal_strain{{ $isSecondLine ? '_2' : '' }}" class="form-label">Other Animal Strain @if($isSecondLine) 2 @endif</label>
        <input type="text" name="{{ $prefix }}_other_animal_strain{{ $isSecondLine ? '_2' : '' }}" id="{{ $prefix }}_other_animal_strain{{ $isSecondLine ? '_2' : '' }}" class="form-control" x-model="otherAnimalStrain">
    </div>
</div>