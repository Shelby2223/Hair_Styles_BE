<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\HistorisController;
use App\Http\Controllers\ComboController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\ShopserviceController;
use App\Http\Controllers\StylelistController;
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


// Tam
Route::get('/users', [UsersController::class, 'getUsers']);
Route::get('users/{users_id}',[UsersController::class, 'getUsersId']);


//Histories
Route::get('/Histories', [HistorisController::class, 'getHistory']);
Route::get('/Historis', [HistorisController::class, 'show']);

// Shops
Route::get('/shops', [ShopController::class, 'index']);
Route::get('shops/{shop_id}',[ShopController::class, 'show']);
Route::post('shops', [ShopController::class, 'store']);
Route::put('shops/{id}', [ShopController::class, 'update']);
Route::delete('shops/{id}', [ShopController::class, 'destroy']);

// Combos
Route::get('/combos',[ComboController::class,'index']);
Route::get('combos/{shop_id}',[ComboController::class,'get_combos_shop_id']);
Route::post('combos', [ComboController::class,'store']);
Route::put('combos/{id}', [ComboController::class,'update']);
Route::delete('combos/{id}',[ComboController::class,'destroy']);


// Comboservices
// Route::get('/shopservice',[ShopserviceController::class,'index']);
// Route::get('/shopservice/{id}',[ShopserviceController::class,'index']);
// Route::post('/shopservice', [ShopserviceController::class,'store']);
// Route::put('/shopservice{id}', [ShopserviceController::class,'update']);
// Route::delete('/shopservice{id}',[ShopserviceController::class,'destroy']);


// Stylelist
Route::get('/stylelist',[StylelistController::class,'index']);
Route::get('/stylelist/{id}',[StylelistController::class,'index']);
Route::post('/stylelist', [StylelistController::class,'store']);
Route::put('/stylelist/{id}', [StylelistController::class,'update']);
Route::delete('/stylelist/{id}',[StylelistController::class,'destroy']);


// // Services
// Route::get('services', 'API\ServiceController@index');
Route::get('/service_shop_id/{shop_id}',[ServicesController::class,'getServicesByShopId']);
// Route::post('services', 'API\ServiceController@store');
// Route::put('services/{id}', 'API\ServiceController@update');
// Route::delete('services/{id}', 'API\ServiceController@destroy');



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


