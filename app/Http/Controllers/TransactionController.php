<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Services\BalanceService;
use App\Services\TransactionService;
use App\Http\Requests\AddBalanceRequest;

class TransactionController extends Controller
{
    protected $balanceService;
    protected $transactionService;


    public function __construct(
    BalanceService $balanceService, 
    TransactionService $transactionService)
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
            $request->transaction_type = "Add Balance", 
            $request->amount, 
            $request->description,
            $request->is_income = true,
        );
 
        return response()->json([
            'message' => 'Balance added successfully',
            'account' => $account,
            'transaction' => $transaction
        ], 200);
    }

    public function sendCredit(TransactionRequest $request)
    {
        try {
            $this->transactionService->transfer(
                $request->from_account_id,
                $request->to_account_id,
                $request->amount,
                $request->description,
                $request->transaction_type
            );

            return response()->json(['message' => 'Transfer successful'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function withdrawCredit(AddBalanceRequest $request)
    {
        try {
            $transaction = $this->balanceService->withdraw(
                $request->account_id,
                $request->amount,
            );
            
            $transaction = $this->transactionService->createTransaction(
                $request->account_id, 
                $request->transaction_type = "Withdraw", 
                $request->amount, 
                $request->description,
                $request->is_income = false,
            );

            return response()->json([
                'message' => 'Withdrawal successful',
                'transaction' => $transaction
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
