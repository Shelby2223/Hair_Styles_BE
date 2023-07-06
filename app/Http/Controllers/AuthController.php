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

        // Lấy giá trị từ request
        $user_register_name = $request->input('user_name');
        $user_register_email = $request->input('user_email');
        // Tạo mã OTP
        $otpCode = mt_rand(100000, 999999);
        // Tạo một đối tượng user và gán các giá trị từ request vào các thuộc tính tương ứng
        $user = new user();
        $user->user_name = $request->input('user_name');
        $user->user_phone = $request->input('user_phone');
        $user->user_address = $request->input('user_address');
        $user->user_email = $request->input('user_email');
        $user->user_password = $otpCode;

        // Lưu đối tượng user vào cơ sở dữ liệu
        $user->save();

        // Gửi mã OTP qua email
        $this->sendOtpEmail($user_register_email, $otpCode, $user_register_name);

        return response()->json([
            'message' => 'Registration successful. Please check your email for the OTP.'
        ]);
    }


    private function sendOtpEmail($email, $otpCode, $name)
    {
        $messageContent = "Welcome " . $name . "♥\nYour Password: " . $otpCode;

        Mail::raw($messageContent, function ($message) use ($email) {
            $message->to($email)
                ->subject('OTP Verification');
        });
    }

    // Xác minh mã opt có đúng không
    public function verifyOtp(Request $request)
    {
        // $otpFromRequest = intval($request->input('input_password'));
        $input_password = $request->input('input_password');
        $input_email = $request->input('user_email');

        $user = User::where('user_email', $input_email)->first();

        $hashedPassword = $user->user_password; // Mật khẩu đã được mã hóa trong cơ sở dữ liệu

        if ($hashedPassword == $input_password) {
            // Cập nhật trường 'is_user' thành true
            $user->is_user = true;
            $user->save();
            // OTP đúng, cập nhật trạng thái thành công
            // Gửi thông báo xác minh OTP thành công và biến thành công là true về ReactJS qua API
            return response()->json([
                'success' => true,
            ]);
        } else {
            // OTP đúng, nhưng cập nhật trạng thái thất bại
            // Xử lý lỗi nếu cần
            return response()->json([
                'success' => false,
            ]);
        }
    }

    public function login(Request $request)
    {
        // get data from api to compare
        $credentials = $request->only('input_email', 'input_password');

        // Kiểm tra thông tin đăng nhập
        $user = User::where('user_email', $credentials['input_email'])->first();

        if (!$user || !Hash::check($credentials['input_password'], $user->user_password)) {
            // Thông tin đăng nhập không chính xác
            return response()->json(['message' => 'Thông tin đăng nhập không chính xác'], 401);
        }
        return response()->json(['message' => true]);
    }


    public function getUsers()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function forgotpassword(Request $request)
    {

        // Lấy giá trị từ request
        $input_user_email = $request->input('input_email');
        // Tạo mã OTP
        $otp_new_password = mt_rand(100000, 999999);

        // Lấy user_name ra từ db
        $user = User::where('user_email', $input_user_email)->first();

        if ($user) {
            $user->user_password = $otp_new_password; // Cập nhật mật khẩu mới
            $user->save(); // Lưu thay đổi vào cơ sở dữ liệu
        }

        $user_name_db = $user->user_name;

        // Gửi mã OTP qua email
        $this->sendOtpEmailPassword($input_user_email, $otp_new_password, $user_name_db);

        return response()->json([
            'message' => 'Registration successful. Please check your email for the OTP.'
        ]);
    }

    private function sendOtpEmailPassword($email, $otp, $name)
    {
        $messageContent = "Welcome " . $name . "♥\nYour new Password: " . $otp;

        Mail::raw($messageContent, function ($message) use ($email) {
            $message->to($email)
                ->subject('OTP Verification');
        });
    }

    // Xác minh mã opt có đúng không
    public function verifyNewPassword(Request $request)
    {
        // $otpFromRequest = intval($request->input('input_password'));
        $input_password = $request->input('input_password');
        $input_email = $request->input('input_email');

        $user = User::where('user_email', $input_email)->first();

        $hashedPassword = $user->user_password; // Mật khẩu đã được mã hóa trong cơ sở dữ liệu
        $id_user = $user->user_id;

        if ($hashedPassword == $input_password) {
            // OTP đúng, cập nhật trạng thái thành công
            // Gửi thông báo xác minh OTP thành công và biến thành công là true về ReactJS qua API
            return response()->json([
                'success' => true,
                'id_user' => $id_user

            ]);
        } else {
            // OTP đúng, nhưng cập nhật trạng thái thất bại
            // Xử lý lỗi nếu cần
            return response()->json([
                'success' => false,
            ]);
        }
    }
}
