<?php

namespace App\Traits;

use App\Models\Wallet;
use Illuminate\Support\Facades\DB;

trait HasWallet
{
    /**
     * Get the model's wallet.
     */
    public function wallet()
    {
        return $this->morphOne(Wallet::class, 'walletable');
    }

    /**
     * Get the balance of the wallet.
     */
    public function getBalanceAttribute()
    {
        return $this->wallet ? $this->wallet->balance : 0;
    }

    /**
     * Deposit amount to wallet.
     */
    public function deposit($amount, $description = null, $reference = null)
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException('Deposit amount must be positive');
        }

        return DB::transaction(function () use ($amount, $description, $reference) {
            $wallet = $this->wallet()->firstOrCreate([], ['balance' => 0]);

            $wallet->balance += $amount;
            $wallet->save();

            return $wallet->transactions()->create([
                'amount' => $amount,
                'type' => 'credit',
                'description' => $description,
                'reference_type' => $reference ? get_class($reference) : null,
                'reference_id' => $reference ? $reference->id : null,
            ]);
        });
    }

    /**
     * Withdraw amount from wallet.
     */
    public function withdraw($amount, $description = null, $reference = null)
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException('Withdrawal amount must be positive');
        }

        return DB::transaction(function () use ($amount, $description, $reference) {
            $wallet = $this->wallet()->firstOrCreate([], ['balance' => 0]);

            if ($wallet->balance < $amount) {
                throw new \Exception('Insufficient balance');
            }

            $wallet->balance -= $amount;
            $wallet->save();

            return $wallet->transactions()->create([
                'amount' => $amount,
                'type' => 'debit',
                'description' => $description,
                'reference_type' => $reference ? get_class($reference) : null,
                'reference_id' => $reference ? $reference->id : null,
            ]);
        });
    }
}
