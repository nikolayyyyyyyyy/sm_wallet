<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\AccountType;
class AccountTypeController extends Controller
{
    public function getAccountTypes()
    {
        $accountTypes = AccountType::all();
        return response()->json($accountTypes, 200);
    }

    public function storeAccountType(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'account_type' => 'required|max:10|unique:account_types,account_type',
            ],
            [
                'account_type.unique' => 'Типът акаунт вече съществува.',
                'account_type.required' => 'Полето за тип акаунт е задължително.',
                'account_type.max' => 'Типът акаунт не може да бъде по-дълъг от 10 символа.',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $accountType = AccountType::create([
            'account_type' => $request->account_type,
        ]);

        return response()->json($accountType, 201);
    }
}
