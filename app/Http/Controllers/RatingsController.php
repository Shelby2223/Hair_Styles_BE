<?php

namespace App\Http\Controllers;

use App\Models\ratings;

use Illuminate\Http\Request;
class RatingsController extends Controller
{
    public function getRatings()
    {
        $ratings = ratings::join('shops', 'ratings.shop_id', '=', 'shops.shop_id')
            ->join('users', 'ratings.user_id', '=', 'users.user_id')
            ->select('ratings.*', 'shops.shop_name', 'shops.shop_image', 'users.user_name')
            ->get();

        return response()->json($ratings);
    }
    public function deleteRatings($rating_id)
    {
       
        $ratings = ratings::where('rating_id', $rating_id)->first();

        if (!$ratings) {
            return response()->json(['status' => 'error', 'msg' => 'Product not found'], 404);
        }

        $ratings->delete();

        return response()->json(['status' => 'ok', 'msg' => 'Delete successful']);
    }
}
