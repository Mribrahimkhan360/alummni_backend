<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,HasApiTokens;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'student_id',
        'passing_year',
        'department',
        'gender',
        'password',
        'image',
        'bio',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function jobProfile() {
        return $this->hasOne(JobProfile::class);
    }

    public function educations(): HasMany
    {
        return $this->hasMany(Education::class);
    }
    
    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    public function achievements(): HasMany
    {
        return $this->hasMany(Achivement::class);
    }

    public function connect(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Connect::class);
    }

}
