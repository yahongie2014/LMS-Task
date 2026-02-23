<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\PlanRepositoryInterface;

class PlanController extends Controller
{
    private $planRepository;

    public function __construct(PlanRepositoryInterface $planRepository)
    {
        $this->planRepository = $planRepository;
    }

    public function index(\Illuminate\Http\Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $plans = $this->planRepository->allActive((int)$perPage);
        return $this->successResponse(\App\Http\Resources\PlanResource::collection($plans)->response()->getData(true));
    }
}
