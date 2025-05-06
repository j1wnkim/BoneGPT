<div class="mb-4">
    <h4>Conditional Knockout Details</h4>
    <div class="row">
        <div class="col-md-6">
            <p><strong>Animal Model Name:</strong> {{ $study->gm_cond_knockout_animal_model_name }}</p>
            <p><strong>Gene Name:</strong> {{ $study->gm_cond_knockout_gene_name }}</p>
            <p><strong>Gene Symbol:</strong> {{ $study->gm_cond_knockout_gene_symbol }}</p>
            <p><strong>Gene Type:</strong> {{ $study->gm_cond_knockout_gene_type }}</p>
            @if($study->gm_cond_knockout_other_gene_type)
                <p><strong>Other Gene Type:</strong> {{ $study->gm_cond_knockout_other_gene_type }}</p>
            @endif
            <p><strong>Functional Change:</strong> {{ $study->gm_cond_knockout_functional_change }}</p>
            <p><strong>Animal Strain:</strong> {{ $study->gm_cond_knockout_animal_strain }}</p>
        </div>
        <div class="col-md-6">
            @if($study->gm_cond_knockout_other_animal_strain)
                <p><strong>Other Animal Strain:</strong> {{ $study->gm_cond_knockout_other_animal_strain }}</p>
            @endif
            <p><strong>Cre System Used:</strong> {{ $study->gm_cond_knockout_cre_system_used }}</p>
            <p><strong>Investigator Name:</strong> {{ $study->gm_cond_knockout_investigator_name }}</p>
            <p><strong>Modification Type:</strong> {{ $study->gm_cond_knockout_modification_type }}</p>
            <p><strong>Allele Schema:</strong> {{ $study->gm_cond_knockout_allele_schema }}</p>
            <p><strong>Allele Abbreviation:</strong> {{ $study->gm_cond_knockout_allele_abbreviation }}</p>
        </div>
    </div>

    @if($study->gm_cond_knockout_cre_system_used === 'Transgene')
        <h5 class="mt-4">Transgene Cre Details</h5>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Animal Line Name:</strong> {{ $study->gm_cond_knockout_transgene_cre_animal_line_name }}</p>
                <p><strong>Animal Line Abbreviation:</strong> {{ $study->gm_cond_knockout_transgene_cre_animal_line_abbreviation }}</p>
                <p><strong>Gene Name:</strong> {{ $study->gm_cond_knockout_transgene_gene_name }}</p>
                <p><strong>Tissue Lineage Specificity:</strong> {{ $study->gm_cond_knockout_transgene_tissue_lineage_specificity }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Animal Strain:</strong> {{ $study->gm_cond_knockout_transgene_animal_strain }}</p>
                @if($study->gm_cond_knockout_transgene_other_animal_strain)
                    <p><strong>Other Animal Strain:</strong> {{ $study->gm_cond_knockout_transgene_other_animal_strain }}</p>
                @endif
                <p><strong>Investigator Name:</strong> {{ $study->gm_cond_knockout_transgene_investigator_name }}</p>
            </div>
        </div>
    @endif

    @if($study->gm_cond_knockout_cre_system_used === 'Tamoxifen Inducible')
        <h5 class="mt-4">Tamoxifen Inducible Details</h5>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Animal Line Name:</strong> {{ $study->gm_cond_knockout_tamoxifen_cre_animal_line_name }}</p>
                <p><strong>Animal Line Abbreviation:</strong> {{ $study->gm_cond_knockout_tamoxifen_cre_animal_line_abbreviation }}</p>
                <p><strong>Gene Name:</strong> {{ $study->gm_cond_knockout_tamoxifen_gene_name }}</p>
                <p><strong>Tissue Lineage Specificity:</strong> {{ $study->gm_cond_knockout_tamoxifen_tissue_lineage_specificity }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Animal Strain:</strong> {{ $study->gm_cond_knockout_tamoxifen_animal_strain }}</p>
                @if($study->gm_cond_knockout_tamoxifen_other_animal_strain)
                    <p><strong>Other Animal Strain:</strong> {{ $study->gm_cond_knockout_tamoxifen_other_animal_strain }}</p>
                @endif
                <p><strong>Tamoxifen Type:</strong> {{ $study->gm_cond_knockout_tamoxifen_tamoxifen_type }}</p>
                <p><strong>Investigator Name:</strong> {{ $study->gm_cond_knockout_tamoxifen_investigator_name }}</p>
            </div>
        </div>
    @endif

    @if($study->gm_cond_knockout_cre_system_used === 'Doxycycline Regulated')
        <h5 class="mt-4">Doxycycline Regulated Details</h5>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Animal Line Name:</strong> {{ $study->gm_cond_knockout_doxy_cre_animal_line_name }}</p>
                <p><strong>Animal Line Abbreviation:</strong> {{ $study->gm_cond_knockout_doxy_cre_animal_line_abbreviation }}</p>
                <p><strong>Gene Name:</strong> {{ $study->gm_cond_knockout_doxy_gene_name }}</p>
                <p><strong>Tissue Lineage Specificity:</strong> {{ $study->gm_cond_knockout_doxy_tissue_lineage_specificity }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Animal Strain:</strong> {{ $study->gm_cond_knockout_doxy_animal_strain }}</p>
                @if($study->gm_cond_knockout_doxy_other_animal_strain)
                    <p><strong>Other Animal Strain:</strong> {{ $study->gm_cond_knockout_doxy_other_animal_strain }}</p>
                @endif
                <p><strong>Doxycycline Type:</strong> {{ $study->gm_cond_knockout_doxy_doxycycline_type }}</p>
                <p><strong>Investigator Name:</strong> {{ $study->gm_cond_knockout_doxy_investigator_name }}</p>
            </div>
        </div>
    @endif
</div>