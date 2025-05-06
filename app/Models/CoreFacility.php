<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoreFacility extends Model
{
    use HasFactory;

	protected $fillable = [
		'facility_name',
		'web_address',
		'institution',
		'contact_name',
		'contact_email',
		'analysis_types',
	];

	protected $casts = [
		'analysis_types' => 'array',
	];
}