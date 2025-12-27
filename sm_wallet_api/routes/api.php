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
use App\Http\Controllers\ChatController;

Route::middleware('auth:sanctum')->group(function () {

    //Auth routes
    Route::get('/user', function (Request $request) {
        $user = User::where('id', $request->user()->id)
            ->with(['cards', 'cards.currency', 'cards.card_type'])
            ->first(); 
        
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'middle_name' => $user->middle_name,
            'last_name' => $user->last_name,
            'role_id' => $user->role_id,
            'profile_photo' => $user->profile_photo ? asset($user->profile_photo) : null,
            'cards' => $user->cards
        ], 200);
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    // User routes
    Route::get('/clients/{id}', [UserController::class, 'getUser']);
    Route::delete('/clients/{id}/delete', [UserController::class, 'destroy']);
    Route::post('/clients/{id}/update', [UserController::class, 'updateUserProfile']);
    Route::get('/clients', [UserController::class, 'index']);
    Route::post('/clients', [UserController::class, 'storeUser']);
    Route::post('/clients/check-email', [UserController::class, 'checkEmail']);

    // Currency routes
    Route::get('/currencies/{id}', [CurrencyController::class, 'getCurrency']);
    Route::delete('/currencies/{id}/delete', [CurrencyController::class, 'deleteCurrency']);
    Route::get('/currencies', [CurrencyController::class, 'getCurrencies']);
    Route::post('/currencies', [CurrencyController::class, 'storeCurrency']);
    Route::post('/currencies/{id}/update', [CurrencyController::class, 'updateCurrency']);

    // Account Type routes
    Route::post('/account-types/{id}/update', [AccountTypeController::class, 'updateAccountType']);
    Route::get('/account-types/{id}', [AccountTypeController::class, 'getAccountType']);
    Route::delete('/account-types/{id}/delete', [AccountTypeController::class, 'deleteAccountType']);
    Route::get('/account-types', [AccountTypeController::class, 'getAccountTypes']);
    Route::post('/account-types', [AccountTypeController::class, 'storeAccountType']);

    // Transaction Type routes
    Route::post('/transaction-types/{id}/update', [TransactionTypeController::class, 'updateTransactionType']);
    Route::get('/transaction-types/{id}', [TransactionTypeController::class, 'getTransactionType']);
    Route::delete('/transaction-types/{id}/delete', [TransactionTypeController::class, 'deleteTransactionType']);
    Route::get('/transaction-types', [TransactionTypeController::class, 'getTransactionTypes']);
    Route::post('/transaction-types', [TransactionTypeController::class, 'storeTransactionType']);

    // Account routes
    Route::get('/accounts/{id}/loaded', [AccountController::class, 'getAccountLoaded']);
    Route::post('/accounts/{id}/update', [AccountController::class, 'updateAccount']);
    Route::get('/accounts/{id}', [AccountController::class, 'getAccount']);
    Route::delete('/accounts/{id}/delete', [AccountController::class, 'deleteAccount']);
    Route::get('/accounts', [AccountController::class, 'getAllAccounts']);
    Route::post('/accounts', [AccountController::class, 'storeAccount']);

    // Transaction routes
    Route::get('/transactions/${slug}', [TransactionController::class, 'getTransactionBySlug']);
    Route::post('/transactions/{id}/update', [TransactionController::class, 'updateTransaction']);
    Route::get('/transactions/{id}', [TransactionController::class, 'getTransaction']);
    Route::delete('/transactions/{id}/delete', [TransactionController::class, 'deleteTransaction']);
    Route::get('transactions', [TransactionController::class, 'getAllTransactions']);
    Route::post('/transactions', [TransactionController::class, 'storeTransaction']);

    // Favorite routes  
    Route::post('/favorites-all', [FavoriteController::class, 'getFavoriteUsers']);
    Route::post('/favorites', [FavoriteController::class, 'store_favorite']);

    // Message routes
    Route::get('/messages/{id}', [ChatController::class, 'getMessages']);
    Route::post('/messages/{id}', [ChatController::class, 'storeMessage']);
});

//Public route
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

