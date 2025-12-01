<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:20|min:1',
            'middle_name' => 'nullable|min:1|max:20',
            'last_name' => 'nullable|min:1|max:20',
            'password' => 'required|min:3|max:100'
        ], [
            'name.required' => 'полето е задължително',
            'password.required' => 'полето е задължително',
            'email.unique' => 'Имейла вече съществува',
            'email.required' => 'Полето е задължително.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::withTrashed()
            ->where('email', '=', $request->input('email'))
            ->first();


        if ($user) {
            if ($user->trashed()) {

                $user->restore();
            } else {

                $validator = Validator::make($request->all(), [
                    'email' => 'required|email|unique:users,email',
                ], [
                    'email.unique' => 'Имейла вече съществува',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'errors' => $validator->errors(),
                    ], 422);
                }
            }

        } else {
            User::create([
                'name' => $request->input('name'),
                'middle_name' => $request->input('middle_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'role_id' => 2
            ]);

        }
        return response()->json(status: 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:3'
        ], [
            'email.required' => 'полето е задължително',
            'password.required' => 'полето е задължително',
            'password.min' => 'полето трябва да има поне 3 букви'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return response()->json([
                'message' =>
                    'невалидно потребителско име или парола'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(status: 200);
    }
}
