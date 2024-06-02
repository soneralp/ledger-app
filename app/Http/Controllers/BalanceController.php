<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BalanceController extends Controller
{
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
