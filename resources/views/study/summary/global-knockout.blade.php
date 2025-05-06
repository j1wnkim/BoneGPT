<div class="mb-4">
    <h4>Global Knockout Details</h4>
    <div class="row">
        <div class="col-md-6">
            <p><strong>Animal Model Name:</strong> {{ $study->gm_gko_animal_model_name }}</p>
            <p><strong>Gene Name:</strong> {{ $study->gm_gko_gene_name }}</p>
            <p><strong>Gene Symbol:</strong> {{ $study->gm_gko_gene_symbol }}</p>
            <p><strong>Gene Type:</strong> {{ $study->gm_gko_gene_type }}</p>
            @if($study->gm_gko_other_gene_type)
                <p><strong>Other Gene Type:</strong> {{ $study->gm_gko_other_gene_type }}</p>
            @endif
            <p><strong>Allele Nomenclature:</strong> {{ $study->gm_gko_allele_nomenclature }}</p>
            @if($study->gm_gko_other_allele_nomenclature)
                <p><strong>Other Allele Nomenclature:</strong> {{ $study->gm_gko_other_allele_nomenclature }}</p>
            @endif
        </div>
        <div class="col-md-6">
            <p><strong>Functional Change:</strong> {{ $study->gm_gko_functional_change }}</p>
            <p><strong>Animal Strain:</strong> {{ $study->gm_gko_animal_strain }}</p>
            @if($study->gm_gko_other_animal_strain)
                <p><strong>Other Animal Strain:</strong> {{ $study->gm_gko_other_animal_strain }}</p>
            @endif
            <p><strong>Investigator Name:</strong> {{ $study->gm_gko_investigator_name }}</p>
            <p><strong>Modification Type:</strong> {{ $study->gm_gko_modification_type }}</p>
            <p><strong>Allele Schema:</strong> {{ $study->gm_gko_allele_schema }}</p>
            <p><strong>Allele Abbreviation:</strong> {{ $study->gm_gko_allele_abbreviation }}</p>
        </div>
    </div>
    
    @if($study->gm_gko_has_second_animal_line)
        <h5 class="mt-4">Second Animal Line</h5>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Animal Model Name:</strong> {{ $study->gm_gko_animal_model_name_2 }}</p>
                <p><strong>Gene Name:</strong> {{ $study->gm_gko_gene_name_2 }}</p>
                <p><strong>Gene Symbol:</strong> {{ $study->gm_gko_gene_symbol_2 }}</p>
                <p><strong>Gene Type:</strong> {{ $study->gm_gko_gene_type_2 }}</p>
                @if($study->gm_gko_other_gene_type_2)
                    <p><strong>Other Gene Type:</strong> {{ $study->gm_gko_other_gene_type_2 }}</p>
                @endif
                <p><strong>Allele Nomenclature:</strong> {{ $study->gm_gko_allele_nomenclature_2 }}</p>
                @if($study->gm_gko_other_allele_nomenclature_2)
                    <p><strong>Other Allele Nomenclature:</strong> {{ $study->gm_gko_other_allele_nomenclature_2 }}</p>
                @endif
            </div>
            <div class="col-md-6">
                <p><strong>Functional Change:</strong> {{ $study->gm_gko_functional_change_2 }}</p>
                <p><strong>Animal Strain:</strong> {{ $study->gm_gko_animal_strain_2 }}</p>
                @if($study->gm_gko_other_animal_strain_2)
                    <p><strong>Other Animal Strain:</strong> {{ $study->gm_gko_other_animal_strain_2 }}</p>
                @endif
                <p><strong>Investigator Name:</strong> {{ $study->gm_gko_investigator_name_2 }}</p>
                <p><strong>Modification Type:</strong> {{ $study->gm_gko_modification_type_2 }}</p>
                <p><strong>Allele Schema:</strong> {{ $study->gm_gko_allele_schema_2 }}</p>
                <p><strong>Allele Abbreviation:</strong> {{ $study->gm_gko_allele_abbreviation_2 }}</p>
            </div>
        </div>
    @endif
</div>