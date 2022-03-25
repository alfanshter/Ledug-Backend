<?php

use App\Http\Controllers\BeritaAdminController;
use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\BeritaAdminController as WebBeritaAdminController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\LoginController;
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

Route::get('/', [DashboardController::class,'index'])->middleware('auth');

Route::get('/login', [LoginController::class,'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class,'authenticate']);
Route::post('/logout', [LoginController::class,'logout']);

Route::get('/register', [RegisterController::class,'index'])->middleware('guest');
Route::post('/register', [RegisterController::class,'store']);

//Admin
Route::get('/admin', [AdminController::class,'index'])->middleware('auth');
Route::post('/admin', [AdminController::class,'insert'])->middleware('auth');
Route::post('/admin/updateadmin', [AdminController::class,'update'])->middleware('auth');
Route::get('/admin/editadmin/{id}', [AdminController::class,'edit'])->middleware('auth');
Route::delete('/admin/hapusadmin/{id}', [AdminController::class,'destroy'])->middleware('auth');

//Berita
Route::get('/beritadesa', [WebBeritaAdminController::class,'index'])->middleware('auth');
Route::get('/beritadesa/{id}', [WebBeritaAdminController::class,'edit'])->middleware('auth');
Route::post('/beritadesa', [WebBeritaAdminController::class,'store'])->middleware('auth');
Route::post('/beritadesa/update', [WebBeritaAdminController::class,'update'])->middleware('auth');
Route::post('/beritadesa/delete', [WebBeritaAdminController::class,'delete'])->middleware('auth');

//TVCC
Route::get('/tvcc', [TvccAdminController::class,'index'])->middleware('auth');
Route::get('/tvcc/{id}', [TvccAdminController::class,'edit'])->middleware('auth');
Route::post('/tvcc', [TvccAdminController::class,'store'])->middleware('auth');
Route::post('/tvcc/update', [TvccAdminController::class,'update'])->middleware('auth');
Route::post('/tvcc/delete', [TvccAdminController::class,'delete'])->middleware('auth');

