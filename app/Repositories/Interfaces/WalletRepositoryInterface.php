<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface WalletRepositoryInterface
{
    public function findByOwner(Model $owner);
    public function updateBalance(Model $owner, $amount, $type, $description = null);
    
    // For backward compatibility
    public function findByUserId($userId);
}
