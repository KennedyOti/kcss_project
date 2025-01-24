<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'date_of_report',
        'file_path',
        'user_id',
        'status',
    ];

    /**
     * Get the user who submitted the report.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
