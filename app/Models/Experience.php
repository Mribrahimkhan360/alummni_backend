<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = [
        'user_id',
        'job_title',
        'company',
        'start_year',
        'end_year',
        'currently_working',
        'description',
    ];

    protected $casts = [
        'currently_working' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}