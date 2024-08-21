<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateAccountRequest;
use App\Models\Accounts;
use App\Models\User;
use App\Models\Transactions;

class AccountController extends Controller
{
    public function getUserAccounts(Request $request) {
        if (request()->user()->is_admin) {
            $account = Accounts::where('user_id', $request->user_id)->get();   
        } else {
            $account = Accounts::where('user_id', request()->user()->id)->get();
        }

        return response()->json([
            'message' => 'User accounts listed successfully',
            'Users Accounts' => $account
        ], 200);
    }

    public function createAccount(CreateAccountRequest $request) {
        $account = new Accounts();
        $account->user_id = request()->user()->id;
        $account->account_name = $request->account_name;
        $account->account_type = $request->account_type;
        $account->balance = 0;
        $account->save();

        return response()->json([
            'message' => 'Account created successfully',
            'account' => $account
        ], 201);
    }

    public function getBalanceAtDate(Request $request)
    {
        $validatedData = $request->validate([
            'account_id' => 'required|integer',
            'date' => 'required|date',
        ]);

        $userId = request()->user()->id;
        $accountId = $validatedData['account_id'];
        $date = $validatedData['date'];

        $account = Accounts::where('id', $accountId)
                          ->where('user_id', $userId)
                          ->first();
                          
        if (!$account) {
            return response()->json([
                'The user does not have such an account' 
            ], 404); 
        }

        $transactions = Transactions::where('account_id', $accountId)
                                   ->whereDate('transaction_date', '<=', $date)
                                   ->get();

        $balance = $account->balance;

        foreach ($transactions as $transaction) {
            if ($transaction->is_income) {
                $balance += $transaction->amount;
            } else {
                $balance -= $transaction->amount;
            }
        }

        return response()->json([
            'balance' => $balance,
            'date' => $date,
        ], 200);
    }
}
