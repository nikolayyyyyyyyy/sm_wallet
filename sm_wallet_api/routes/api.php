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
    Route::get('/clients', [UserController::class, 'index']);
    Route::post('/clients', [UserController::class, 'storeUser']);

    // Currency routes
    Route::delete('/currencies/{id}/delete', [CurrencyController::class, 'deleteCurrency']);
    Route::get('/currencies', [CurrencyController::class, 'getCurrencies']);
    Route::post('/currencies', [CurrencyController::class, 'storeCurrency']);

    // Account Type routes
    Route::get('/account-types', [AccountTypeController::class, 'getAccountTypes']);
    Route::post('/account-types', [AccountTypeController::class, 'storeAccountType']);

    // Transaction Type routes
    Route::get('/transaction-types', [TransactionTypeController::class, 'getTransactionTypes']);
    Route::post('/transaction-types', [TransactionTypeController::class, 'storeTransactionType']);

    // Account routes
    Route::post('/accounts', [AccountController::class, 'storeAccount']);

    // Transaction routes
    Route::post('/transactions', [TransactionController::class, 'storeTransaction']);
});

//Public route
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

