<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function updateAccount(Request $request, string $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'account_number' => 'required|string|size:10|unique:accounts,id',
                'amount' => 'required|numeric',
                'interest' => 'required|numeric'
            ],
            [
                'account_number.required' => 'Полето за номер на акаунт е задължително.',
                'account_number.size' => 'Номерът на акаунта трябва да бъде точно 10 символа.',
                'account_number.unique' => 'Акаунт с този номер вече съществува.',
                'amount.required' => 'Полето за сума е задължително.',
                'amount.numeric' => 'Сумата трябва да бъде числова стойност.',
                'interest.required' => 'Полето за лихва е задължително.',
                'interest.numeric' => 'Лихвата трябва да бъде числова стойност.',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $account = Account::where('id', '=', $id)->first();
        if($account == null)
        {
            return response()->json(['message' => 'User not found.', 404]);
        }

        $account->account_number = $request->account_number;
        $account->amount = $request->amount;
        $account->interest = $request->interest;
        $account->currency_id = $request->currency_id;
        $account->account_type_id = $request->account_type_id;
        $account->user_id = $request->user_id;

        $account->save();

        return response()->json(status: 201);
    }

    public function getAllAccounts()
    {
        $accounts = Account::with(['currency', 'card_type', 'user'])
            ->get();

        return response()->json($accounts, 200);
    }

    public function getAccount(string $id)
    {
        $account = Account::where('id', '=', $id)->first();
        return response()->json($account, 200);
    }

    public function getAccountLoaded(string $id)
    {
        $account = Account::where('id', '=', $id)
            ->with(['currency','card_type'])
            ->first();

        return response()->json($account, 200);
    }

    public function storeAccount(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'account_number' => 'required|string|size:10|unique:accounts,account_number',
                'amount' => 'required|numeric',
                'interest' => 'required|numeric',
                'currency_id' => 'required|integer|exists:currencies,id',
                'account_type_id' => 'required|integer|exists:account_types,id',
                'user_id' => 'required|integer|exists:users,id'
            ],
            [
                'account_number.required' => 'Полето за номер на акаунт е задължително.',
                'account_number.size' => 'Номерът на акаунта трябва да бъде точно 10 символа.',
                'account_number.unique' => 'Акаунт с този номер вече съществува.',
                'amount.required' => 'Полето за сума е задължително.',
                'amount.numeric' => 'Сумата трябва да бъде числова стойност.',
                'interest.required' => 'Полето за лихва е задължително.',
                'interest.numeric' => 'Лихвата трябва да бъде числова стойност.',
                'currency_id.required' => 'Полето за валута е задължително.',
                'currency_id.integer' => 'Идентификаторът на валутата трябва да бъде цяло число.',
                'currency_id.exists' => 'Избраната валута не съществува.',
                'account_type_id.required' => 'Полето за тип акаунт е задължително.',
                'account_type_id.integer' => 'Идентификаторът на типа акаунт трябва да бъде цяло число.',
                'account_type_id.exists' => 'Избраният тип акаунт не съществува.',
                'user_id.required' => 'Полето за потребител е задължително.',
                'user_id.integer' => 'Идентификаторът на потребителя трябва да бъде цяло число.',
                'user_id.exists' => 'Избраният потребител не съществува.'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $account = Account::create([
            'account_number' => $request->account_number,
            'amount' => $request->amount,
            'interest' => $request->interest,
            'currency_id' => $request->currency_id,
            'account_type_id' => $request->account_type_id,
            'user_id' => $request->user_id
        ]);

        return response()->json($account, 201);
    }

    public function deleteAccount(string $id)
    {
        $account = Account::where('id', '=', $id);
        $account->delete();

        return response()->json(status: 200);
    }
}
