<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Connect extends Model
{
    //
    protected $fillable = [
        'user_id',
        'email',
        'phone',
        'instagram',
        'facebook',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
