<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CanboController;

use App\Http\Controllers\ApiResources\ApiNganhController;
use App\Http\Controllers\ApiResources\ApiDanTocController;
use App\Http\Controllers\QuanLyHoSoXetTuyen\HoSoXetTuyenController;

use App\Http\Controllers\XetTuyenClient\XetTuyenClientController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
//Ho so xet tuyen
Route::prefix('ho-so')->group(function () {
    Route::apiResource('xet-tuyen', HoSoXetTuyenController::class)->except('store');
    Route::get('trung-tuyen', [HoSoXetTuyenController::class, 'trungTuyen']);
    Route::get('report-thang/{year}', [HoSoXetTuyenController::class, 'reportThang']);
    Route::get('report-nganh', [HoSoXetTuyenController::class, 'reportNganh']);
    Route::get('report-nam', [HoSoXetTuyenController::class, 'reportNam']);
    Route::put('update-trang-thai', [HoSoXetTuyenController::class, 'trangThaiHoSo']);
    Route::post('gui-email', [HoSoXetTuyenController::class, 'sendEmail']);
});
//Tra cuu
Route::get('tra-cuu/ho-so', [XetTuyenClientController::class, 'traCuuHoSo']);
//Xet tuyen client
Route::post('xet-tuyen/ho-so', [XetTuyenClientController::class, 'nopHoSoXetTuyenClient']);
//API-Nganh
Route::get('nganh', [ApiNganhController::class, 'getNganh']);
//API-Dan-Toc
Route::get('dan-toc', [ApiDanTocController::class, 'getDanToc']);

// Api admin
Route::prefix('auth')->middleware('api')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::get('profile', [AuthController::class, 'profile']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
});

// api can bo
Route::prefix('canbo')->middleware('api')->group(function () {
    Route::post('login', [CanboController::class, 'login']);
    Route::get('profile', [CanboController::class, 'profile']);
    Route::post('logout', [CanboController::class, 'logout']);
    Route::post('refresh', [CanboController::class, 'refresh']);
});
