<?php

use App\Http\Controllers\API\AUTH\AuthController;
use App\Http\Controllers\API\AUTH\ForgetPasswordController;
use App\Http\Middleware\setLang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::group(['middleware' => setLang::class], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('resend-otp-register', [AuthController::class, 'resendOtpRegister']);
    Route::post('forget-password', [ForgetPasswordController::class, 'forgetPassword']);
    Route::post('verify-otp-forget-password', [ForgetPasswordController::class, 'verifyOtp']);
    Route::post('reset-password', [ForgetPasswordController::class, 'resetPassword']);
    Route::post('refresh-token', [AuthController::class, 'refreshToken']);
    Route::post('resend-otp-forget-password', [ForgetPasswordController::class, 'resendOtpForgetPassword']);
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('show-profile', [AuthController::class, 'showProfile']);
        Route::put('update-profile', [AuthController::class, 'updateProfile']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});