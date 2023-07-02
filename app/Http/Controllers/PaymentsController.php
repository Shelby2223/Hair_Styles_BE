<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\payments;
class PaymentsController extends Controller
{
    public function getPaymentsByUserId($user_id)
{
    $payments = payments::where('user_id', $user_id)->first();

    return response()->json($payments);
}
}
