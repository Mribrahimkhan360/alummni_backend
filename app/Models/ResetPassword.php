<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResetPassword extends Model
{
    use HasFactory;
    public $table = 'reset_passwords';
    public $timestamps = false;

    protected $fillable = [
        'email',
        'token',
        'created_at',
    ];

}
