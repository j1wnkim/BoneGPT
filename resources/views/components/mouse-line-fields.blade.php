<div x-data="{
	
}">
    @if ($title)
        <h3>{{ $title }}</h3>
    @endif

	<div class="form-group mb-3">
		<label for="" class="form-label">Name of Animal Model </label>
		<input type="text" name="" id="" class="form-control" x-model="animalModelName" placeholder=" ">
	</div>

	<div class="form-group mb-3">
        <label for="" class="form-label">
            
        </label>
        <input type="text" name="{{ $prefix }}_investigator_name{{ $isSecondLine ? '_2' : '' }}" id="{{ $prefix }}_investigator_name{{ $isSecondLine ? '_2' : '' }}" class="form-control" x-model="investigatorName" placeholder=" ">
    </div>

    <div class="form-group mb-3">
        <label for="{{ $prefix }}_gene_name{{ $isSecondLine ? '_2' : '' }}" class="form-label">
            {{{ sprintf($nameLabel, $isSecondLine ? '2' : '') }}}
        </label>
        <input type="text" name="{{ $prefix }}_gene_name{{ $isSecondLine ? '_2' : '' }}" id="{{ $prefix }}_gene_name{{ $isSecondLine ? '_2' : '' }}" class="form-control" x-model="geneName" placeholder=" ">
    </div>

    <div class="form-group mb-3">
        <label for="{{ $prefix }}_gene_symbol{{ $isSecondLine ? '_2' : '' }}" class="form-label">Gene Symbol of Genetically Modified Gene @if($isSecondLine) 2 @endif</label>
        <input type="text" name="{{ $prefix }}_gene_symbol{{ $isSecondLine ? '_2' : '' }}" id="{{ $prefix }}_gene_symbol{{ $isSecondLine ? '_2' : '' }}" class="form-control" x-model="geneSymbol" placeholder=" ">
    </div>

    @if($prefix !== 'gm_cond_knockout')
        <div class="form-group mb-3">
            <label for="{{ $prefix }}_modification_type{{ $isSecondLine ? '_2' : '' }}" class="form-label">Type of Genetic Modification @if($isSecondLine) 2 @endif</label>
            <select name="{{ $prefix }}_modification_type{{ $isSecondLine ? '_2' : '' }}" id="{{ $prefix }}_modification_type{{ $isSecondLine ? '_2' : '' }}" x-model="modificationType" class="form-select">
                <option value="">Select type...</option>
                @foreach($modificationTypes as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>
    @endif

    <div class="form-group mb-3">
        <label for="{{ $prefix }}_allele_schema{{ $isSecondLine ? '_2' : '' }}" class="form-label">Mutant Allele Schema to Follow @if($isSecondLine) 2 @endif</label>
        <select name="{{ $prefix }}_allele_schema{{ $isSecondLine ? '_2' : '' }}" id="{{ $prefix }}_allele_schema{{ $isSecondLine ? '_2' : '' }}" x-model="alleleSchema" class="form-select">
            <option value="">Select schema...</option>
            @foreach($alleleSchemas as $value => $label)
                <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
        </select>

        <div class="form-group mt-3" x-show="alleleSchema === 'other'">
            <label for="{{ $prefix }}_allele_abbreviation{{ $isSecondLine ? '_2' : '' }}" class="form-label">
				Mutant Allele Abbreviation/Symbol @if($isSecondLine) 2 @endif
				<span class="text-muted">(max 4 characters)</span>
			</label>
            <input 
                type="text" 
                name="{{ $prefix }}_allele_abbreviation{{ $isSecondLine ? '_2' : '' }}" 
                id="{{ $prefix }}_allele_abbreviation{{ $isSecondLine ? '_2' : '' }}" 
                class="form-control" 
                x-model="alleleAbbreviation"
                maxlength="4"
                placeholder=" "
            >
        </div>
    </div>

    <div class="form-group mb-3">
        <label for="{{ $prefix }}_gene_type{{ $isSecondLine ? '_2' : '' }}" class="form-label">Type of Gene @if($isSecondLine) 2 @endif</label>
        <select name="{{ $prefix }}_gene_type{{ $isSecondLine ? '_2' : '' }}" id="{{ $prefix }}_gene_type{{ $isSecondLine ? '_2' : '' }}" x-model="geneType" class="form-select">
            <option value="">Select type...</option>
            @foreach($geneTypes as $value => $label)
                <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group mb-3" x-show="geneType === 'other'">
        <label for="{{ $prefix }}_other_gene_type{{ $isSecondLine ? '_2' : '' }}" class="form-label">Other Gene @if($isSecondLine) 2 @endif Type</label>
        <input type="text" name="{{ $prefix }}_other_gene_type{{ $isSecondLine ? '_2' : '' }}" id="{{ $prefix }}_other_gene_type{{ $isSecondLine ? '_2' : '' }}" class="form-control" x-model="otherGeneType" placeholder=" ">
    </div>

    <div class="form-group mb-3">
        <label for="{{ $prefix }}_functional_change{{ $isSecondLine ? '_2' : '' }}" class="form-label">Functional Change @if($isSecondLine) 2 @endif</label>
        <select name="{{ $prefix }}_functional_change{{ $isSecondLine ? '_2' : '' }}" id="{{ $prefix }}_functional_change{{ $isSecondLine ? '_2' : '' }}" class="form-select" x-model="functionalChange">
            <option value="">Select change...</option>
            @foreach($functionalChangeOptions as $value => $label)
                <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group mb-3">
        <label for="{{ $prefix }}_animal_strain{{ $isSecondLine ? '_2' : '' }}" class="form-label">Animal Strain @if($isSecondLine) 2 @endif</label>
        <select name="{{ $prefix }}_animal_strain{{ $isSecondLine ? '_2' : '' }}" id="{{ $prefix }}_animal_strain{{ $isSecondLine ? '_2' : '' }}" class="form-select" x-model="mouseStrain">
            <option value="">Select strain...</option>
            @foreach($mouseStrains as $value => $label)
                <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group mb-3" x-show="mouseStrain === 'other'">
        <label for="" class="form-label">Other Animal Strain @if($isSecondLine) 2 @endif</label>
        <input type="text" name="{{ $prefix }}_other_animal_strain{{ $isSecondLine ? '_2' : '' }}" id="{{ $prefix }}_other_animal_strain{{ $isSecondLine ? '_2' : '' }}" class="form-control" x-model="otherAnimalStrain" placeholder=" ">
    </div>
</div>
