<?php

namespace App\Repositories\Interfaces;

interface PlanRepositoryInterface
{
    public function allActive(int $perPage = 10);
    public function findBySlug($slug);
}
