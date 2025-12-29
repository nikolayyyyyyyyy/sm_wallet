<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function getTransactionBySlug(string $slug)
    {
        $account = Account::where('account_number', '=', $slug)->first();
        if($account == null){
            return response()->json(['message' => 'Account not found', 404]);
        }

        $transactions = Transaction::where(function ($q) use ($account){
            $q->where('account_sender_id', '=', $account->id)
                ->orWhere('account_receiver_id', '=', $account->id);
        })->get();

        $transactions->load(['sender_account',
            'receiver_account',
            'transaction_type',
            'receiver_account.currency',
            'receiver_account.card_type',
            'sender_account.currency',
            'sender_account.card_type',
            'receiver_account.user',
            'sender_account.user',]);

        return response()->json($transactions, 200);
    }

    public function updateTransaction(Request $request)
    {
        $transaction = Transaction::where('id', '=', $request->id)->first();
        if($transaction == null)
        {
            return response()->json(['message' => 'Transaction not fount.'], 404);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'amount' => 'required|numeric',
                'note' => 'nullable|string|max:255',
                'sender_account_number' => 'required|exists:accounts,account_number',
                'receiver_account_number' => 'required|exists:accounts,account_number'
            ],
            [
                'amount.required' => 'Полето за сума е задължително.',
                'amount.numeric' => 'Сумата трябва да бъде число.',
                'note.max' => 'Бележката не може да надвишава 255 символа.',
                'sender_account_number.required' => 'Полето за изпращач е задължително',
                'sender_account_number.exists' => 'Номера на изпращача не съществува.',
                'receiver_account_number.required' => 'Полето за получател е задължително',
                'receiver_account_number.exists' => 'Номера на получател не съществува.'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $account_sender = Account::where("account_number", "=", $request->sender_account_number)->first();
        $account_receiver = Account::where("account_number", "=", $request->receiver_account_number)->first();

        $transaction->amount = $request->amount;
        $transaction->note = $request->note;
        $transaction->transaction_type_id = $request->transaction_type_id;
        $transaction->account_sender_id = $account_sender->id;
        $transaction->account_receiver_id = $account_receiver->id;
        $transaction->save();

        return response()->json(status: 201);
    }

    public function getTransaction(string $id)
    {
        $transaction = Transaction::where('id', '=', $id)
            ->with(['sender_account', 'receiver_account'])->first();

        if($transaction == null){
            return response()->json(['message' => 'Transaction not fount'],404);
        }

        return response()->json($transaction, 200);
    }

    public function getAllTransactions()
    {
        $transactions = Transaction::with([
            'transaction_type',
            'sender_account',
            'receiver_account',
            'sender_account.currency'
        ])
            ->get();

        return response()->json($transactions, 200);
    }
    public function storeTransaction(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'amount' => 'required|numeric',
                'note' => 'nullable|string|max:255',
                'transaction_type_id' => 'required|integer|exists:transaction_types,id',
                'account_sender_number' => 'nullable|exists:accounts,account_number',
                'account_sender_id' => 'nullable|exists:accounts,id',
                'account_receiver_number' => 'required|exists:accounts,account_number',
            ],
            [
                'amount.required' => 'Полето за сума е задължително.',
                'amount.numeric' => 'Сумата трябва да бъде число.',
                'note.max' => 'Бележката не може да надвишава 255 символа.',
                'transaction_type_id.required' => 'Типът на транзакция е задължителна',
                'account_sender_number.required' => 'Полето за изпращач е задължително',
                'account_sender_number.exists' => 'Номера на изпращача не съществува.',
                'account_receiver_number.required' => 'Полето за получател е задължително',
                'account_receiver_number.exists' => 'Номера на получател не съществува.'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $account_sender = Account::where("account_number", "=", $request->account_sender_number)->first();
        $account_receiver = Account::where("account_number", "=", $request->account_receiver_number)->first();

        if ($account_sender->amount < $request->amount) {
            return response()->json(["notEnoughtMoney" => "Изпращача няма достатъчно пари за транзакцията"], 500);
        }

        $account_sender->amount -= $request->amount;
        $account_receiver->amount += $request->amount;
        $account_sender->save();
        $account_receiver->save();

        $transaction = Transaction::create([
            'amount' => $request->amount,
            'note' => $request->note,
            'transaction_type_id' => $request->transaction_type_id,
            'account_sender_id' => $account_sender->id,
            'account_receiver_id' => $account_receiver->id,
        ]);

        return response()->json(['transaction' => $transaction], 201);
    }

    public function deleteTransaction(string $id)
    {
        $transaction = Transaction::where('id', '=', $id);
        $transaction->delete();

        return response()->json(status: 200);
    }
}
