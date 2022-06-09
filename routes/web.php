<?php

use App\Http\Controllers\Web\BannerController;
use App\Http\Controllers\BeritaAdminController;
use App\Http\Controllers\PasardesaController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\BayarBeliController;
use App\Http\Controllers\Web\BeritaAdminController as WebBeritaAdminController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\DataStatistikDesaController;
use App\Http\Controllers\Web\GambarDesaController;
use App\Http\Controllers\Web\IndoRegionController;
use App\Http\Controllers\Web\LadaController;
use App\Http\Controllers\Web\LoginController;
use App\Http\Controllers\Web\MultiDesaController;
use App\Http\Controllers\Web\ProfilDesaController;
use App\Http\Controllers\Web\RegisterController;
use App\Http\Controllers\Web\TvccAdminController;
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

Route::get('/', [DashboardController::class, 'index'])->middleware('auth');

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);

//============================Admin==================================
//superadmin
Route::get('/admin', [AdminController::class, 'index'])->middleware('superadmin');
Route::post('/admin', [AdminController::class, 'insert'])->middleware('superadmin');
Route::post('/admin/updateadmin', [AdminController::class, 'update'])->middleware('superadmin');
Route::get('/admin/editadmin/{id}', [AdminController::class, 'edit'])->middleware('superadmin');
Route::delete('/admin/hapusadmin/{id}', [AdminController::class, 'destroy'])->middleware('superadmin');

//============================End Admin==================================

//============================Berita==================================
//superadmin
Route::get('/beritadesa', [WebBeritaAdminController::class, 'index'])->middleware('superadmin');
Route::get('/beritadesa/{id}', [WebBeritaAdminController::class, 'edit'])->middleware('superadmin');
Route::post('/beritadesa', [WebBeritaAdminController::class, 'store'])->middleware('superadmin');
Route::post('/beritadesa/update', [WebBeritaAdminController::class, 'update'])->middleware('superadmin');
Route::post('/beritadesa/delete', [WebBeritaAdminController::class, 'delete'])->middleware('superadmin');
//admin
//============================END Berita==================================
Route::get('/beritadesa_admin', [WebBeritaAdminController::class, 'index_admin'])->middleware('admin');
//TVCC
Route::get('/tvcc', [TvccAdminController::class, 'index'])->middleware('superadmin');
Route::get('/tvcc/{id}', [TvccAdminController::class, 'edit'])->middleware('superadmin');
Route::post('/tvcc', [TvccAdminController::class, 'store'])->middleware('superadmin');
Route::post('/tvcc/update', [TvccAdminController::class, 'update'])->middleware('superadmin');
Route::post('/tvcc/delete', [TvccAdminController::class, 'delete'])->middleware('superadmin');

//RegionController
Route::post('/getkabupaten', [IndoRegionController::class, 'getkabupaten'])->name('getkabupaten');
Route::post('/getkecamatan', [IndoRegionController::class, 'getkecamatan'])->name('getkecamatan');
Route::post('/getdesa', [IndoRegionController::class, 'getdesa'])->name('getdesa');
Route::post('/getkabupaten_on', [IndoRegionController::class, 'getkabupaten_on'])->name('getkabupaten_on');
Route::post('/getkecamatan_on', [IndoRegionController::class, 'getkecamatan_on'])->name('getkecamatan_on');
Route::post('/getdesa_on', [IndoRegionController::class, 'getdesa_on'])->name('getdesa_on');


//MultiDsa
Route::get('/multidesa', [MultiDesaController::class, 'index'])->name('multidesa.index')->middleware('superadmin');
Route::post('/multidesa', [MultiDesaController::class, 'store'])->name('multidesa.store')->middleware('superadmin');
Route::post('/tvcc/delete', [TvccAdminController::class, 'delete'])->middleware('superadmin');
Route::post('/delete_multidesa', [MultiDesaController::class, 'destroy'])->middleware('superadmin');

//LADA
Route::get('/lada', [LadaController::class, 'index'])->middleware('superadmin');
Route::get('/lada/{id}', [LadaController::class, 'edit'])->middleware('superadmin');
Route::post('/lada', [LadaController::class, 'store'])->middleware('superadmin');
Route::post('/lada/update', [LadaController::class, 'update'])->middleware('superadmin');
Route::post('/lada/delete', [LadaController::class, 'delete'])->middleware('superadmin');

//Bayar/Beli
Route::get('/bayarbeli', [BayarBeliController::class, 'index'])->middleware('superadmin');
Route::get('/bayarbeli/{id}', [BayarBeliController::class, 'edit'])->middleware('superadmin');
Route::post('/bayarbeli', [BayarBeliController::class, 'store'])->middleware('superadmin');
Route::post('/bayarbeli/update', [BayarBeliController::class, 'update'])->middleware('superadmin');
Route::post('/bayarbeli/delete', [BayarBeliController::class, 'delete'])->middleware('superadmin');

//PasarDesa
Route::get('/pasardesa', [PasardesaController::class, 'index'])->middleware('superadmin');
Route::get('/pasardesa/{id}', [PasardesaController::class, 'edit'])->middleware('superadmin');
Route::post('/pasardesa', [PasardesaController::class, 'store'])->middleware('superadmin');
Route::post('/pasardesa/update', [PasardesaController::class, 'update'])->middleware('superadmin');
Route::post('/pasardesa/delete', [PasardesaController::class, 'delete'])->middleware('superadmin');

//============================Banner==================================
Route::get('/banner_admin', [BannerController::class, 'index_admin'])->middleware('admin');
Route::post('/banner_admin', [BannerController::class, 'tambahbanner_admin'])->middleware('admin');
Route::post('/update_banner_admin', [BannerController::class, 'update_banner_admin'])->middleware('admin');
Route::post('/hapusbanner_admin', [BannerController::class, 'hapusbanner_admin'])->middleware('admin');
//============================END Banner==================================

//============================Profile==================================
Route::get('/profil_admin', [AdminController::class, 'profil_admin'])->middleware('admin');
Route::post('/edit_profil_admin', [AdminController::class, 'edit_profil_admin'])->middleware('admin');
//============================End Profile==================================

//============================Profile Desa==================================
//profil
Route::get('/profildesa', [ProfilDesaController::class, 'profil'])->middleware('admin');
Route::post('/update_profildesa', [ProfilDesaController::class, 'update_profildesa'])->middleware('admin');
//gambardesa
Route::get('/gambardesa', [GambarDesaController::class, 'index_admin'])->middleware('admin');
Route::post('/tambah_gambardesa', [GambarDesaController::class, 'tambah_gambardesa'])->middleware('admin');
//Data statistik
Route::get('/datastatistik_desa', [DataStatistikDesaController::class, 'index_admin'])->middleware('admin');
Route::post('/tambah_datastatistik_desa', [DataStatistikDesaController::class, 'tambah_data'])->middleware('admin');

//============================End Profile==================================
