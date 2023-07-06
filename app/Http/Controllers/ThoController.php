<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\rating;
use App\Models\payment;
use App\Models\shop;
use App\Models\User;


use Illuminate\Support\Facades\DB;



class ThoController extends Controller
{


    // Ratings
    public function getRatings()
    {
        $ratings = rating::join('shops', 'ratings.shop_id', '=', 'shops.shop_id')
            ->join('users', 'ratings.user_id', '=', 'users.user_id')
            ->where('shops.is_shop', 1)
            ->select('ratings.*', 'shops.shop_name', 'shops.shop_image', 'users.user_name', 'users.user_email', 'shops.shop_phone', 'users.user_address')
            ->get();


        return response()->json($ratings);
    }
    public function deleteRatings($rating_id)
    {

        $ratings = rating::where('rating_id', $rating_id)->first();

        if (!$ratings) {
            return response()->json(['status' => 'error', 'msg' => 'Product not found'], 404);
        }

        $ratings->delete();

        return response()->json(['status' => 'ok', 'msg' => 'Delete successful']);
    }


    //Payment
    public function getPaymentsByUserId($user_id)
    {
        $payments = payment::where('user_id', $user_id)->first();

        return response()->json($payments);
    }
    public function getPayments()
    {
        $payments = payment::join('shops', 'payments.shop_id', '=', 'shops.shop_id')
            ->join('users', 'payments.user_id', '=', 'users.user_id')
            ->select('payments.*', 'shops.shop_name', 'shops.shop_image', 'users.user_name')
            ->get();

        return response()->json($payments);
    }
    public function getPayment()
    {
        $payments = payment::join('shops', 'payments.shop_id', '=', 'shops.shop_id')
            ->join('users', 'payments.user_id', '=', 'users.user_id')
            ->select('shops.shop_id', DB::raw('MAX(shops.shop_name) as shop_name'), DB::raw('MAX(shops.shop_image) as shop_image'), DB::raw('SUM(payments.payment_amount) as total_amount'))
            ->groupBy('shops.shop_id')
            ->get();

        return response()->json($payments);
    }
    //Barber Shop

    public function destroy($id)
    {
        $shop = shop::findOrFail($id);
        $shop->delete();
        return response()->json('Shop deleted successfully');
    }

    // duyệt BarBer Shop
    public function getBaberShop()
    {

        $shop = shop::join('users', 'shops.user_id', '=', 'users.user_id')
            ->where('is_shop', 0)
            ->select('shops.*', 'shops.shop_name', 'shops.shop_image', 'shops.shop_name', 'users.user_address')
            ->get();
        return response()->json($shop);
    }
    public function BecomeShop($shop_id)
    {
        // Lấy thông tin của shop dựa trên shop_id
        $shop = shop::find($shop_id);

        // Kiểm tra xem shop có tồn tại hay không
        if (!$shop) {
            return response()->json(['message' => 'Shop không tồn tại'], 404);
        }

        // Cập nhật trường is_shop của shop thành 1
        $shop->is_shop = 1;
        $shop->save();

        return response()->json(['message' => 'Cập nhật is_shop thành công'], 200);
    }
    //Users
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



    // Mo mo
    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }
    public function momo_payment(Request $request)
    {


        $payUrl = $request->input('payUrl');

        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua MoMo";
        $amount = "100000";
        $orderId = time() . "";
        $redirectUrl = "http://127.0.0.1:8000/";
        $ipnUrl = "http://127.0.0.1:8000/";
        $extraData = "";




        $requestId = time() . "";
        $requestType = "payWithATM";
        // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
        // //before sign HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        //    dd($signature);
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );
        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);  // decode json

        //Just a example, please check more in there
        return redirect()->to($jsonResult[$payUrl]);
    }
}
