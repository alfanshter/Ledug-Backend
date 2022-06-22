<?php

use App\Http\Controllers\BookingPesananController;
use App\Http\Controllers\FiturController;
use App\Http\Controllers\JobMekanikController;
use App\Http\Controllers\MekanikAdminController;
use App\Http\Controllers\MekanikController;
use App\Http\Controllers\MekanikFiturController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VersiController;
use App\Http\Controllers\WilayahController;
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

//====== Versi Aplikasi ======//
//localhost/api/versi
Route::get('/versiall', [VersiController::class, 'index']);
Route::post('/versi', [VersiController::class, 'insert']);
Route::post('/versi/{id}', [VersiController::class, 'update']);
Route::delete('/versi/{id}', [VersiController::class, 'delete']);
Route::get('/versi', [VersiController::class, 'detail']);
//====== End Versi ==========//


//====== WILAYAH ======//
//localhost/api/ongkir
Route::get('/provinsi', [WilayahController::class, 'provinsi'])->middleware('auth.apikey');
Route::get('/kabupaten/{province_id?}', [WilayahController::class, 'kabupaten']);
Route::get('/kecamatan/{regency_id?}', [WilayahController::class, 'kecamatan']);
Route::get('/desa/{district_id?}', [WilayahController::class, 'desa']);
//====== End WILAYAH ==========//

//============================== USER ==================================//
Route::get('/cek_user', [UsersController::class, 'cek_user'])->middleware('auth.apikey');
Route::post('/tambah_user', [UsersController::class, 'tambah_user'])->middleware('auth.apikey');
//============================== END USER ==================================//

//============================== Fitur ==================================//
Route::post('/tambah_fitur', [FiturController::class, 'tambah_fitur'])->middleware('auth.apikey');
Route::get('/get_fitur/{nama?}', [FiturController::class, 'get_fitur'])->middleware('auth.apikey');
//============================== END Fitur ==================================//
//============================== MEKANIK ==================================//
Route::post('/register', [MekanikController::class, 'register'])->middleware('auth.apikey');
Route::post('/loginmekanik', [MekanikController::class, 'loginmekanik']);
//============================== ENDMEKANIK ==================================//

//============================== Fitur Mekanik ==================================//
Route::post('/tambah_fitur_mekanik', [MekanikFiturController::class, 'tambah_fitur_mekanik'])->middleware('auth.apikey');
//============================== END Fitur Mekanik ==================================//

//============================== Job Mekanik ==================================//
Route::post('/aktifkan_pekerjaan', [JobMekanikController::class, 'aktifkan_pekerjaan'])->middleware('auth.apikey');
Route::post('/matikan_pekerjaan', [JobMekanikController::class, 'matikan_pekerjaan'])->middleware('auth.apikey');
Route::get('/cek_pekerjaan/{mekanik_uid?}', [JobMekanikController::class, 'cek_pekerjaan'])->middleware('auth.apikey');
//============================== END Job Mekanik ==================================//

//============================== Booking Pesanan ==================================//
Route::post('/cari_mekanik', [BookingPesananController::class, 'cari_mekanik'])->middleware('auth.apikey');
Route::post('/booking_mekanik', [BookingPesananController::class, 'booking_mekanik'])->middleware('auth.apikey');
Route::post('/batalkan_pesanan_user', [BookingPesananController::class, 'batalkan_pesanan_user'])->middleware('auth.apikey');
Route::get('/transaksi_user/{user_uid?}', [BookingPesananController::class, 'transaksi_user'])->middleware('auth.apikey');
Route::get('/tracking_user/{kode_pesanan?}', [BookingPesananController::class, 'tracking_user'])->middleware('auth.apikey');
//============================== END Booking Pesanan ==================================//

//============================== Admin Mekanik ==================================//
Route::post('/tambah_ppn', [MekanikAdminController::class, 'tambah_ppn'])->middleware('auth.apikey');
//============================== End Admin Mekanik ==================================//
