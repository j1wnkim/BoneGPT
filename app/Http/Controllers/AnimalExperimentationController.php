<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Study;

class AnimalExperimentationController extends Controller
{
    public function show($study)
	{
		return view('study.animal-experimentation', compact('study'));
	}

	public function store(Request $request, Study $study)
	{
		$study->update([
			'study_is_genetically_modified' => $request->has('study_is_genetically_modified'),
			'study_performs_drug_treatment' => $request->has('study_performs_drug_treatment'),
			'study_performs_mechanical_procedure' => $request->has('study_performs_mechanical_procedure'),
			'study_performs_gonadectomy' => $request->has('study_performs_gonadectomy'),
			'study_performs_diet_modification' => $request->has('study_performs_diet_modification'),
			'study_controls_light_dark_cycle' => $request->has('study_controls_light_dark_cycle'),
			'study_compares_mouse_strains' => $request->has('study_compares_mouse_strains'),
			// Genetic modification types
			'gm_global_knockout' => $request->has('gm_global_knockout'),
			'gm_induced_mutation' => $request->has('gm_induced_mutation'),
			'gm_insertional_mutagenesis' => $request->has('gm_insertional_mutagenesis'),
			'gm_conditional_knockout' => $request->has('gm_conditional_knockout'),
			'gm_conditional_knockin_safe_harbor' => $request->has('gm_conditional_knockin_safe_harbor'),
			'gm_transgene' => $request->has('gm_transgene'),

			// Global Knockout Mouse Line 1
			'gm_gko_has_second_animal_line' => $request->has('gm_gko_has_second_animal_line'),
			'gm_gko_animal_model_name' => $request->input('gm_gko_animal_model_name'),
			'gm_gko_investigator_name' => $request->input('gm_gko_investigator_name'),
			'gm_gko_gene_name' => $request->input('gm_gko_gene_name'),
			'gm_gko_gene_symbol' => $request->input('gm_gko_gene_symbol'),
			'gm_gko_modification_type' => $request->input('gm_gko_modification_type'),
			'gm_gko_allele_schema' => $request->input('gm_gko_allele_schema'),
			'gm_gko_allele_abbreviation' => $request->input('gm_gko_allele_abbreviation'),
			'gm_gko_gene_type' => $request->input('gm_gko_gene_type'),
			'gm_gko_other_gene_type' => $request->input('gm_gko_other_gene_type'),
			'gm_gko_functional_change' => $request->input('gm_gko_functional_change'),
			'gm_gko_animal_strain' => $request->input('gm_gko_animal_strain'),
			'gm_gko_other_animal_strain' => $request->input('gm_gko_other_animal_strain'),

			// Global Knockout Mouse Line 2
			'gm_gko_animal_model_name_2' => $request->input('gm_gko_animal_model_name_2'),
			'gm_gko_investigator_name_2' => $request->input('gm_gko_investigator_name_2'),
			'gm_gko_gene_name_2' => $request->input('gm_gko_gene_name_2'),
			'gm_gko_gene_symbol_2' => $request->input('gm_gko_gene_symbol_2'),
			'gm_gko_modification_type_2' => $request->input('gm_gko_modification_type_2'),
			'gm_gko_allele_schema_2' => $request->input('gm_gko_allele_schema_2'),
			'gm_gko_allele_abbreviation_2' => $request->input('gm_gko_allele_abbreviation_2'),
			'gm_gko_gene_type_2' => $request->input('gm_gko_gene_type_2'),
			'gm_gko_other_gene_type_2' => $request->input('gm_gko_other_gene_type_2'),
			'gm_gko_functional_change_2' => $request->input('gm_gko_functional_change_2'),
			'gm_gko_animal_strain_2' => $request->input('gm_gko_animal_strain_2'),
			'gm_gko_other_animal_strain_2' => $request->input('gm_gko_other_animal_strain_2'),

			// Induced Mutation Fields
			'gm_ind_mutation_animal_model_name' => $request->input('gm_ind_mutation_animal_model_name'),
			'gm_ind_mutation_gene_name' => $request->input('gm_ind_mutation_gene_name'),
			'gm_ind_mutation_gene_symbol' => $request->input('gm_ind_mutation_gene_symbol'),
			'gm_ind_mutation_gene_type' => $request->input('gm_ind_mutation_gene_type'),
			'gm_ind_mutation_other_gene_type' => $request->input('gm_ind_mutation_other_gene_type'),
			'gm_ind_mutation_functional_change' => $request->input('gm_ind_mutation_functional_change'),
			'gm_ind_mutation_animal_strain' => $request->input('gm_ind_mutation_animal_strain'),
			'gm_ind_mutation_other_animal_strain' => $request->input('gm_ind_mutation_other_animal_strain'),
			'gm_ind_mutation_investigator_name' => $request->input('gm_ind_mutation_investigator_name'),
			'gm_ind_mutation_modification_type' => $request->input('gm_ind_mutation_modification_type'),
			'gm_ind_mutation_allele_schema' => $request->input('gm_ind_mutation_allele_schema'),
			'gm_ind_mutation_allele_abbreviation' => $request->input('gm_ind_mutation_allele_abbreviation'),
			'gm_ind_mutation_freeform_nomenclature' => $request->input('gm_ind_mutation_freeform_nomenclature'),

			// Insertional Mutagenesis Fields
			'gm_ins_mutagenesis_animal_model_name' => $request->input('gm_ins_mutagenesis_animal_model_name'),
			'gm_ins_mutagenesis_gene_name' => $request->input('gm_ins_mutagenesis_gene_name'),
			'gm_ins_mutagenesis_gene_symbol' => $request->input('gm_ins_mutagenesis_gene_symbol'),
			'gm_ins_mutagenesis_gene_type' => $request->input('gm_ins_mutagenesis_gene_type'),
			'gm_ins_mutagenesis_other_gene_type' => $request->input('gm_ins_mutagenesis_other_gene_type'),
			'gm_ins_mutagenesis_functional_change' => $request->input('gm_ins_mutagenesis_functional_change'),
			'gm_ins_mutagenesis_animal_strain' => $request->input('gm_ins_mutagenesis_animal_strain'),
			'gm_ins_mutagenesis_other_animal_strain' => $request->input('gm_ins_mutagenesis_other_animal_strain'),
			'gm_ins_mutagenesis_investigator_name' => $request->input('gm_ins_mutagenesis_investigator_name'),
			'gm_ins_mutagenesis_modification_type' => $request->input('gm_ins_mutagenesis_modification_type'),
			'gm_ins_mutagenesis_allele_schema' => $request->input('gm_ins_mutagenesis_allele_schema'),
			'gm_ins_mutagenesis_allele_abbreviation' => $request->input('gm_ins_mutagenesis_allele_abbreviation'),
			'gm_ins_mutagenesis_freeform_nomenclature' => $request->input('gm_ins_mutagenesis_freeform_nomenclature'),

			// Conditional Knockout Fields
			'gm_cond_knockout_animal_model_name' => $request->input('gm_cond_knockout_animal_model_name'),
			'gm_cond_knockout_gene_name' => $request->input('gm_cond_knockout_gene_name'),
			'gm_cond_knockout_gene_symbol' => $request->input('gm_cond_knockout_gene_symbol'),
			'gm_cond_knockout_gene_type' => $request->input('gm_cond_knockout_gene_type'),
			'gm_cond_knockout_other_gene_type' => $request->input('gm_cond_knockout_other_gene_type'),
			'gm_cond_knockout_functional_change' => $request->input('gm_cond_knockout_functional_change'),
			'gm_cond_knockout_animal_strain' => $request->input('gm_cond_knockout_animal_strain'),
			'gm_cond_knockout_other_animal_strain' => $request->input('gm_cond_knockout_other_animal_strain'),
			'gm_cond_knockout_cre_system_used' => $request->input('gm_cond_knockout_cre_system_used'),
			'gm_cond_knockout_investigator_name' => $request->input('gm_cond_knockout_investigator_name'),
			'gm_cond_knockout_modification_type' => $request->input('gm_cond_knockout_modification_type'),
			'gm_cond_knockout_allele_schema' => $request->input('gm_cond_knockout_allele_schema'),
			'gm_cond_knockout_allele_abbreviation' => $request->input('gm_cond_knockout_allele_abbreviation'),

			// Cre - Transgene Fields
			'gm_cond_knockout_transgene_cre_animal_line_name' => $request->input('gm_cond_knockout_transgene_cre_animal_line_name'),
			'gm_cond_knockout_transgene_cre_animal_line_abbreviation' => $request->input('gm_cond_knockout_transgene_cre_animal_line_abbreviation'),
			'gm_cond_knockout_transgene_gene_name' => $request->input('gm_cond_knockout_transgene_gene_name'),
			'gm_cond_knockout_transgene_tissue_lineage_specificity' => $request->input('gm_cond_knockout_transgene_tissue_lineage_specificity'),
			'gm_cond_knockout_transgene_animal_strain' => $request->input('gm_cond_knockout_transgene_animal_strain'),
			'gm_cond_knockout_transgene_other_animal_strain' => $request->input('gm_cond_knockout_transgene_other_animal_strain'),
			'gm_cond_knockout_transgene_investigator_name' => $request->input('gm_cond_knockout_transgene_investigator_name'),
			'gm_cond_knockout_transgene_allele_schema' => $request->input('gm_cond_knockout_transgene_allele_schema'),
			'gm_cond_knockout_transgene_other_allele_schema' => $request->input('gm_cond_knockout_transgene_other_allele_schema'),

			// Tamoxifen Inducible Fields
			'gm_cond_knockout_tamoxifen_cre_animal_line_name' => $request->input('gm_cond_knockout_tamoxifen_cre_animal_line_name'),
			'gm_cond_knockout_tamoxifen_cre_animal_line_abbreviation' => $request->input('gm_cond_knockout_tamoxifen_cre_animal_line_abbreviation'),
			'gm_cond_knockout_tamoxifen_gene_name' => $request->input('gm_cond_knockout_tamoxifen_gene_name'),
			'gm_cond_knockout_tamoxifen_tissue_lineage_specificity' => $request->input('gm_cond_knockout_tamoxifen_tissue_lineage_specificity'),
			'gm_cond_knockout_tamoxifen_animal_strain' => $request->input('gm_cond_knockout_tamoxifen_animal_strain'),
			'gm_cond_knockout_tamoxifen_other_animal_strain' => $request->input('gm_cond_knockout_tamoxifen_other_animal_strain'),
			'gm_cond_knockout_tamoxifen_tamoxifen_type' => $request->input('gm_cond_knockout_tamoxifen_tamoxifen_type'),
			'gm_cond_knockout_tamoxifen_investigator_name' => $request->input('gm_cond_knockout_tamoxifen_investigator_name'),
			'gm_cond_knockout_tamoxifen_allele_schema' => $request->input('gm_cond_knockout_tamoxifen_allele_schema'),
			'gm_cond_knockout_tamoxifen_other_allele_schema' => $request->input('gm_cond_knockout_tamoxifen_other_allele_schema'),

			// Doxycycline Regulated Fields
			'gm_cond_knockout_doxy_cre_animal_line_name' => $request->input('gm_cond_knockout_doxy_cre_animal_line_name'),
			'gm_cond_knockout_doxy_cre_animal_line_abbreviation' => $request->input('gm_cond_knockout_doxy_cre_animal_line_abbreviation'),
			'gm_cond_knockout_doxy_gene_name' => $request->input('gm_cond_knockout_doxy_gene_name'),
			'gm_cond_knockout_doxy_tissue_lineage_specificity' => $request->input('gm_cond_knockout_doxy_tissue_lineage_specificity'),
			'gm_cond_knockout_doxy_animal_strain' => $request->input('gm_cond_knockout_doxy_animal_strain'),
			'gm_cond_knockout_doxy_other_animal_strain' => $request->input('gm_cond_knockout_doxy_other_animal_strain'),
			'gm_cond_knockout_doxy_doxycycline_type' => $request->input('gm_cond_knockout_doxy_doxycycline_type'),
			'gm_cond_knockout_doxy_investigator_name' => $request->input('gm_cond_knockout_doxy_investigator_name'),
			'gm_cond_knockout_doxy_allele_schema' => $request->input('gm_cond_knockout_doxy_allele_schema'),
			'gm_cond_knockout_doxy_other_allele_schema' => $request->input('gm_cond_knockout_doxy_other_allele_schema'),

			// Random Genome Integration Fields
			'gm_random_genome_animal_model_name' => $request->input('gm_random_genome_animal_model_name'),
			'gm_random_genome_animal_name_abbreviation' => $request->input('gm_random_genome_animal_name_abbreviation'),
			'gm_random_genome_gene_name' => $request->input('gm_random_genome_gene_name'),
			'gm_random_genome_tissue_lineage_specificity' => $request->input('gm_random_genome_tissue_lineage_specificity'),
			'gm_random_genome_gene_product_expressed_by_transgene' => $request->input('gm_random_genome_gene_product_expressed_by_transgene'),
			'gm_random_genome_function_of_transgene' => $request->input('gm_random_genome_function_of_transgene'),
			'gm_random_genome_other_function_of_transgene' => $request->input('gm_random_genome_other_function_of_transgene'),
			'gm_random_genome_coding_sequence_type' => $request->input('gm_random_genome_coding_sequence_type'),
			'gm_random_genome_other_coding_sequence_type' => $request->input('gm_random_genome_other_coding_sequence_type'),
			'gm_random_genome_animal_strain' => $request->input('gm_random_genome_animal_strain'),
			'gm_random_genome_other_animal_strain' => $request->input('gm_random_genome_other_animal_strain'),
			'gm_random_genome_utilizes_drug_inducible_mechanism' => $request->input('gm_random_genome_utilizes_drug_inducible_mechanism') === 'true',
			'gm_random_genome_second_animal_line' => $request->input('gm_random_genome_second_animal_line') === 'true',

			'gm_random_genome_animal_model_name_2' => $request->input('gm_random_genome_animal_model_name_2'),
			'gm_random_genome_animal_name_abbreviation_2' => $request->input('gm_random_genome_animal_name_abbreviation_2'),
			'gm_random_genome_gene_name_2' => $request->input('gm_random_genome_gene_name_2'),
			'gm_random_genome_tissue_lineage_specificity_2' => $request->input('gm_random_genome_tissue_lineage_specificity_2'),
			'gm_random_genome_gene_product_expressed_by_transgene_2' => $request->input('gm_random_genome_gene_product_expressed_by_transgene_2'),
			'gm_random_genome_function_of_transgene_2' => $request->input('gm_random_genome_function_of_transgene_2'),
			'gm_random_genome_other_function_of_transgene_2' => $request->input('gm_random_genome_other_function_of_transgene_2'),
			'gm_random_genome_coding_sequence_type_2' => $request->input('gm_random_genome_coding_sequence_type_2'),
			'gm_random_genome_other_coding_sequence_type_2' => $request->input('gm_random_genome_other_coding_sequence_type_2'),
			'gm_random_genome_animal_strain_2' => $request->input('gm_random_genome_animal_strain_2'),
			'gm_random_genome_other_animal_strain_2' => $request->input('gm_random_genome_other_animal_strain_2'),
			'gm_random_genome_utilizes_drug_inducible_mechanism_2' => $request->input('gm_random_genome_utilizes_drug_inducible_mechanism_2') === 'true',

			// Knockin Safe Harbor Fields
			'gm_cond_knockin_safe_harbor_cre_system_used' => $request->input('gm_cond_knockin_safe_harbor_cre_system_used'),
			'gm_cond_knockin_safe_harbor_investigator_name' => $request->input('gm_cond_knockin_safe_harbor_investigator_name'),
			'gm_cond_knockin_safe_harbor_modification_type' => $request->input('gm_cond_knockin_safe_harbor_modification_type'),
			'gm_cond_knockin_safe_harbor_allele_schema' => $request->input('gm_cond_knockin_safe_harbor_allele_schema'),
			'gm_cond_knockin_safe_harbor_allele_abbreviation' => $request->input('gm_cond_knockin_safe_harbor_allele_abbreviation'),

			// Knockin Safe Harbor Cre Fields
			'gm_cond_knockin_transgene_allele_schema' => $request->input('gm_cond_knockin_transgene_allele_schema'),
			'gm_cond_knockin_transgene_other_allele_schema' => $request->input('gm_cond_knockin_transgene_other_allele_schema'),
			'gm_cond_knockin_transgene_cre_animal_line_name' => $request->input('gm_cond_knockin_transgene_cre_animal_line_name'),
			'gm_cond_knockin_transgene_cre_animal_line_abbreviation' => $request->input('gm_cond_knockin_transgene_cre_animal_line_abbreviation'),
			'gm_cond_knockin_transgene_investigator_name' => $request->input('gm_cond_knockin_transgene_investigator_name'),
			'gm_cond_knockin_transgene_gene_name' => $request->input('gm_cond_knockin_transgene_gene_name'),
			'gm_cond_knockin_transgene_tissue_lineage_specificity' => $request->input('gm_cond_knockin_transgene_tissue_lineage_specificity'),
			'gm_cond_knockin_transgene_animal_strain' => $request->input('gm_cond_knockin_transgene_animal_strain'),

			// Knockin Safe Harbor Cre Doxy Fields
			'gm_cond_knockin_doxy_allele_schema' => $request->input('gm_cond_knockin_doxy_allele_schema'),
			'gm_cond_knockin_doxy_other_allele_schema' => $request->input('gm_cond_knockin_doxy_other_allele_schema'),
			'gm_cond_knockin_doxy_cre_animal_line_name' => $request->input('gm_cond_knockin_doxy_cre_animal_line_name'),
			'gm_cond_knockin_doxy_cre_animal_line_abbreviation' => $request->input('gm_cond_knockin_doxy_cre_animal_line_abbreviation'),
			'gm_cond_knockin_doxy_investigator_name' => $request->input('gm_cond_knockin_doxy_investigator_name'),
			'gm_cond_knockin_doxy_gene_name' => $request->input('gm_cond_knockin_doxy_gene_name'),
			'gm_cond_knockin_doxy_tissue_lineage_specificity' => $request->input('gm_cond_knockin_doxy_tissue_lineage_specificity'),
			'gm_cond_knockin_doxy_animal_strain' => $request->input('gm_cond_knockin_doxy_animal_strain'),
			'gm_cond_knockin_doxy_doxycycline_type' => $request->input('gm_cond_knockin_doxy_doxycycline_type'),

			// Knockin Safe Harbor Cre Tamoxifen Fields
			'gm_cond_knockin_tamoxifen_allele_schema' => $request->input('gm_cond_knockin_tamoxifen_allele_schema'),
			'gm_cond_knockin_tamoxifen_other_allele_schema' => $request->input('gm_cond_knockin_tamoxifen_other_allele_schema'),
			'gm_cond_knockin_tamoxifen_cre_animal_line_name' => $request->input('gm_cond_knockin_tamoxifen_cre_animal_line_name'),
			'gm_cond_knockin_tamoxifen_cre_animal_line_abbreviation' => $request->input('gm_cond_knockin_tamoxifen_cre_animal_line_abbreviation'),
			'gm_cond_knockin_tamoxifen_investigator_name' => $request->input('gm_cond_knockin_tamoxifen_investigator_name'),
			'gm_cond_knockin_tamoxifen_gene_name' => $request->input('gm_cond_knockin_tamoxifen_gene_name'),
			'gm_cond_knockin_tamoxifen_tissue_lineage_specificity' => $request->input('gm_cond_knockin_tamoxifen_tissue_lineage_specificity'),
			'gm_cond_knockin_tamoxifen_animal_strain' => $request->input('gm_cond_knockin_tamoxifen_animal_strain'),
			'gm_cond_knockin_tamoxifen_tamoxifen_type' => $request->input('gm_cond_knockin_tamoxifen_tamoxifen_type'),
		]);

		$study->save();

		return redirect()->route('study.animal-experimentation', $study)->with('success', 'Animal experimentation information updated successfully.');
	}
}
