<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\WalletRepositoryInterface;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    private $walletRepository;

    public function __construct(WalletRepositoryInterface $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    public function index(Request $request)
    {
        $wallet = $this->walletRepository->findByOwner($request->user());
        $perPage = $request->query('per_page', 10);
        $transactions = $wallet->transactions()->latest()->paginate((int)$perPage);
        
        return $this->successResponse([
            'balance' => $wallet->balance,
            'transactions' => \App\Http\Resources\TransactionResource::collection($transactions)->response()->getData(true)
        ]);
    }

    public function deposit(\App\Http\Requests\Api\Student\DepositRequest $request)
    {
        $this->walletRepository->updateBalance(
            $request->user(),
            $request->amount,
            'credit',
            __('messages.deposit_success')
        );

        return $this->successResponse(null, __('messages.deposit_success'));
    }
}
