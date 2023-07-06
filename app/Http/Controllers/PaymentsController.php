<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\payments;
use Illuminate\Support\Facades\DB;

class PaymentsController extends Controller
{
    public function getPaymentsByUserId($user_id)
{
    $payments = payments::where('user_id', $user_id)->first();

    return response()->json($payments);
}



// admin API

public function getPayments()
{
    $payments = payments::join('shops', 'payments.shop_id', '=', 'shops.shop_id')
    ->join('users', 'payments.user_id', '=', 'users.user_id')
    ->select('payments.*', 'shops.shop_name', 'shops.shop_image', 'users.user_name')
    ->get();

return response()->json($payments);
}
public function getPayment()
{
$payments = payments::join('shops', 'payments.shop_id', '=', 'shops.shop_id')
    ->join('users', 'payments.user_id', '=', 'users.user_id')
    ->select('shops.shop_id', DB::raw('MAX(shops.shop_name) as shop_name'), DB::raw('MAX(shops.shop_image) as shop_image'), DB::raw('SUM(payments.payment_amount) as total_amount'))
    ->groupBy('shops.shop_id')
    ->get();

return response()->json($payments);
}
}
