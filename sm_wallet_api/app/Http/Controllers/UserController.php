<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Favorite;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $currentUserId = $request->user()->id;
        $users = User::with('role')->get();

        $users->each(function ($user) use ($currentUserId) {
            $user->is_favorited = Favorite::where('user_id', $currentUserId)
                ->where('liked_user_id', $user->id)
                ->exists();
            $user->profile_photo = $user->profile_photo != null ? asset($user->profile_photo) : null;
        });

        return response()->json($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:20|min:1',
            'middle_name' => 'nullable|min:1|max:20',
            'last_name' => 'nullable|min:1|max:20',
            'email' => 'required|email|unique:users,email',
            'role_id' => 'required',
            'password' => 'required|min:3|max:100'
        ], [
            'name' => 'Полето е задължително',
            'middle_name' => 'Полето трябва да е до 20 символа',
            'last_name' => 'Полето трябва да е до 20 символа',
            'email.required' => 'Полето е задължително',
            'email.unique' => 'Има запис с този имейл',
            'role_id' => 'Полето е задължително',
            'password' => 'Полето е задължително'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        User::create([
            'name' => $request->input('name'),
            'middle_name' => $request->input('middle_name') ?? '',
            'last_name' => $request->input('last_name') ?? '',
            'email' => $request->input('email'),
            'role_id' => $request->input('role_id'),
            'password' => Hash::make($request->input('password'))
        ]);

        return response()->json(status: 200);
    }
    
    /**
     * Update the specified user.
    */
    public function updateUserProfile(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:20|min:1',
            'middle_name' => 'nullable|string|max:20|min:1',
            'last_name' => 'nullable|string|max:20|min:1',
            'email' => 'required|email|unique:users,email,' . $id,
            'profile_picture' => 'nullable|image|max:2048',
            'password' => 'nullable|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->middle_name = $request->middle_name ?? '';
        $user->last_name = $request->last_name ?? '';
        if($user->email !== $request->email)
        {
            $user->email = $request->email;
        }

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_photo) {
                $oldPath = str_replace('/storage/', '', $user->profile_photo);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('profile_picture')
                ->store('profile_pictures', 'public');
            $user->profile_photo = Storage::url($path);
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if($request->input('role_id')){
            $user->role_id = $request->input('role_id');
        }

        $user->save();

        return response()->json(status: 201);
    }

    public function getUser(string $id)
    {
        $user = User::where('id', '=', $id)
            ->with('role')
            ->first();
        $user->profile_photo = $user->profile_photo != null ? asset($user->profile_photo) : null;
        return response()->json($user, 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = User::where('id', '=', $id);
        $client->delete();

        return response()->json(status: 200);
    }

    /**
     * Check and validate email, return user if exists.
     */
    public function checkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ], [
            'email.required' => 'Полето е задължително',
            'email.email' => 'Имейлът трябва да е валиден'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('email', $request->input('email'))
            ->first();

        if (!$user) {
            return response()->json([
                'errors' => [
                    'email' => ['Потребител с този имейл не е намерен']
                ]
            ], 422);
        }

        $currentUserId = $request->user()->id;
        $user->is_favorited = Favorite::where('user_id', $currentUserId)
            ->where('liked_user_id', $user->id)
            ->exists();

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'middle_name' => $user->middle_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'profile_photo' => $user->profile_photo ? asset($user->profile_photo) : null,
        ], 200);
    }
}
