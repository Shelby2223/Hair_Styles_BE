<?php

namespace App\Http\Controllers;
use App\Models\histories;
use Illuminate\Http\Request;
use App\Models\shops;
use App\Models\services;

class HistorisController extends Controller
{
    public function getHistory()
    {
        $history = histories::all();
        return response()->json($history);
    }


    public function show()
{
    $historis = histories::all();

    $result = [];

    foreach ($historis as $histori) {

        $shop = shops::find($histori->shop_id);
        $service = services::find($histori->service_id);



        $result[] = [
            'history_id' => $histori->history_id,
            'user_id' => $histori->user_id,
            'shop_id' => $histori->shop_id,
            'service_id' => $histori->service_id,
            'combo_id' => $histori->combo_id,
            'payment_id' => $histori->payment_id,
            'appointment_date' => $histori->appointment_date,
            'appointment_time' => $histori->appointment_time,
            'created_at' => $histori->created_at,
            'updated_at' => $histori->updated_at,
            'shop_name' => $shop->name, // Lấy tên của cửa hàng
            'service_name' => $service->name // Lấy tên của dịch vụ
        ];
    }

    return response()->json($result);
}


}
