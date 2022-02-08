<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CouponsController;
use App\Http\Controllers\Api\GigController;
use App\Http\Controllers\Api\Seller\OrderController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ChatMessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::post('/login',[LoginController::class,'apiLogin']);
Route::post('/register',[RegisterController::class,'apiRegister']);
Route::post('/send-forget-password-link',[UserController::class,'sendForgetPasswordLink']);
Route::post('google-login',[LoginController::class,'googleLogin']);
Route::post('/get-roles',[UserController::class,'getRoles']);
Route::get('/get-parent-categories',[CategoryController::class,'getParentCategories']);
Route::post('/get-child-categories',[CategoryController::class,'getChildCategories']);
Route::post('/forget-username',[UserController::class,'forgetUserName']);
\Illuminate\Support\Facades\Broadcast::routes(['middleware'=>'auth:api']);

Route::middleware('auth:api')->prefix('seller')->group(function (){
    Route::get('/user-profile',[UserController::class,'profile']);
    Route::post('/change-password',[UserController::class,'changePassword']);
    Route::post('/update-profile',[UserController::class,'updateProfile']);
    Route::post('/add-gig',[GigController::class,'createGig']);
    Route::get('/orders',[OrderController::class,'getOrders']);
    Route::get('/orders/{id}',[OrderController::class,'getOrder']);
    Route::post('/approve-or-reject-order/{id}',[OrderController::class,'approveOrRejectOrder']);
    Route::post('/order-complete/{id}',[OrderController::class,'orderComplete']);
    Route::get('/payment-page',[OrderController::class,'getPaymentDetails']);
    Route::post('/add-coupons',[CouponsController::class,'addCoupons']);
    Route::post('/send-message',[ChatMessageController::class,'sendMessage']);
    Route::get('/fetch-messages',[ChatMessageController::class,'fetchMessages']);
});

Route::middleware('auth:api')->prefix("buyer")->group(function (){
    Route::post("/gig-listing",[GigController::class,'getBuyerGigsListing']);
    Route::post("/gig-listing/{id}",[GigController::class,'getGig']);
    Route::get('/seller/profile/{id}',[UserController::class,'getSellerProfile']);
    Route::post('/add-favourite/gig',[GigController::class,'addGigToFavourite']);
    Route::get('/get-favourite-gigs-listing',[GigController::class,'getFavouriteGigsListing']);
    Route::post('/delete-favourite-gig/{id}',[GigController::class,'deleteFavouriteGig']);
    Route::post('/order-gig',[GigController::class,'orderGig']);
    Route::get('/orders',[GigController::class,'orderHistory']);
    Route::get('/orders/{id}',[GigController::class,'getOrder']);
    Route::get('/get-coupons-response',[CouponsController::class,'getCouponsResponse']);
    Route::post('/send-message',[ChatMessageController::class,'sendMessage']);
    Route::get('/fetch-messages',[ChatMessageController::class,'fetchMessages']);
    Route::get('/order-sheet/{id}',[OrderController::class,'downloadOrderExcelSheet']);
});

Route::post('/test-payment',[\App\Http\Controllers\PayementTestController::class,'test']);
