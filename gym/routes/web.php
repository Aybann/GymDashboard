<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/{path}', function(){
//     return view('app');
// })->where('path', "([A-z\d\-/_.]+)?");

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

//qr routes
// Route::get('qrcode', [App\Http\Controllers\QRController::class, 'generateQrCode']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');