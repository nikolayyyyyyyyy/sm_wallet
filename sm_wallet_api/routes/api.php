<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\AccountTypeController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionTypeController;

Route::middleware('auth:sanctum')->group(function () {

    //Auth routes
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);

    // User routes
    Route::post('/clients', [UserController::class, 'storeUser']);

    // Currency routes
    Route::post('/currencies', [CurrencyController::class, 'storeCurrency']);

    // Account Type routes
    Route::post('/account-types', [AccountTypeController::class, 'storeAccountType']);

    // Transaction Type routes
    Route::post('/transaction-types', [TransactionTypeController::class, 'storeTransactionType']);

    // Account routes
    Route::post('/accounts', [AccountController::class, 'storeAccount']);

    // Transaction routes
    Route::post('/transactions', [TransactionController::class, 'storeTransaction']);
});

//Public route
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

