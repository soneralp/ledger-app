<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddBalanceRequest;
use App\Http\Requests\CreateAccountRequest;
use App\Models\Accounts;
use App\Models\User;

class AccountController extends Controller
{
    public function getUserAccounts(Request $request) {
        $accounts = Accounts::where('user_id', $request->get('user_id'))->get();

        return response()->json([
            'message' => 'User accounts listed successfully',
            'Users Accounts' => $accounts
        ], 200);
    }

    public function createAccount(CreateAccountRequest $request) {
        $account = new Accounts();
        $account->user_id = $request->user_id;
        $account->account_name = $request->account_name;
        $account->account_type = $request->account_type;
        $account->balance = 0;
        $account->save();

        return response()->json([
            'message' => 'Account created successfully',
            'account' => $account
        ], 201);
    }

    public function addBalance(AddBalanceRequest $request)
    {
        $account = Accounts::findOrFail($request->account_id);

        if ($account) {
            $account->balance += $request->amount;
            $account->save();
        } else {
            return response()->json([
                'message' => 'Account couldn\'t found',
            ], 404);
        }

        return response()->json([
            'message' => 'Balance added successfully',
            'account' => $account
        ], 200);
    }
}
