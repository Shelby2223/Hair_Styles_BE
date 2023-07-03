<?php

// namespace App\Http\Controllers;

// use DB;
// use Illuminate\Http\Request;
// use App\Models\addresses;

// use Illuminate\Database\Eloquent\Scope;
// class APIController extends Controller
// {
//     public function calculateDistance(Request $request)
// {
//     $latitudeUser = $request->input('latitude');
//     $longitudeUser = $request->input('longitude');



//     $distanceData['result'] = \Illuminate\Support\Facades\DB::table('addresses')->select('shop_id',
//     \Illuminate\Support\Facades\DB::raw("6357 * acos(cos(radians(".$latitudeUser."))
//     * cos(radiant(addresses.latitude))
//     * cos(radiant(addresses.longitude) - radians(".$longitudeUser."))
//     + sin(radians(".$latitudeUser."))
//     + sin(radians(addresses.latitude))
//     ) AS distance"))->get();

//     dd($distanceData['result']);

//     // $addresses = addresses::select('shop_id', 'latitude', 'longitude', 'address')->get();
//     // $distanceData = [];

//     // foreach ($addresses as $address) {
//     //     $shop_id = $address->shop_id;
//     //     $latitude = $address->latitude;
//     //     $longitude = $address->longitude;

//     //     $distance = Scope::distance($latitudeUser, $longitudeUser, $latitude, $longitude);

//     //     $distanceData[] = [
//     //         'shop_id' => $shop_id,
//     //         'distance' => $distance
//     //     ];
//     // }

//     // // Hiển thị dữ liệu khoảng cách
//     // foreach ($distanceData as $data) {
//     //     $shop_id = $data['shop_id'];
//     //     $distance = $data['distance'];

//     //     echo "Shop ID: " . $shop_id . ", Khoảng cách: " . $distance . " km";
//     // }
// }
// }


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\addresses;
use App\Models\ratings;
use App\Models\shops;

class APIController extends Controller
{
    public function search(Request $request)
    {
        $searchTerm = $request->query('search');

        $shops = DB::table('shops')
            ->join('addresses', 'shops.shop_id', '=', 'addresses.shop_id')
            ->leftJoin('ratings', 'shops.shop_id', '=', 'ratings.shop_id')
            ->select(
                'shops.shop_id',
                'shops.shop_name',
                'shops.shop_phone',
                'shops.shop_image',
                'addresses.address as shop_address',
                DB::raw('COUNT(ratings.user_id) as rating_count'),
                DB::raw('ROUND(AVG(ratings.rating_star), 1) as avg_rating_star')
            )
            ->where('shops.shop_name', 'LIKE', '%' . $searchTerm . '%')
            ->groupBy('shops.shop_id', 'shops.shop_name', 'shops.shop_phone', 'shops.shop_image', 'addresses.address')
            ->get();

        return response()->json($shops);
    }



    public function calculateDistance(Request $request)
    {

        $latitudeUser = $request->input('latitude');
        $longitudeUser = $request->input('longitude');
        $distanceData['result'] = DB::table('addresses')
            ->join('shops', 'addresses.shop_id', '=', 'shops.shop_id')
            ->select(
                'shops.shop_name',
                'addresses.address',
                'addresses.shop_id',
                'shops.shop_phone',
                'addresses.latitude',
                'addresses.longitude',
                DB::raw("ROUND(6371 * acos(cos(radians(" . $latitudeUser . "))
                * cos(radians(addresses.latitude))
                * cos(radians(addresses.longitude) - radians(" . $longitudeUser . "))
                + sin(radians(" . $latitudeUser . "))
                * sin(radians(addresses.latitude))), 2) AS distance")
            )
            ->orderBy('distance', 'asc')
            ->get();


        return response()->json($distanceData);
    }

    public function caculateRatingStar()
    {
        $ratings = ratings::selectRaw('shops.shop_id,shops.shop_name, shops.shop_phone, addresses.address, ROUND(AVG(ratings.rating_star), 1) as avg_rating, COUNT(ratings.user_id) as rating_count')
            ->join('shops', 'shops.shop_id', '=', 'ratings.shop_id')
            ->join('addresses', 'addresses.shop_id', '=', 'shops.shop_id')
            ->groupBy('shops.shop_id', 'shops.shop_name', 'shops.shop_phone', 'addresses.address')
            ->orderBy('avg_rating', 'desc')
            ->get();

        return response()->json($ratings);
    }
}
