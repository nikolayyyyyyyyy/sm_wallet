<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Currency;

class CurrencyController extends Controller
{
    public function getCurrency(string $id)
    {
        $currency = Currency::where('id', '=', $id)->first();
        return response()->json($currency, 200);
    }
    
    public function getCurrencies()
    {
        $currencies = Currency::all();
        return response()->json($currencies, 200);
    }

    public function updateCurrency(Request $request, string $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'currency' => 'required|max:10|unique:currencies,currency,' . $id,
            ],
            [
                'currency.unique' => 'Валутата вече съществува.',
                'currency.required' => 'Полето за валута е задължително.',
                'currency.max' => 'Валутата не може да бъде по-дълга от 10 символа.',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $currency = Currency::where('id', '=', $id)->first();
        $currency->currency = $request->currency;
        $currency->save();

        return response()->json(status: 204);
    }

    public function storeCurrency(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'currency' => 'required|max:10|unique:currencies,currency',
            ],
            [
                'currency.unique' => 'Валутата вече съществува.',
                'currency.required' => 'Полето за валута е задължително.',
                'currency.max' => 'Валутата не може да бъде по-дълга от 10 символа.',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $currency = Currency::create([
            'currency' => $request->currency,
        ]);

        return response()->json($currency, 201);
    }

    public function deleteCurrency(string $id)
    {
        $currency = Currency::where('id', '=', $id)->first();
        $currency->delete();

        return response()->json(status: 200);
    }
}
