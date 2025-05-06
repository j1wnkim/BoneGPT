<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\ExperimentalGroupService;

class Study extends Model
{
    use HasFactory;

	protected $fillable = [
		'identifier',
		'status',
		// Experimental Categories
        'study_is_genetically_modified',
        'study_performs_drug_treatment',
        'study_performs_mechanical_procedure',
        'study_performs_gonadectomy',
        'study_performs_diet_modification',
        'study_controls_light_dark_cycle',
        'study_compares_mouse_strains',

		// Mouse Information
        'light_dark_cycle',
        'room_temperature',
        'diet',
        'sex',

		// Genetically Modified Mouse Study Fields
        'gm_global_knockout',
		'gm_induced_mutation',
        'gm_insertional_mutagenesis',
        'gm_conditional_knockout',
        'gm_conditional_knockin_safe_harbor',
        'gm_transgene',

        // Global Targeted Knockout Fields
        'gm_gko_has_second_animal_line',
        'gm_gko_animal_model_name',
        'gm_gko_gene_name',
        'gm_gko_gene_symbol',
        'gm_gko_gene_type',
        'gm_gko_other_gene_type',
        'gm_gko_allele_nomenclature',
        'gm_gko_other_allele_nomenclature',
        'gm_gko_functional_change',
        'gm_gko_animal_strain',
        'gm_gko_other_animal_strain',
		'gm_gko_investigator_name',
        'gm_gko_modification_type',
        'gm_gko_allele_schema',
        'gm_gko_allele_abbreviation',

        'gm_gko_animal_model_name_2',
        'gm_gko_gene_name_2',
        'gm_gko_gene_symbol_2',
        'gm_gko_gene_type_2',
        'gm_gko_other_gene_type_2',
        'gm_gko_allele_nomenclature_2',
        'gm_gko_other_allele_nomenclature_2',
        'gm_gko_functional_change_2',
        'gm_gko_animal_strain_2',
        'gm_gko_other_animal_strain_2',
        'gm_gko_investigator_name_2',
        'gm_gko_modification_type_2',
        'gm_gko_allele_schema_2',
        'gm_gko_allele_abbreviation_2',

        // Induced Mutation Fields
        'gm_ind_mutation_animal_model_name',
        'gm_ind_mutation_gene_name',
        'gm_ind_mutation_gene_symbol',
        'gm_ind_mutation_gene_type',
        'gm_ind_mutation_other_gene_type',
        'gm_ind_mutation_functional_change',
        'gm_ind_mutation_animal_strain',
        'gm_ind_mutation_other_animal_strain',
		'gm_ind_mutation_investigator_name',
        'gm_ind_mutation_modification_type',
        'gm_ind_mutation_allele_schema',
        'gm_ind_mutation_allele_abbreviation',
        'gm_ind_mutation_freeform_nomenclature',

        // Insertional Mutagenesis Fields
        'gm_ins_mutagenesis_animal_model_name',
        'gm_ins_mutagenesis_gene_name',
        'gm_ins_mutagenesis_gene_symbol',
        'gm_ins_mutagenesis_gene_type',
        'gm_ins_mutagenesis_other_gene_type',
        'gm_ins_mutagenesis_functional_change',
        'gm_ins_mutagenesis_animal_strain',
        'gm_ins_mutagenesis_other_animal_strain',
		'gm_ins_mutagenesis_investigator_name',
        'gm_ins_mutagenesis_modification_type',
        'gm_ins_mutagenesis_allele_schema',
        'gm_ins_mutagenesis_allele_abbreviation',
        'gm_ins_mutagenesis_freeform_nomenclature',

        // Conditional Knockout Fields
        'gm_cond_knockout_animal_model_name',
        'gm_cond_knockout_gene_name',
        'gm_cond_knockout_gene_symbol',
        'gm_cond_knockout_gene_type',
        'gm_cond_knockout_other_gene_type',
        'gm_cond_knockout_functional_change',
        'gm_cond_knockout_animal_strain',
        'gm_cond_knockout_other_animal_strain',
        'gm_cond_knockout_cre_system_used',
		'gm_cond_knockout_investigator_name',
        'gm_cond_knockout_modification_type',
        'gm_cond_knockout_allele_schema',
        'gm_cond_knockout_allele_abbreviation',

        // Cre - Transgene Fields
        'gm_cond_knockout_transgene_cre_animal_line_name',
        'gm_cond_knockout_transgene_cre_animal_line_abbreviation',
        'gm_cond_knockout_transgene_gene_name',
        'gm_cond_knockout_transgene_tissue_lineage_specificity',
        'gm_cond_knockout_transgene_animal_strain',
        'gm_cond_knockout_transgene_other_animal_strain',
		'gm_cond_knockout_transgene_investigator_name',
        'gm_cond_knockout_transgene_allele_schema',
        'gm_cond_knockout_transgene_other_allele_schema',

        // Tamoxifen Inducible Fields
        'gm_cond_knockout_tamoxifen_cre_animal_line_name',
        'gm_cond_knockout_tamoxifen_cre_animal_line_abbreviation',
        'gm_cond_knockout_tamoxifen_gene_name',
        'gm_cond_knockout_tamoxifen_tissue_lineage_specificity',
        'gm_cond_knockout_tamoxifen_animal_strain',
        'gm_cond_knockout_tamoxifen_other_animal_strain',
        'gm_cond_knockout_tamoxifen_tamoxifen_type',
		'gm_cond_knockout_tamoxifen_investigator_name',
        'gm_cond_knockout_tamoxifen_allele_schema',
        'gm_cond_knockout_tamoxifen_other_allele_schema',

        // Doxycycline Regulated Fields
        'gm_cond_knockout_doxy_cre_animal_line_name',
        'gm_cond_knockout_doxy_cre_animal_line_abbreviation',
        'gm_cond_knockout_doxy_gene_name',
        'gm_cond_knockout_doxy_tissue_lineage_specificity',
        'gm_cond_knockout_doxy_animal_strain',
        'gm_cond_knockout_doxy_other_animal_strain',
        'gm_cond_knockout_doxy_doxycycline_type',
		'gm_cond_knockout_doxy_investigator_name',
        'gm_cond_knockout_doxy_allele_schema',
        'gm_cond_knockout_doxy_other_allele_schema',

		// Conditional Knockin Safe Harbor Fields
		'gm_cond_knockin_safe_harbor_cre_system_used',
        'gm_cond_knockin_safe_harbor_investigator_name',
        'gm_cond_knockin_safe_harbor_modification_type',
        'gm_cond_knockin_safe_harbor_allele_schema',
        'gm_cond_knockin_safe_harbor_allele_abbreviation',

        // Conditional Knockin Safe Harbor Cre Transgene Fields
        'gm_cond_knockin_transgene_allele_schema',
        'gm_cond_knockin_transgene_other_allele_schema',
        'gm_cond_knockin_transgene_cre_animal_line_name',
        'gm_cond_knockin_transgene_cre_animal_line_abbreviation',
        'gm_cond_knockin_transgene_investigator_name',
        'gm_cond_knockin_transgene_gene_name',
        'gm_cond_knockin_transgene_tissue_lineage_specificity',
        'gm_cond_knockin_transgene_animal_strain',

        // Conditional Knockin Safe Harbor Tamoxifen Inducible Fields
        'gm_cond_knockin_tamoxifen_allele_schema',
        'gm_cond_knockin_tamoxifen_other_allele_schema',
        'gm_cond_knockin_tamoxifen_cre_animal_line_name',
        'gm_cond_knockin_tamoxifen_cre_animal_line_abbreviation',
        'gm_cond_knockin_tamoxifen_investigator_name',
        'gm_cond_knockin_tamoxifen_gene_name',
        'gm_cond_knockin_tamoxifen_tissue_lineage_specificity',
        'gm_cond_knockin_tamoxifen_animal_strain',
        'gm_cond_knockin_tamoxifen_tamoxifen_type',

        // Conditional Knockin Safe Harbor Doxycycline Regulated Fields
        'gm_cond_knockin_doxy_allele_schema',
        'gm_cond_knockin_doxy_other_allele_schema',
        'gm_cond_knockin_doxy_cre_animal_line_name',
        'gm_cond_knockin_doxy_cre_animal_line_abbreviation',
        'gm_cond_knockin_doxy_investigator_name',
        'gm_cond_knockin_doxy_gene_name',
        'gm_cond_knockin_doxy_tissue_lineage_specificity',
        'gm_cond_knockin_doxy_animal_strain',
        'gm_cond_knockin_doxy_doxycycline_type',


        // Random Genome Integration Fields
        'gm_random_genome_animal_model_name',
        'gm_random_genome_animal_name_abbreviation',
        'gm_random_genome_gene_name',
        'gm_random_genome_tissue_lineage_specificity',
        'gm_random_genome_gene_product_expressed_by_transgene',
        'gm_random_genome_function_of_transgene',
        'gm_random_genome_other_function_of_transgene',
        'gm_random_genome_coding_sequence_type',
        'gm_random_genome_other_coding_sequence_type',
        'gm_random_genome_animal_strain',
        'gm_random_genome_other_animal_strain',
        'gm_random_genome_animal_model_obtained_from',
        'gm_random_genome_utilizes_drug_inducible_mechanism',
        'gm_random_genome_second_animal_line',

        'gm_random_genome_animal_model_name_2',
        'gm_random_genome_animal_name_abbreviation_2',
        'gm_random_genome_gene_name_2',
        'gm_random_genome_tissue_lineage_specificity_2',
        'gm_random_genome_gene_product_expressed_by_transgene_2',
        'gm_random_genome_function_of_transgene_2',
        'gm_random_genome_other_function_of_transgene_2',
        'gm_random_genome_coding_sequence_type_2',
        'gm_random_genome_other_coding_sequence_type_2',
        'gm_random_genome_animal_strain_2',
        'gm_random_genome_other_animal_strain_2',
        'gm_random_genome_animal_model_obtained_from_2',
        'gm_random_genome_utilizes_drug_inducible_mechanism_2',

        // Analysis methods
        'dexa',
        'micro_ct',
        'bone_histomorphometry',
        'mechanical_testing',
        'clinical_biochemistry',

        // DEXA fields
        'dexa_whole_body',
        'dexa_femur',
        'dexa_tibia',
        'dexa_vertebra',

        // Micro CT fields
        'micro_ct_femur_trabecular',
        'micro_ct_femur_cortical',
        'micro_ct_tibia_trabecular',
        'micro_ct_tibia_cortical',
        'micro_ct_vertebra_trabecular',

        // Bone histomorphometry fields
        'bone_histomorphometry_femur_trabecular',
        'bone_histomorphometry_femur_cortical',
        'bone_histomorphometry_tibia_trabecular',
        'bone_histomorphometry_tibia_cortical',
        'bone_histomorphometry_vertebra_trabecular',

        // Conditional Knock-In Safe Harbor Fields
        'gm_cond_knockin_safe_harbor_animal_model_name',
        'gm_cond_knockin_safe_harbor_abbreviated_name',
        'gm_cond_knockin_safe_harbor_gene_product',
        'gm_cond_knockin_safe_harbor_transgene_function',
        'gm_cond_knockin_safe_harbor_coding_sequence_type',
        'gm_cond_knockin_safe_harbor_animal_strain',
        'gm_cond_knockin_safe_harbor_source',

		// Study Information
        'title',
        'summary',
        'funding_sources',
        'conflicts',
        'completion_date',
        'is_published',
        'doi',
        'pubmed_id',
        'publication_plan',
        'embargo_months',

		// Subject Areas
		'subject_areas',
        'user_id'
    ];

