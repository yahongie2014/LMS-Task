<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use App\Models\Plan;
use App\Models\Subscription;

interface SubscriptionRepositoryInterface
{
    public function create(User $user, Plan $plan): Subscription;
}
