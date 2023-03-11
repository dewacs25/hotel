<?php

use App\Http\Controllers\AdminLogin;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\TransaceionController;
use Illuminate\Support\Facades\Auth;
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


Auth::routes(['verify' => true]);

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');
Route::get('/booking/{id}/{nama}',[DetailController::class,'index'])->middleware('verified');;
Route::post('/booking',[TransaceionController::class,'Simpan']);
Route::get('/transaksi',[HomeController::class,'transaksi'])->middleware('verified');
Route::get('/transaksi/{token}',[PaymentController::class,'index'])->middleware('verified');
Route::delete('/transaksi/{token}',[PaymentController::class,'cancel'])->middleware('verified');
Route::post('/ex',[HomeController::class,'ex']);
Route::post('/paymen-success',[PaymentController::class,'PaymentSuccess']);


Route::get('/admin',[DashboardController::class,'index'])->middleware('admin.auth');
Route::get('admin/auth/login',[AdminLogin::class,'login'])->name('admin.login');
Route::post('admin/auth/login',[AdminLogin::class,'login_action'])->name('admin.login.action');
Route::get('admin/auth/logout',[AdminLogin::class,'logoutAdmin'])->name('admin.logout');

Route::get('/admin/product',[ProductController::class,'index'])->middleware('admin.auth');
Route::get('/admin/product/tambah', function () {
    return view('admin/tambah/tambahProduct');
});
Route::post('/admin/product/tambah',[ProductController::class,'Tambah'])->name('tambah.product');
Route::get('admin/scan',[ScanController::class,'index'])->middleware('admin.auth');
Route::post('/validasi',[ScanController::class,'validasi'])->name('validasi');
Route::post('/validasi2',[ScanController::class,'validasiCheckOut'])->name('validasi2');

Route::get('/admin/scan/checkin',[ScanController::class,'CheckIn']);
Route::get('/admin/scan/checkout',[ScanController::class,'CheckOut']);


