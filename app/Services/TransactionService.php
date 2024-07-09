<?php

namespace App\Services;

use App\Models\Accounts;
use App\Models\Transactions;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    protected $balanceService;

    public function __construct(BalanceService $balanceService)
    {
        $this->balanceService = $balanceService;
    }
    public function createTransaction($accountId, $transactionType, $amount, $description = null, $isIncome)
    {
        $transactions = new Transactions;
        $transactions->account_id = $accountId;
        $transactions->transaction_type = $transactionType;
        $transactions->amount = $amount;
        $transactions->transaction_date = now(); 
        $transactions->is_income = $isIncome;

        if (isset($description)) {
            $transactions->description = $description;
        }

        $transactions->save();
        
        return response()->json([
            'message' => 'Transaction created successfully',
            'account' => $transactions
        ], 201);    
    }

    public function transfer($fromAccountId, $toAccountId, $amount, $description = null, $transactionType)
    {
        DB::transaction(function () use ($fromAccountId, $toAccountId, $amount, $description, $transactionType) {
            $this->balanceService->withdraw(
                $fromAccountId,
                $amount
            );

            $this->balanceService->addBalance(
                $toAccountId,
                $amount
            );

             $this->createTransaction(
                $fromAccountId, 
                $transactionType, 
                $amount, 
                $description, 
                false);

             $this->createTransaction(
                $toAccountId, 
                $transactionType, 
                $amount, 
                $description, 
                true);
        });
    }
}
