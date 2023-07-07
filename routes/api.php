<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;

use App\Http\Controllers\BookingController;
use App\Http\Controllers\SearchController;
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

Route::post('/register', [AuthController::class, 'register']);

Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);

Route::post('/login', [AuthController::class, 'login']);
Route::get('/users', [AuthController::class, 'getUsers']);


// Shops
Route::get('/shops', [ShopController::class, 'index']);
Route::get('shops/{shop_id}',[ShopController::class, 'show']);
Route::post('shops', [ShopController::class, 'store']);
Route::put('shops/{id}', [ShopController::class, 'update']);
Route::delete('shops/{id}', [ShopController::class, 'destroy']);

// // Services
// Route::get('services', 'API\ServiceController@index');
// Route::get('services/{id}', 'API\ServiceController@show');
// Route::post('services', 'API\ServiceController@store');
// Route::put('services/{id}', 'API\ServiceController@update');
// Route::delete('services/{id}', 'API\ServiceController@destroy');

// // Combos
// Route::get('combos', 'API\ComboController@index');
// Route::get('combos/{id}', 'API\ComboController@show');
// Route::post('combos', 'API\ComboController@store');
// Route::put('combos/{id}', 'API\ComboController@update');
// Route::delete('combos/{id}', 'API\ComboController@destroy');

// // Comments
// Route::get('comments', 'API\CommentController@index');
// Route::get('comments/{id}', 'API\CommentController@show');
// Route::post('comments', 'API\CommentController@store');
// Route::put('comments/{id}', 'API\CommentController@update');
// Route::delete('comments/{id}', 'API\CommentController@destroy');

// // Ratings
// Route::get('ratings', 'API\RatingController@index');
// Route::get('ratings/{id}', 'API\RatingController@show');
// Route::post('ratings', 'API\RatingController@store');
// Route::put('ratings/{id}', 'API\RatingController@update');
// Route::delete('ratings/{id}', 'API\RatingController@destroy');

// // Histories
// Route::get('histories', 'API\HistoryController@index');
// Route::get('histories/{id}', 'API\HistoryController@show');
// Route::post('histories', 'API\HistoryController@store');
// Route::put('histories/{id}', 'API\HistoryController@update');
// Route::delete('histories/{id}', 'API\HistoryController@destroy');



//Booking
Route::get('random-key', [BookingController::class, 'generateKey']);
Route::get('/getservices',[BookingController::class, 'getShopServices']);
Route::post('/bookingservices',[BookingController::class, 'booking']);
Route::post('/getbookedstylists', [BookingController::class, 'checkStylistAvailability']);



//Search
Route::post('/getdistance', [SearchController::class, 'calculateDistance']);
Route::get('/getallShop', [SearchController::class, 'allShop']);
Route::post('/getratingstar', [SearchController::class, 'caculateRatingStar']);
Route::get('/shops', [SearchController::class, 'search']);

