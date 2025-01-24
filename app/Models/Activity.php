<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Activity extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'activities';

    // Define the fillable fields to allow mass assignment
    protected $fillable = [
        'activity_name',
        'organization',
        'activity_description',
        'location',
        'status',
        'start_date',
        'end_date',
        'actual_beneficiaries',
        'expected_beneficiaries',
    ];

    // Automatically cast start_date and end_date to Carbon instances
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // Define relationships or additional methods if needed
    public function assignedOrg()
    {
        return $this->belongsTo(User::class, 'assigned_org_id');
    }
}
