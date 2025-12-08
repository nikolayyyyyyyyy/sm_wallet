<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    public function store_favorite(Request $request)
    {
        $user_id = $request->input('user_id');
        $liked_user_id = $request->input('liked_user_id');

        $favorite = Favorite::where('user_id', $user_id)
            ->where('liked_user_id', $liked_user_id)->first();

        if ($favorite) {
            $favorite->delete();
        } else {
            Favorite::create($request->all());
        }
    }
}
