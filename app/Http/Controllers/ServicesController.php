<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use Illuminate\Support\Facades\DB;

class ServicesController extends Controller
{
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



}
