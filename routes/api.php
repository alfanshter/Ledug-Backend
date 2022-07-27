<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BayarBeliController;
use App\Http\Controllers\API\BeritaDesaController;
use App\Http\Controllers\API\BudayaLokalController;
use App\Http\Controllers\API\DesaTerdekatController;
use App\Http\Controllers\API\FasilitasDesaController;
use App\Http\Controllers\API\KegiatanDesaController;
use App\Http\Controllers\API\LadaController;
use App\Http\Controllers\API\LeafletMapController;
use App\Http\Controllers\API\PasarDesaController;
use App\Http\Controllers\API\PelatihanController;
use App\Http\Controllers\API\ProfilDesaController;
use App\Http\Controllers\API\TvccController;
use App\Http\Controllers\API\VersiController;
use App\Http\Controllers\API\WilayahController;
use App\Http\Controllers\UsersController;
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

//Route::post('/register', [UsersController::class, 'register']);
////API route for login user
//Route::post('/login', [UsersController::class, 'login']);


////Protecting Routes
//Route::group(['middleware' => ['auth:sanctum']], function () {
//    Route::get('/profile', function (Request $request) {
//        return auth()->user();
//    });

//    // API route for logout user
//    Route::post('/logout', [UsersController::class, 'logout']);
//});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/update_profil', [UsersController::class, 'update_profil'])->middleware('auth.apikey');;
Route::get('/profil/{id?}', [UsersController::class, 'profil']);
Route::get('/search_user/{email?}', [UsersController::class, 'search_user']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


//====== WILAYAH ======//
//localhost/api/ongkir
Route::get('/provinsi', [WilayahController::class, 'provinsi']);
Route::get('/kabupaten/{province_id?}', [WilayahController::class, 'kabupaten']);
Route::get('/kecamatan/{regency_id?}', [WilayahController::class, 'kecamatan']);
Route::get('/desa/{district_id?}', [WilayahController::class, 'desa']);
//====== End WILAYAH ==========//

//========== TVCC ==========//
Route::get('/tvcc', [TvccController::class, 'tvcc'])->middleware('auth.apikey');
Route::get('/lada', [LadaController::class, 'lada'])->middleware('auth.apikey');
Route::get('/bayarbeli', [BayarBeliController::class, 'bayarbeli'])->middleware('auth.apikey');
Route::get('/pasardesa', [PasarDesaController::class, 'pasardesa'])->middleware('auth.apikey');
//====== END TVCC ==========//

//======================== BERITA DESA===============================//
Route::get('/beritadesa/{id?}', [BeritaDesaController::class, 'beritadesa'])->middleware('auth.apikey');
Route::get('/beritadesa_popular/{id?}', [BeritaDesaController::class, 'beritadesa_popular'])->middleware('auth.apikey');
Route::post('/tambah_kunjungan_beritadesa/{id?}', [BeritaDesaController::class, 'tambah_kunjungan_beritadesa'])->middleware('auth.apikey');
//======================== END BERITA DESA============================//

//=========================== PROFIL DESA ==================================//
Route::get('/profildesa/{id?}', [ProfilDesaController::class, 'profildesa'])->middleware('auth.apikey');
//=========================== END PROFIL DESA===============================//

//=========================== FASILITAS DESA===============================//
Route::get('/fasilitasdesa/{id?}', [FasilitasDesaController::class, 'fasilitasdesa'])->middleware('auth.apikey');
//=========================== END FASILITAS DESA===============================//

//=========================== BUDAYA DESA===============================//
Route::get('/budayalokal/{id?}', [BudayaLokalController::class, 'budayalokal'])->middleware('auth.apikey');
//=========================== END BUDAYA DESA===============================//

//=========================== GEOSPASIAL DESA===============================//
Route::get('/geospasial/{id?}', [LeafletMapController::class, 'geospasial'])->middleware('auth.apikey');
//=========================== END GEOSPASIAL DESA===============================//

//=========================== DESA TERDEKAT===============================//
Route::get('/desa_terdekat/{id?}', [DesaTerdekatController::class, 'desa_terdekat'])->middleware('auth.apikey');
//=========================== END DESA TERDEKAT===============================//

//=========================== Kegiatan DESA===============================//
Route::get('/kegiatandesa/{id?}', [KegiatanDesaController::class, 'kegiatandesa'])->middleware('auth.apikey');
//=========================== END Kegiatan DESA===============================//

//=========================== PELATIHAN===============================//
Route::get('/pelatihan/{id?}', [PelatihanController::class, 'pelatihan'])->middleware('auth.apikey');
//=========================== END PELATIHAN===============================//

//====== Versi Aplikasi ======//
//localhost/api/versi
Route::get('/versiall', [VersiController::class, 'index']);
Route::post('/versi', [VersiController::class, 'insert']);
Route::post('/versi/{id}', [VersiController::class, 'update']);
Route::delete('/versi/{id}', [VersiController::class, 'delete']);
Route::get('/versi', [VersiController::class, 'detail']);
//====== End Versi ==========//