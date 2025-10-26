<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function storeTransaction(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'amount' => 'required|numeric',
                'note' => 'nullable|string|max:255',
                'transaction_type_id' => 'required|integer|exists:transaction_types,id',
                'account_sender_id' => 'required|integer|exists:accounts,id',
                'account_receiver_id' => 'required|integer|exists:accounts,id',
            ],
            [
                'amount.required' => 'Полето за сума е задължително.',
                'amount.numeric' => 'Сумата трябва да бъде число.',
                'note.string' => 'Бележката трябва да бъде текст.',
                'note.max' => 'Бележката не може да надвишава 255 символа.',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $transaction = Transaction::create([
            'amount' => $request->amount,
            'note' => $request->note,
            'transaction_type_id' => $request->transaction_type_id,
            'account_sender_id' => $request->account_sender_id,
            'account_receiver_id' => $request->account_receiver_id,
        ]);

        return response()->json(['transaction' => $transaction], 201);
    }
}
