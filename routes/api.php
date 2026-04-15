<?php

use App\Http\Controllers\API\AUTH\AuthController;
use App\Http\Controllers\API\AUTH\ForgetPasswordController;
use App\Http\Controllers\API\BannerController;
use App\Http\Controllers\API\BranchController;
use App\Http\Controllers\API\callUsController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\CVProfileController;
use App\Http\Controllers\API\PageController;
use App\Http\Controllers\API\SettingController;
use App\Http\Middleware\setLang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::group(['middleware' => setLang::class], function () {
    // Auth Routes
    Route::post('register', [AuthController::class, 'register']);
    Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('auth/firebase/google', [AuthController::class, 'firebaseGoogleLogin']);
    Route::post('resend-otp-register', [AuthController::class, 'resendOtpRegister']);
    Route::post('forget-password', [ForgetPasswordController::class, 'forgetPassword']);
    Route::post('resend-otp-forget-password', [ForgetPasswordController::class, 'resendOtpForgetPassword']);
    Route::post('verify-otp-forget-password', [ForgetPasswordController::class, 'verifyOtp']);
    Route::post('reset-password', [ForgetPasswordController::class, 'resetPassword']);
    Route::post('refresh-token', [AuthController::class, 'refreshToken']);
    // Banner Routes
    Route::get('banners', [BannerController::class, 'index']);
    Route::post('banners', [BannerController::class, 'store']);
    // Contact Routes
    Route::post('contacts', [ContactController::class, 'store']);
    // Page Routes
    Route::get('pages', [PageController::class, 'index']);
    // CV Profile Routes
    Route::get('cv-profile', [CVProfileController::class, 'getCvProfile']);
    // Settings Routes
    Route::get('settings', [SettingController::class, 'index']);
    // Branch Routes
    Route::get('branches', [BranchController::class, 'getBranches']);
    // Call Us Routes
    Route::get('call-us', [callUsController::class, 'index']);
    // Auth Sanctum Routes
    Route::group(['middleware' => 'auth:sanctum'], function () { 
        Route::get('show-profile', [AuthController::class, 'showProfile']);
        Route::put('update-profile', [AuthController::class, 'updateProfile']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});
