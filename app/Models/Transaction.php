<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'wallet_id',
        'amount',
        'type',
        'description',
        'reference_type',
        'reference_id',
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
