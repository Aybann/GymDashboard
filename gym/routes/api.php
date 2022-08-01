<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('qrcode/{id}', [App\Http\Controllers\QRController::class, 'generateQrCode']);

//Customer routes
Route::get('customer/index', [App\Http\Controllers\CustomerController::class, 'index']);
Route::get('customer/{id}', [App\Http\Controllers\CustomerController::class, 'find']);
Route::get('customer/getCustomer/{id}', [App\Http\Controllers\CustomerController::class, 'getCustomer']);
Route::get('customer/getCustomerSubcription/{id}', [App\Http\Controllers\CustomerController::class, 'getCustomerSubcription']);
Route::post('customer/create', [App\Http\Controllers\CustomerController::class, 'create']);
Route::post('customer/create/customer/payment/{id}', [App\Http\Controllers\CustomerController::class, 'createPayment']);  
Route::post('customer/create/customer/subscription/{id}', [App\Http\Controllers\CustomerController::class, 'createSubscription']); 
Route::put('customer/update/{id}', [App\Http\Controllers\CustomerController::class, 'update']);
Route::delete('customer/delete/{id}', [App\Http\Controllers\CustomerController::class, 'delete']);

//Equipments routes
Route::get('equipment/index', [App\Http\Controllers\EquipmentController::class, 'index']);
Route::get('equipment/{id}', [App\Http\Controllers\EquipmentController::class, 'find']);
Route::post('equipment/create', [App\Http\Controllers\EquipmentController::class, 'create']);
Route::put('equipment/update/{id}', [App\Http\Controllers\EquipmentController::class, 'update']);
Route::delete('equipment/delete/{id}', [App\Http\Controllers\EquipmentController::class, 'delete']);

//payments routes
Route::get('payment/index', [App\Http\Controllers\PaymentController::class, 'index']);
Route::get('payment/{id}', [App\Http\Controllers\PaymentController::class, 'find']);
Route::get('payment/hasPaid/{id}', [App\Http\Controllers\PaymentController::class, 'hasPaid']);
Route::get('payment/getSales', [App\Http\Controllers\PaymentController::class, 'getSales']);
Route::post('payment/create', [App\Http\Controllers\PaymentController::class, 'create']);
Route::put('payment/update/{id}', [App\Http\Controllers\PaymentController::class, 'update']);
Route::delete('payment/delete/{id}', [App\Http\Controllers\PaymentController::class, 'delete']);


//subscription routes
Route::get('subscription/index', [App\Http\Controllers\SubscriptionController::class, 'index']);
Route::get('subscription/{id}', [App\Http\Controllers\SubscriptionController::class, 'find']);
Route::get('subscription/hasSubscription/{id}', [App\Http\Controllers\SubscriptionController::class, 'hasSubscription']);
Route::get('subscription/getSubscription/{id}', [App\Http\Controllers\SubscriptionController::class, 'getSubscription']);
Route::post('subscription/create', [App\Http\Controllers\SubscriptionController::class, 'create']);
Route::put('subscription/update/{id}', [App\Http\Controllers\SubscriptionController::class, 'update']);
Route::delete('subscription/delete/{id}', [App\Http\Controllers\SubscriptionController::class, 'delete']);
