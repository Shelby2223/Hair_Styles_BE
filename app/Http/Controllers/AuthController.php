<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\user_register;

class AuthController extends Controller
{

    public function register(Request $request)
    {

        // Xóa hết dữ liệu cũ trong bảng user_register
        user_register::truncate();

        // Lấy giá trị từ request
        $user_register_name = $request->input('user_name');
        $user_register_phone = $request->input('user_phone');
        $user_register_address = $request->input('user_address');
        $user_register_email = $request->input('user_email');
        $user_register_password = Hash::make($request->input('user_password'));

        // Tạo một đối tượng user_register và gán các giá trị từ request vào các thuộc tính tương ứng
        $user_register = new user_register();
        $user_register->user_register_name = $user_register_name;
        $user_register->user_register_phone = $user_register_phone;
        $user_register->user_register_address = $user_register_address;
        $user_register->user_register_email = $user_register_email;
        $user_register->user_register_password = $user_register_password;

        // Lưu đối tượng user_register vào cơ sở dữ liệu
        $user_register->save();

        // Tạo mã OTP
        $otpCode = mt_rand(100000, 999999);

        // Lưu mã OTP vào user_register
        $user_register->user_register_otp =  $otpCode;

        // Lưu đối tượng user_register vào cơ sở dữ liệu
        $user_register->save();

        // Gửi mã OTP qua email
        $this->sendOtpEmail($user_register_email, $otpCode, $user_register_name);

        // Lấy tất cả dữ liệu từ bảng user_register
        $userData = user_register::all();

        return response()->json([
            'userData' => $userData,
            'message' => 'Registration successful. Please check your email for the OTP.'
        ]);
    }


    // Xác minh mã opt có đúng không
    public function verifyOtp(Request $request)
    {
        // Lấy giá trị OTP từ db
        $user_register = user_register::first();
        $otpFromdb = $user_register->user_register_otp;

        // Lấy giá trị OTP từ request gửi từ ReactJS qua API
        // $otpFromRequest = intval($request->input('otp_code'));

        $otpFromRequest = $request->input('otp_code');


        // if (isset($otpFromdb)) {

        //     return response()->json([
        //         'otpdb' => $otpFromdb,
        //         'otpinput' => $otpFromRequest
        //     ]);
        // }
        // So sánh giá trị OTP
        if ($otpFromRequest == $otpFromdb) {
            // OTP đúng, tiếp tục quá trình đăng ký

            // Lấy thông tin đăng ký từ bảng user_register
            $user_register = user_register::first();

            // Tạo một đối tượng User mới và gán các thuộc tính từ user_register
            $user = new User();
            $user->user_name = $user_register->user_register_name;
            $user->user_email = $user_register->user_register_email;
            $user->user_password = $user_register->user_register_password;
            $user->user_phone = $user_register->user_register_phone;
            $user->user_address = $user_register->user_register_address;
            // Gán các thuộc tính khác từ user_register vào đối tượng User

            // Lưu đối tượng User vào bảng users
            $user->save();

            // Xóa dữ liệu trong bảng user_register
            user_register::truncate();

            // Gửi thông báo xác minh OTP thành công và biến thành công là true về ReactJS qua API
            return response()->json(['success' => true]);
        } else {
            // OTP sai, hiển thị thông báo lỗi

            // Trả về thông báo lỗi xác minh OTP
            return response()->json(['success' => 'Invalid OTP. Please try again.']);
        }
    }


    private function sendOtpEmail($email, $otpCode, $name)
    {
        $messageContent = "Welcome " . $name . "♥\nYour OTP: " . $otpCode;

        Mail::raw($messageContent, function ($message) use ($email) {
            $message->to($email)
                ->subject('OTP Verification');
        });
    }
}