    protected $casts = [
        'completion_date' => 'date',
        'is_published' => 'boolean',
        'embargo_months' => 'integer',
		'subject_areas' => 'array',
    ];

    protected static function boot()
    {
		// TODO: Check if this is the best way to generate the identifier
        parent::boot();

        static::creating(function ($study) {
            $study->identifier = static::generateIdentifier();
            $study->status = 'New';
        });

        // Add observer for when investigators are added
        static::retrieved(function ($study) {
            if ($study->status === 'New' && $study->investigators()->exists()) {
                $study->status = 'In Progress';
                $study->save();
            }
        });

        static::updating(function ($study) {
            // If the status is still 'new' and there are changes
            if ($study->status === 'New' && $study->isDirty()) {
                $study->status = 'In Progress';
            }
        });
    }

    protected static function generateIdentifier()
    {
        $datetime = now()->format('Ymd');  // Format: 20240311
        $random = strtoupper(substr(uniqid(), -4));  // 4 random characters
        return "ROSSA-{$datetime}-{$random}";
    }

	public function experimentalGroups()
	{
		return $this->hasMany(ExperimentalGroup::class);
	}

	public function uploads()
	{
		return $this->hasMany(Upload::class);
	}

	public function drugTreatments()
	{
		return $this->hasMany(DrugTreatment::class);
	}

