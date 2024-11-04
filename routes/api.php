<?php

use App\Http\Controllers\api\ContactController;
use App\Http\Controllers\api\HomePageController;
use App\Http\Controllers\api\NotificationController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\TransactionController;
use App\Http\Controllers\api\UserProfileController;
use App\Http\Controllers\api\WalletController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $user = User::where('id', $request->user()->id)->with('wallet')->first();
    return $user;
});
Route::get('locale/{locale}', function ($locale) {
    session()->put('locale', $locale); //mm or en
    return 'success';
});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('forgetPassword', [UserProfileController::class, 'changePassword']);
    Route::post('editProfile', [UserProfileController::class, 'editProfile']);
    // cart and order
    Route::post('addToCart', [OrderController::class, 'addToCart']);
    Route::get('cartCount/{id}', [OrderController::class, 'cartCount']);
    Route::get('cart/{id}', [OrderController::class, 'cart']);
    Route::get('addQty/{id}', [OrderController::class, 'addQty']);
    Route::get('removeQty/{id}', [OrderController::class, 'removeQty']);
    Route::get('deleteCart', [OrderController::class, 'deleteCart']);
    Route::post('order', [OrderController::class, 'order']);
    Route::get('order', [OrderController::class, 'orderData']);
    // wallet
    Route::get('checkPhone', [WalletController::class, 'checkPhone']);
    Route::post('transferWithPhone', [WalletController::class, 'transferWithPhone']);
    Route::post('addMoney', [WalletController::class, 'addMoney']);
    Route::get('transferUser/{phone}', [WalletController::class, 'transferUser']);
    Route::get('transactions', [TransactionController::class, 'transaction']);
    Route::get('transaction/{id}', [TransactionController::class, 'transactionDetail']);
    // notification
    Route::get('notifications/{id}', [NotificationController::class, 'notifications']);
    Route::get('notification', [NotificationController::class, 'notification']);
    // review
    Route::post('review', [HomePageController::class, 'review']);
    Route::get('getReview/{id}', [HomePageController::class, 'getReview']);
    // contact
    Route::apiResource('contact', ContactController::class);
});
// home page
Route::get('products', [HomePageController::class, 'allProduct']);
Route::get('color', [HomePageController::class, 'color']);
Route::get('brand', [HomePageController::class, 'brand']);
Route::get('onSale', [HomePageController::class, 'onSale']);
Route::get('new', [HomePageController::class, 'new']);
Route::get('view', [HomePageController::class, 'view']);
Route::get('category', [HomePageController::class, 'category']);
Route::get('product/{id}', [HomePageController::class, 'eachProduct']);
Route::get('productList', [HomePageController::class, 'productList']);
