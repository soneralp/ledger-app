<?php
// app/Services/BalanceService.php

namespace App\Services;

use App\Models\Accounts;
use Illuminate\Support\Facades\DB;

class BalanceService
{
    public function addBalance($accountId, $amount)
    {
        $account = Accounts::findOrFail($accountId);

        if ($account) {
            $account->balance += $amount;
            $account->save();
        }

        return $account;
    }

    public function withdraw($accountId, $amount)
    {
        $account = Accounts::findOrFail($accountId);

        if ($account->balance < $amount) {
            throw new \Exception('Insufficient balance.');
        }

        $account->balance -= $amount;
        $account->save();

        return $account;
    }
}