	public function investigators()
	{
		return $this->hasMany(Investigator::class);
	}

    public function user()
    {
        return $this->belongsTo(User::class);
    }

	public static function getSubjectAreaCategories()
    {
        return [
            'List 1' => [
                'aging' => 'Aging',
                'autophagy' => 'Autophagy',
                'bone_development' => 'Bone Development',
                'bone_metabolism' => 'Bone Metabolism',
                'bone_remodeling' => 'Bone Remodeling',
                'circadian_rhythm' => 'Circadian Rhythm',
            ],
            'List 2' => [
                'adipose_tissue' => 'Adipose Tissue',
                'digestive_system' => 'Digestive System',
                'endocrine_system' => 'Endocrine System',
                'immune_system' => 'Immune System',
            ],
            'List 3' => [
                'bone_lining_cells' => 'Bone Lining Cells',
                'chondrocyte' => 'Chondrocyte',
                'osteoblast' => 'Osteoblast',
            ],
            'List 4' => [
                'osteopenia' => 'Osteopenia',
                'osteoporosis' => 'Osteoporosis',
                'osteopetrosis' => 'Osteopetrosis',
            ],
        ];
    }


    /**
     * Helpful to collect all unique strains in the animal experimentation fields.
     */
    public function strains() {
        $strains = collect();
        if ( !$this->study_is_genetically_modified ) {
            return $strains;
        }
        if ( $this->gm_global_knockout ) {
            if ( $this->gm_gko_animal_strain === 'other' ) {
                $strains->push($this->gm_gko_other_animal_strain);
            } else {
                $strains->push($this->gm_gko_animal_strain);
            }

            if ( $this->gm_gko_has_second_animal_line ) {
                if ( $this->gm_gko_animal_strain_2 === 'other' ) {
                    $strains->push($this->gm_gko_other_animal_strain_2);
                } else {
                    $strains->push($this->gm_gko_animal_strain_2);
                }
            }
        }

        // Handle Induced Mutation
        if ($this->gm_induced_mutation) {
            if ($this->gm_induced_mutation_animal_strain === 'other') {
                $strains->push($this->gm_induced_mutation_other_animal_strain);
            } else {
                $strains->push($this->gm_induced_mutation_animal_strain);
            }
        }

        // Handle Conditional Knockout
        if ($this->gm_conditional_knockout) {
            // Add conditional knockout animal strain
            $strainField = match($this->gm_cond_knockout_cre_system_used) {
                'transgene_regulated_non_inducible' => [
                    'strain' => $this->gm_cond_knockout_transgene_animal_strain,
                    'other_strain' => $this->gm_cond_knockout_transgene_other_animal_strain
                ],
                'tamoxifen_inducible' => [
                    'strain' => $this->gm_cond_knockout_tamoxifen_animal_strain,
                    'other_strain' => $this->gm_cond_knockout_tamoxifen_other_animal_strain
                ],
                'doxycycline_regulated' => [
                    'strain' => $this->gm_cond_knockout_doxy_animal_strain,
                    'other_strain' => $this->gm_cond_knockout_doxy_other_animal_strain
                ],
                default => null
            };

            if ($strainField) {
                if ($strainField['strain'] === 'other') {
                    $strains->push($strainField['other_strain']);
                } else {
                    $strains->push($strainField['strain']);
                }
            }
        }

        return $strains->filter()->unique();
    }


