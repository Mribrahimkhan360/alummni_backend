<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Education extends Model
{
    protected $fillable = [
        'user_id',
        'degree',
        'institution',
        'start_year',
        'end_year',
    ];

    protected $casts = [
        'start_year' => 'integer',
        'end_year'   => 'integer',
    ];

    /**
     * Get the user that owns the education.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}