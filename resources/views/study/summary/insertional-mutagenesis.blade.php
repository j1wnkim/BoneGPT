<div class="mb-4">
    <h4>Insertional Mutagenesis Details</h4>
    <div class="row">
        <div class="col-md-6">
            <p><strong>Animal Model Name:</strong> {{ $study->gm_ins_mutagenesis_animal_model_name }}</p>
            <p><strong>Gene Name:</strong> {{ $study->gm_ins_mutagenesis_gene_name }}</p>
            <p><strong>Gene Symbol:</strong> {{ $study->gm_ins_mutagenesis_gene_symbol }}</p>
            <p><strong>Gene Type:</strong> {{ $study->gm_ins_mutagenesis_gene_type }}</p>
            @if($study->gm_ins_mutagenesis_other_gene_type)
                <p><strong>Other Gene Type:</strong> {{ $study->gm_ins_mutagenesis_other_gene_type }}</p>
            @endif
        </div>
        <div class="col-md-6">
            <p><strong>Functional Change:</strong> {{ $study->gm_ins_mutagenesis_functional_change }}</p>
            <p><strong>Animal Strain:</strong> {{ $study->gm_ins_mutagenesis_animal_strain }}</p>
            @if($study->gm_ins_mutagenesis_other_animal_strain)
                <p><strong>Other Animal Strain:</strong> {{ $study->gm_ins_mutagenesis_other_animal_strain }}</p>
            @endif
            <p><strong>Investigator Name:</strong> {{ $study->gm_ins_mutagenesis_investigator_name }}</p>
            <p><strong>Modification Type:</strong> {{ $study->gm_ins_mutagenesis_modification_type }}</p>
            <p><strong>Allele Schema:</strong> {{ $study->gm_ins_mutagenesis_allele_schema }}</p>
            <p><strong>Allele Abbreviation:</strong> {{ $study->gm_ins_mutagenesis_allele_abbreviation }}</p>
            <p><strong>Freeform Nomenclature:</strong> {{ $study->gm_ins_mutagenesis_freeform_nomenclature }}</p>
        </div>
    </div>
</div>