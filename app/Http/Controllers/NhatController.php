<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\shop;

class NhatController extends Controller
{
    public function getshops()
    {
        $shops = shop::all();
        return response()->json($shops);
    }

    public function getShopbyShopId($shop_id)
    {
        $shop = shop::findOrFail($shop_id);
        return response()->json($shop);
    }

    public function getServicesByShopId($shopId)
    {
        $services = DB::table('shops')
            ->join('shops_services', 'shops.shop_id', '=', 'shops_services.shop_id')
            ->join('services', 'shops_services.service_id', '=', 'services.service_id')
            ->select('shops.*', 'shops_services.*', 'services.*')
            ->where('shops.shop_id', '=', $shopId)
            ->get();

        return response()->json(['services' => $services], 200);
    }

    public function getStylelistByShopId($shopId)
    {
        $stylist = DB::table('shops')
            ->join('stylists', 'shops.shop_id', '=', 'stylists.shop_id')
            ->select('shops.*', 'stylists.*')
            ->where('shops.shop_id', '=', $shopId)
            ->get();

        return response()->json(['stylist' => $stylist], 200);
    }

    public function getComboByShopId($shopId)
    {
        $combos = DB::table('shops')
            ->join('combos', 'shops.shop_id', '=', 'combos.shop_id')
            ->select('shops.*', 'combos.*')
            ->where('shops.shop_id', '=', $shopId)
            ->get();


        return response()->json(['combo' => $combos], 200);
    }
}

