<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransactionController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// ------ Register route --------
Route::post('/register', [AuthController::class, 'register']);


Route::group(['prefix' => 'accounts'], function () {
    Route::post('/get-user-accounts', [AccountController::class, 'getUserAccounts']);
    Route::post('/create-account', [AccountController::class, 'createAccount']);
    Route::post('/balance-at-date', [AccountController::class, 'getBalanceAtDate']);
});

Route::post('/add-balance', [TransactionController::class, 'addBalance']);
Route::post('/withdraw', [TransactionController::class, 'withdrawCredit']);
Route::post('/send-credit', [TransactionController::class, 'sendCredit']);