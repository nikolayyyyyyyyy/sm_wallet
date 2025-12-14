<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\AccountTypeController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionTypeController;
use App\Models\User;
Route::middleware('auth:sanctum')->group(function () {

    //Auth routes
    Route::get('/user', function (Request $request) {
        $user = $request->user();

        return User::where('id', $user->id)
            ->with(['cards', 'cards.currency', 'cards.card_type'])
            ->first();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    // User routes
    Route::get('/clients/{id}', [UserController::class, 'getUser']);
    Route::delete('/clients/{id}/delete', [UserController::class, 'destroy']);
    Route::post('/clients/{id}/update', [UserController::class, 'updateUser']);
    Route::get('/clients', [UserController::class, 'index']);
    Route::post('/clients', [UserController::class, 'storeUser']);
    Route::post('/clients/check-email', [UserController::class, 'checkEmail']);

    // Currency routes
    Route::delete('/currencies/{id}/delete', [CurrencyController::class, 'deleteCurrency']);
    Route::get('/currencies', [CurrencyController::class, 'getCurrencies']);
    Route::post('/currencies', [CurrencyController::class, 'storeCurrency']);

    // Account Type routes
    Route::delete('/account-types/{id}/delete', [AccountTypeController::class, 'deleteAccountType']);
    Route::get('/account-types', [AccountTypeController::class, 'getAccountTypes']);
    Route::post('/account-types', [AccountTypeController::class, 'storeAccountType']);

    // Transaction Type routes
    Route::delete('/transaction-types/{id}/delete', [TransactionTypeController::class, 'deleteTransactionType']);
    Route::get('/transaction-types', [TransactionTypeController::class, 'getTransactionTypes']);
    Route::post('/transaction-types', [TransactionTypeController::class, 'storeTransactionType']);

    // Account routes
    Route::delete('/accounts/{id}/delete', [AccountController::class, 'deleteAccount']);
    Route::get('/accounts', [AccountController::class, 'getAllAccounts']);
    Route::post('/accounts', [AccountController::class, 'storeAccount']);

    // Transaction routes
    Route::delete('/transactions/{id}/delete', [TransactionController::class, 'deleteTransaction']);
    Route::get('transactions', [TransactionController::class, 'getAllTransactions']);
    Route::post('/transactions', [TransactionController::class, 'storeTransaction']);

    Route::post('/favorites-all', [FavoriteController::class, 'getFavoriteUsers']);
    Route::post('/favorites', [FavoriteController::class, 'store_favorite']);
});

//Public route
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

