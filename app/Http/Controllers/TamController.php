<?php

namespace App\Http\Controllers;

use App\Models\rating;
use App\Models\User;
use Illuminate\Http\Request;

class TamController extends Controller
{
    public function getUsers()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function getUsersId($users_id)
    {
        $users = User::findOrFail($users_id);
        return response()->json($users);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'user_name' => 'required',
            'user_phone' => 'required',
            'user_email' => 'required',
            'user_address' => 'required',
            'user_password' => 'required',
        ]);

        $users = User::findOrFail($id);
        $users->update($validatedData);
        return response()->json($users);
    }

    public function getIsUser()
    {
        $users = User::where('is_user', 1)->get();
        return response()->json($users);
    }

    public function storeRating(Request $request)
    {
        try {
            $user_id = $request->input('user_id');
            $shop_id = $request->input('shop_id');
    
            // Check if the user has already rated for this shop
            $rating = rating::where('user_id', $user_id)->where('shop_id', $shop_id)->first();
    
            if ($rating) {
                // Update the existing rating
                $rating->rating_star = $request->input('rating_star');
                $rating->content = $request->input('comment');
                $rating->save();
            } else {
                // Create a new rating
                $rating = new rating();
                $rating->user_id = $user_id;
                $rating->shop_id = $shop_id;
                $rating->rating_star = $request->input('rating_star');
                $rating->content = $request->input('comment');
                $rating->save();
            }
    
            return response()->json($rating, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    
    public function getRatingsWithUserNames($shopId)
    {
        $ratings = rating::where('shop_id', $shopId)->get();
    
        $result = [];
    
        foreach ($ratings as $rating) {
            $user = User::find($rating->user_id);
    
            $result[] = [
                'rating_id' => $rating->rating_id,
                'user_id' => $rating->user_id,
                'user_name' => $user->user_name,
                'shop_id' => $rating->shop_id,
                'rating_star' => $rating->rating_star,
                'comment' => $rating->content,
                'created_at'=> $rating->created_at,
            ];
        }
    
        return response()->json($result);
    }
    
}







