<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $fillable = [
        'user_id',
        'amount',
        'payment_date',
        'note',
        'receipt',
        'status'
    ];

    protected $casts = [
        'payment_date'  => 'date',
        'amount'        => 'decimal:2',
        'created_at'    => 'datetime',
        'updated_at'    =>  'datetime',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
