<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BalanceService;
use App\Services\TransactionService;

class BalanceController extends Controller
{
    protected $balanceService;
    protected $transactionService;

    public function __construct(BalanceService $balanceService, TransactionService $transactionService)
    {
        $this->balanceService = $balanceService;
        $this->transactionService = $transactionService;
    }

    public function addBalance(AddBalanceRequest $request)
    {
        $account = $this->balanceService->addBalance(
            $request->account_id,
            $request->amount
        );

        if (!$account) {
            return response()->json([
                'message' => 'Account couldn\'t be found',
            ], 404);
        }

        $transaction = $this->transactionService->createTransaction(
            $request->account_id, 
            $request->transaction_type, 
            $request->amount, 
            $request->description
        );
 
        return response()->json([
            'message' => 'Balance added successfully',
            'account' => $account,
            'transaction' => $transaction
        ], 200);
    }
}
