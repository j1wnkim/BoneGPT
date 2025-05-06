<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HumanLRPair extends Model
{
    use HasFactory;

    // Specify the table name if it's not the plural form of the model name
    protected $table = 'human_lr_pairs';

    // Set the 'lr_pair' as the primary key since there is no 'id' field in your table
    protected $primaryKey = 'lr_pair';  // Set 'lr_pair' as the primary key

    // Disable timestamps since your table doesn't have created_at or updated_at columns
    public $timestamps = false;

    // Specify the columns that can be mass-assigned
    protected $fillable = [
        'lr_pair', 
        'ligand_gene_symbol', 
        'receptor_gene_symbol', 
        'ligand_gene_id', 
        'receptor_gene_id',
        'ligand_ensembl_protein_id', 
        'receptor_ensembl_protein_id', 
        'ligand_ensembl_gene_id', 
        'receptor_ensembl_gene_id', 
        'evidence'
    ];

    // Optionally, you can define casts if you need to cast columns to specific types
    protected $casts = [
        'ligand_gene_id' => 'integer',
        'receptor_gene_id' => 'integer',
        'evidence' => 'string',
    ];
}
