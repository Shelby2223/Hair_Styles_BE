<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\HistorisController;
use App\Http\Controllers\NhatController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\RatingsController;
use App\Http\Controllers\TamController;
use App\Http\Controllers\TrungController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// TRUNG ĐẶNG
// register
Route::post('/register', [TrungController::class, 'register']);
Route::post('/verify-otp', [TrungController::class, 'verifyOtp']);

// forgot password
Route::post('/forgot_password', [TrungController::class, 'forgotpassword']);
Route::post('/verify_new_password', [TrungController::class, 'verifyNewPassword']);

// Login
Route::post('/login', [TrungController::class, 'login']);
// lấy thông tin user.
Route::get('/users', [TrungController::class, 'getUsers']);


// VÕ THÀNH TÂM
// users
Route::get('/users', [TamController::class, 'getUsers']);
Route::get('/users/{users_id}', [TamController::class, 'getUsersId']);
Route::put('/users/{id}', [TamController::class, 'update']);


// PAHN ĐỨC THƠ
Route::get('/is_user', [ThoController::class, 'getIsUser']);
Route::put('/users/{id}', [ThoController::class, 'update']);


//payments
Route::get('/payments/{user_id}', [ThoController::class, 'getPaymentsByUserId']);
Route::get('/get-payments', [ThoController::class, 'getPayments']);
Route::get('/get-payment', [ThoController::class, 'getPayment']);

//ratings
Route::get('/delete-ratings/{rating_id}', [ThoController::class, 'deleteRatings']);
Route::get('/get-ratings', [ThoController::class, 'getRatings']);

// Shops
Route::get('/shops', [ShopController::class, 'index']);
Route::get('shops/{shop_id}', [ShopController::class, 'show']);
Route::post('shops', [ShopController::class, 'store']);
Route::put('shops/{id}', [ShopController::class, 'update']);
Route::delete('shops/{id}', [ShopController::class, 'destroy']);

// duyệt shop
Route::get('/approve', [ShopController::class, 'getBaberShop']);
Route::post('/approve/{shop_id}', [ShopController::class, 'BecomeShop']);


Route::get('/tho/payment-redirect', [VNPayController::class, 'momo_payment'])->name('payment.redirect');


// HOÀN BÙI
//Booking
Route::get('random-key', [BookingController::class, 'generateKey']);

Route::get('/getservices', [BookingController::class, 'getShopServices']);

Route::post('/bookingservices', [BookingController::class, 'booking']);


Route::get('/getbookedstylists', [BookingController::class, 'checkStylistAvailability']);


// NGUYỄN VĂN NHẬT 
Route::get('/shops', [NhatController::class, 'getshops']);
Route::get('/shops/{shop_id}',[NhatController::class, 'getShopbyShopId']);
Route::get('/service_shop_id/{shop_id}',[NhatController::class,'getServicesByShopId']);
Route::get('/style/{shop_id}',[NhatController::class ,'getStylelistByShopId']);
Route::get('/combo/{shop_id}',[NhatController::class,'getComboByShopId']);