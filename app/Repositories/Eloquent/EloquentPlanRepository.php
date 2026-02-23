<?php

namespace App\Repositories\Eloquent;

use App\Models\Plan;
use App\Repositories\Interfaces\PlanRepositoryInterface;

class EloquentPlanRepository implements PlanRepositoryInterface
{
    public function allActive(int $perPage = 10)
    {
        return Plan::where('is_active', true)->paginate($perPage);
    }

    public function findBySlug($slug)
    {
        return Plan::where('slug', $slug)->firstOrFail();
    }
}
