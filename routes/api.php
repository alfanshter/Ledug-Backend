<?php

use App\Http\Controllers\FiturController;
use App\Http\Controllers\MekanikController;
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

//============================== ENDMEKANIK ==================================//
