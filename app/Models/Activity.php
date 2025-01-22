<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'activities';

    // Define the fillable fields to allow mass assignment
    protected $fillable = [
        'activity_name',
        'activity_description',
        'location',
        'start_date',
        'end_date',
        'actual_beneficiaries',
        'expected_beneficiaries',
    ];

    // Optionally, define the date format if needed (for dates like start_date and end_date)
    protected $dates = ['start_date', 'end_date'];

    // Optionally, you can add relationships or additional methods here as needed
}
