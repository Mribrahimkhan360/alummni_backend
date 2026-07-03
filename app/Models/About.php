<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $fillable = [
        'title',
        'sub_title',
        'description',

        'title_secondary',
        'sub_title_secondary',
        'description_secondary',

        'image_secondary',

        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}