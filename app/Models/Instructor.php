<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instructor extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, \App\Traits\HasWallet, \App\Traits\HasFiles, \App\Traits\HasOtp;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'bio',
        'specialty',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
