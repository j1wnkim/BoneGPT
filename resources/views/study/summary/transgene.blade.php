<div class="mb-4">
    <h4>Random Genome Integration Details</h4>
    <div class="row">
        <div class="col-md-6">
            <p><strong>Animal Model Name:</strong> {{ $study->gm_random_genome_animal_model_name }}</p>
            <p><strong>Animal Name Abbreviation:</strong> {{ $study->gm_random_genome_animal_name_abbreviation }}</p>
            <p><strong>Gene Name:</strong> {{ $study->gm_random_genome_gene_name }}</p>
            <p><strong>Tissue Lineage Specificity:</strong> {{ $study->gm_random_genome_tissue_lineage_specificity }}</p>
            <p><strong>Gene Product Expressed:</strong> {{ $study->gm_random_genome_gene_product_expressed_by_transgene }}</p>
            <p><strong>Function of Transgene:</strong> {{ $study->gm_random_genome_function_of_transgene }}</p>
            @if($study->gm_random_genome_other_function_of_transgene)
                <p><strong>Other Function of Transgene:</strong> {{ $study->gm_random_genome_other_function_of_transgene }}</p>
            @endif
        </div>
        <div class="col-md-6">
            <p><strong>Coding Sequence Type:</strong> {{ $study->gm_random_genome_coding_sequence_type }}</p>
            @if($study->gm_random_genome_other_coding_sequence_type)
                <p><strong>Other Coding Sequence Type:</strong> {{ $study->gm_random_genome_other_coding_sequence_type }}</p>
            @endif
            <p><strong>Animal Strain:</strong> {{ $study->gm_random_genome_animal_strain }}</p>
            @if($study->gm_random_genome_other_animal_strain)
                <p><strong>Other Animal Strain:</strong> {{ $study->gm_random_genome_other_animal_strain }}</p>
            @endif
            <p><strong>Animal Model Obtained From:</strong> {{ $study->gm_random_genome_animal_model_obtained_from }}</p>
            <p><strong>Drug Inducible Mechanism:</strong> {{ $study->gm_random_genome_utilizes_drug_inducible_mechanism ? 'Yes' : 'No' }}</p>
        </div>
    </div>

    @if($study->gm_random_genome_second_animal_line)
        <h5 class="mt-4">Second Animal Line</h5>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Animal Model Name:</strong> {{ $study->gm_random_genome_animal_model_name_2 }}</p>
                <p><strong>Animal Name Abbreviation:</strong> {{ $study->gm_random_genome_animal_name_abbreviation_2 }}</p>
                <p><strong>Gene Name:</strong> {{ $study->gm_random_genome_gene_name_2 }}</p>
                <p><strong>Tissue Lineage Specificity:</strong> {{ $study->gm_random_genome_tissue_lineage_specificity_2 }}</p>
                <p><strong>Gene Product Expressed:</strong> {{ $study->gm_random_genome_gene_product_expressed_by_transgene_2 }}</p>
                <p><strong>Function of Transgene:</strong> {{ $study->gm_random_genome_function_of_transgene_2 }}</p>
                @if($study->gm_random_genome_other_function_of_transgene_2)
                    <p><strong>Other Function of Transgene:</strong> {{ $study->gm_random_genome_other_function_of_transgene_2 }}</p>
                @endif
            </div>
            <div class="col-md-6">
                <p><strong>Coding Sequence Type:</strong> {{ $study->gm_random_genome_coding_sequence_type_2 }}</p>
                @if($study->gm_random_genome_other_coding_sequence_type_2)
                    <p><strong>Other Coding Sequence Type:</strong> {{ $study->gm_random_genome_other_coding_sequence_type_2 }}</p>
                @endif
                <p><strong>Animal Strain:</strong> {{ $study->gm_random_genome_animal_strain_2 }}</p>
                @if($study->gm_random_genome_other_animal_strain_2)
                    <p><strong>Other Animal Strain:</strong> {{ $study->gm_random_genome_other_animal_strain_2 }}</p>
                @endif
                <p><strong>Animal Model Obtained From:</strong> {{ $study->gm_random_genome_animal_model_obtained_from_2 }}</p>
                <p><strong>Drug Inducible Mechanism:</strong> {{ $study->gm_random_genome_utilizes_drug_inducible_mechanism_2 ? 'Yes' : 'No' }}</p>
            </div>
        </div>
    @endif
</div>