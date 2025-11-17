<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\TransactionType;
class TransactionTypeController extends Controller
{
    public function getTransactionTypes()
    {
        return response()->json(TransactionType::all(), 200);
    }

    public function storeTransactionType(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'transaction_type' => 'required|max:10|unique:transaction_types,transaction_type',
            ],
            [
                'transaction_type.unique' => 'Типът транзакция вече съществува.',
                'transaction_type.required' => 'Полето за тип транзакция е задължително.',
                'transaction_type.max' => 'Типът транзакция не може да бъде по-дълъг от 10 символа.',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $transactionType = TransactionType::create([
            'transaction_type' => $request->transaction_type
        ]);

        return response()->json($transactionType, 201);
    }

    public function deleteTransactionType(string $id)
    {
        $transaction_type = TransactionType::where('id', '=', $id);
        $transaction_type->delete();

        return response()->json(status: 200);
    }
}
