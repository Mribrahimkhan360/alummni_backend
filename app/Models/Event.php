<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    protected $fillable = [
        'title',
        'description',
        'venue',
        'entertainment',
        'image',
        'dietary_info',
        'ticket_prices',
        'is_active',
        'event_date',
        'event_time',
    ];

    protected $casts = [
        'ticket_prices' => 'string',
        'is_active' => 'boolean',
    ];
}
