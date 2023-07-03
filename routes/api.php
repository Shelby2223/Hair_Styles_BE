<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\APIController;
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
Route::get('shops/{shop_id}', [ShopController::class, 'show']);
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


use GuzzleHttp\Client;

// routes/api.php

//Search
Route::post('/getdistance', [APIController::class, 'calculateDistance']);
Route::post('/getallShop', [APIController::class, 'allShop']);

Route::post('/getratingstar', [APIController::class, 'caculateRatingStar']);
Route::get('/shops', [APIController::class, 'search']);


// Route::get('/get-coordinates', function () {
//     $location = '99 Tô Hiến Thành, Phước Mỹ, Sơn Trà, Đà Nẵng 550000, Việt Nam'; // Địa điểm cần chuyển đổi
//     $apiKey = 'pk.eyJ1IjoiaG9hbmIyNCIsImEiOiJjbGpnamV4bXowNmFtM2xxaWZnYnEwaWQ4In0.aSnV4rCTGUxjMMEXOnA9iQ';

//     $client = new Client();
//     $response = $client->get('https://api.mapbox.com/geocoding/v5/mapbox.places/' . urlencode($location) . '.json', [
//         'query' => [
//             'access_token' => $apiKey,
//         ],
//     ]);

//     $data = json_decode($response->getBody(), true);
//     $coordinates = $data['features'][0]['center']; // Mảng [longitude, latitude]

//     return $coordinates;
// });




// Route::get('/get-coordinates', function (Request $request) {
//     $address = $request->input('address', 'Phước Mỹ, Sơn Trà, Đà Nẵng');
//     $apiKey = 'pk.eyJ1IjoiaG9hbmIyNCIsImEiOiJjbGpnamV4bXowNmFtM2xxaWZnYnEwaWQ4In0.aSnV4rCTGUxjMMEXOnA9iQ';
//     $client = new Client();

//     $response = $client->get('https://maps.googleapis.com/maps/api/geocode/json', [
//         'query' => [
//             'address' => $address,
//             'key' => $apiKey,
//         ],
//     ]);

//     $data = json_decode($response->getBody(), true);

//     if (isset($data['results'][0]['geometry']['location'])) {
//         $coordinates = $data['results'][0]['geometry']['location'];
//         return $coordinates;
//     }

//     return response()->json(['error' => 'Address not found'], 404);
// });


