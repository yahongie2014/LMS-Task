<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    protected $fillable = [
        'phone',
        'otp',
        'customable_id',
        'customable_type',
        'is_new',
        'expires_at',
        'verified_at',
    ];

    protected $casts = [
        'is_new' => 'boolean',
        'expires_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    public function customable()
    {
        return $this->morphTo();
    }
}
