<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\WalletRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class EloquentWalletRepository implements WalletRepositoryInterface
{
    /**
     * @param Model $owner
     */
    public function findByOwner(Model $owner)
    {
        return $owner->wallet()->firstOrCreate([], ['balance' => 0]);
    }

    /**
     * @param Model $owner
     */
    public function updateBalance(Model $owner, $amount, $type, $description = null)
    {
        if ($type === 'credit') {
            return $owner->deposit($amount, $description);
        }
        
        return $owner->withdraw($amount, $description);
    }

    // Keep compatibility for now or refactor interface
    public function findByUserId($userId)
    {
        $user = \App\Models\User::find($userId);
        return $this->findByOwner($user);
    }

    public function updateBalanceById($userId, $amount, $type, $description = null)
    {
        $user = \App\Models\User::find($userId);
        return $this->updateBalance($user, $amount, $type, $description);
    }
}
