<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TFList extends Model
{
    use HasFactory;

    // Define the table name if it's different from the default 'tf_lists'
    protected $table = 'tf_list'; // Set to your actual table name if it differs

    // Define the primary key if it's not the default 'id'
    protected $primaryKey = 'ID'; // Set to 'ID' as per your table structure, if it's the unique identifier

    // Disable timestamps if your table does not have created_at and updated_at columns
    public $timestamps = false;

    // Define which attributes are mass assignable
    protected $fillable = [
        'gene', 
        'ID', 
        'DBD', 
        'Motif status (Feb 2018)', 
        'IUPAC Consensus'
    ];

    // If you need to customize any accessor or mutator, you can define methods like:
    // public function getGeneAttribute($value) { return strtoupper($value); }
}
