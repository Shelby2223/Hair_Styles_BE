<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\rating;
use App\Models\payment;
use App\Models\shop;
use App\Models\User;
use Carbon\Carbon;
use App\Models\history;
use App\Models\address;


use Illuminate\Support\Facades\Auth;


use Illuminate\Support\Facades\DB;



class ThoController extends Controller
{
    public function getShopsByUserId($userId)
{
    // Lấy dữ liệu từ database sử dụng Eloquent hoặc Query Builder
    $shops = Shop::where('user_id', $userId)->get();

    // Trả về dữ liệu dưới dạng JSON
    return response()->json($shops);
}
    
    // register to become to barbershop
    public function addShop(Request $request)
    {
        try {
            // Lấy dữ liệu từ request
            $shopName = $request->input('shop_name');
            $shopEmail = $request->input('shop_email');
            $shopImage = $request->input('shop_image');
            $shopPhone = $request->input('shop_phone');
            $userid=$request-> input('user_id');
    
            // Tạo một đối tượng Shop mới
            $newShop = new shop();
            $newShop->shop_name = $shopName;
            $newShop->shop_email = $shopEmail;
            $newShop->shop_image = $shopImage;
            $newShop->shop_phone = $shopPhone;
            $newShop->is_shop="0";
            $newShop->user_id=$userid;
            
    
            // Lưu đối tượng Shop vào cơ sở dữ liệu
            $newShop->save();
    
            // Trả về phản hồi thành công
            return response()->json(['message' => 'Thêm shop thành công'], 200);
        } catch (\Exception $e) {
            dd($e);
            // Xử lý lỗi nếu có
            return response()->json(['error' => 'Đã xảy ra lỗi'], 500);
        }
    }
    public function addAddress(Request $request)
    {
        try {
            $shop = Shop::latest()->first();
            $shopId = $shop->shop_id;
            // Lấy dữ liệu từ request
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');
            $address=$request->input('address');

            // Tạo một đối tượng Address mới
            $newAddress = new address();
            $newAddress->latitude = $latitude;
            $newAddress->longitude = $longitude;
            $newAddress->address=$address;
            $newAddress->shop_id=$shopId;

            // Lưu đối tượng Address vào cơ sở dữ liệu
            $newAddress->save();

            // Trả về phản hồi thành công
            return response()->json(['message' => 'Đã thêm địa chỉ thành công'], 200);
        } catch (\Exception $e) {
            // Xử lý lỗi nếu có
            return response()->json(['error' => 'Đã xảy ra lỗi'], 500);
        }
    }
    


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
    public function payment_VnPay($totalPrice) {
        
       



        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost:3000/thankfull";
        $vnp_TmnCode = "HMEJ9HK0";//Mã website tại VNPAY 
        $vnp_HashSecret = "CLTOHNQVRSFMUVOWUFVAQLEATTNJRSJP"; //Chuỗi bí mật

        $vnp_TxnRef = Carbon::now()->timestamp; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = "Da Thanh Toan";
        $vnp_OrderType = "100000";
        $vnp_Amount = ($totalPrice*1000)*100;
        $vnp_Locale = "vn";
        $vnp_BankCode = "NCB";
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        // if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
        //     $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        // }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array('code' => '00'
            , 'message' => 'success'
            , 'data' => $vnp_Url);

        return response()->json($returnData);
        
        
  

        }
    }

