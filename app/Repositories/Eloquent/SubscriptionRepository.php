<?php

namespace App\Repositories\Eloquent;

use App\Models\Subscription;
use App\Models\User;
use App\Models\Plan;
use App\Repositories\Interfaces\SubscriptionRepositoryInterface;

class SubscriptionRepository implements SubscriptionRepositoryInterface
{
    public function create(User $user, Plan $plan): Subscription
    {
        return Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'starts_at' => now(),
            'expires_at' => now()->addMonths($plan->duration_months),
            'status' => 'active'
        ]);
    }
}
