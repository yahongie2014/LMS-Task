<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Student\StoreSubscriptionRequest;
use App\Models\Subscription;
use App\Repositories\Interfaces\PlanRepositoryInterface;
use App\Repositories\Interfaces\WalletRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    private $planRepository;
    private $walletRepository;
    private $subscriptionRepository;

    public function __construct(
        PlanRepositoryInterface $planRepository,
        WalletRepositoryInterface $walletRepository,
        \App\Repositories\Interfaces\SubscriptionRepositoryInterface $subscriptionRepository
    ) {
        $this->planRepository = $planRepository;
        $this->walletRepository = $walletRepository;
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function store(StoreSubscriptionRequest $request)
    {
        $plan = $this->planRepository->findBySlug($request->plan_slug);
        $user = $request->user();
        $wallet = $this->walletRepository->findByOwner($user);

        if ($wallet->balance < $plan->price) {
            return $this->errorResponse(__('messages.insufficient_balance'), 400);
        }

        DB::transaction(function () use ($user, $plan) {
            $this->walletRepository->updateBalance(
                $user,
                $plan->price,
                'debit',
                __('messages.subscribed_success') . ": {$plan->name}"
            );

            $this->subscriptionRepository->create($user, $plan);
        });

        return $this->successResponse(null, __('messages.subscribed_success'));
    }
}
