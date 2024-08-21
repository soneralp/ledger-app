<?php
// app/Services/BalanceService.php

namespace App\Services;

use App\Models\Accounts;
use Illuminate\Support\Facades\DB;

class BalanceService
{
    public function addBalance($accountId, $amount)
    {
        if (request()->user()->is_admin) {
            $account = Accounts::findOrFail($accountId);
        } else {
            $account = request()->user()->accounts()->where('id', $accountId)->first();
        }

        if ($account) {
            $account->balance += $amount;
            $account->save();
        }

        return $account;
    }

    public function withdraw($accountId, $amount)
    {
        if (request()->user()->is_admin) {
            $account = Accounts::findOrFail($accountId);
        } else {
            $account = request()->user()->accounts()->where('id', $accountId)->first();
        }

        if ($account->balance < $amount) {
            throw new \Exception('Insufficient balance.');
        }

        $account->balance -= $amount;
        $account->save();

        return $account;
    }
}