    public function geneSymbols() {
        $geneSymbols = collect();

        if ( !$this->study_is_genetically_modified ) {
            return $geneSymbols;
        }

        if ( $this->gm_global_knockout ) {
            $geneSymbols->push($this->gm_gko_gene_symbol);
            if ($this->gm_gko_has_second_animal_line) {
                $geneSymbols->push($this->gm_gko_gene_symbol_2);
            }
        }

        // Handle Induced Mutation
        if ($this->gm_induced_mutation) {
            $geneSymbols->push($this->gm_ind_mutation_gene_symbol);
        }

        // Handle Insertional Mutagenesis
        if ($this->gm_insertional_mutagenesis) {
            $geneSymbols->push($this->gm_ins_mutagenesis_gene_symbol);
        }

        // Handle Conditional Knockout
        if ($this->gm_conditional_knockout) {
            $geneSymbols->push($this->gm_cond_knockout_gene_symbol);
        }

        return $geneSymbols->filter()->unique();
    }


    public function genotypes() {
        $experimentalGroupService = app(ExperimentalGroupService::class);

        $genotypes = collect();

        if ( !$this->study_is_genetically_modified ) {
            return $genotypes;
        }

        if ( $this->gm_global_knockout ) {
            $genotypes = collect($experimentalGroupService->generateGenotypeOptions(
                $this->gm_gko_allele_schema,
                $this->gm_gko_allele_abbreviation
            ));

            if ($this->gm_gko_has_second_animal_line) {
                $genotypes = $genotypes->merge(
                    $experimentalGroupService->generateGenotypeOptions(
                        $this->gm_gko_allele_schema_2,
                        $this->gm_gko_allele_abbreviation_2
                    )
                );
            }
        }

        // Handle Induced Mutation
        if ($this->gm_induced_mutation) {
            $genotypes = $genotypes->merge(
                $experimentalGroupService->generateGenotypeOptions(
                    $this->gm_ind_mutation_allele_schema,
                    $this->gm_ind_mutation_allele_abbreviation
                )
            );
        }

        // Handle Insertional Mutagenesis
        if ($this->gm_insertional_mutagenesis) {
            $genotypes = $genotypes->merge(
                $experimentalGroupService->generateGenotypeOptions(
                    $this->gm_ins_mutagenesis_allele_schema,
                    $this->gm_ins_mutagenesis_allele_abbreviation
                )
            );
        }

        // Handle Conditional Knockout
        if ($this->gm_conditional_knockout) {
            $genotypes = $genotypes->merge(
                $experimentalGroupService->generateGenotypeOptions(
                    $this->gm_cond_knockout_allele_schema,
                    $this->gm_cond_knockout_allele_abbreviation
                )
            );
        }

        return $genotypes->filter()->unique();
    }


    /**
     * Retrive genotype options by a given prefix.
     */
    public function genotypesBy($property, $customAbbreviationProperty = null) {
        $experimentalGroupService = app(ExperimentalGroupService::class);
        return $experimentalGroupService->generateGenotypeOptions(
            $this->$property,
            $customAbbreviationProperty ? $this->$customAbbreviationProperty : null
        );
    }
}