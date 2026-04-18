<?php

use App\Http\Controllers\API\AUTH\AuthController;
use App\Http\Controllers\API\AUTH\ForgetPasswordController;
use App\Http\Controllers\API\AvaliableController;
use App\Http\Controllers\API\BannerController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\BookingMonthlyController;
use App\Http\Controllers\API\BranchController;
use App\Http\Controllers\API\callUsController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\CVProfileController;
use App\Http\Controllers\API\DayController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\PageController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\SettingController;
use App\Http\Middleware\CheckSpecialist;
use App\Http\Middleware\CheckUser;
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
    // Review Routes
    Route::get('reviews', [ReviewController::class, 'index']);
    Route::post('create review', [ReviewController::class, 'store'])->middleware(['auth:sanctum', CheckUser::class]);
    // Day Routes
    Route::get('days', [DayController::class, 'index']);
    // Available Time Routes
    Route::get('available-times', [AvaliableController::class, 'index']);
    //fcm Tokens
    Route::post('fcm-token', [NotificationController::class, 'sendToken']);
    Route::post('fcm-token-user', [NotificationController::class, 'sendToken'])->middleware(['auth:sanctum', CheckUser::class]);
    Route::post('send-notification-to-guests', [NotificationController::class, 'sendNotificationToGuests']);
    Route::post('send-test-notification-to-users', [NotificationController::class, 'sendTestNotificationToUsers']);

    // Booking Routes (For Parents/Users)
    Route::group(['middleware' => ['auth:sanctum', CheckUser::class]], function () {
        Route::get('bookings', [BookingController::class, 'index']);
        Route::post('make-bookings', [BookingController::class, 'store']);
        Route::post('make-bookings-monthly', [BookingController::class, 'storeMonthly']);
        Route::post('monthly-booking-details', [BookingMonthlyController::class, 'getDetails']);
    });

    // Special Specialist Routes (For Doctors Only)
    Route::group(['middleware' => ['auth:sanctum', CheckSpecialist::class]], function () {
        Route::get('all-bookings', [BookingController::class, 'getAllBookings']);
        // أضف هنا مسارات الجلسات وما يخص الدكاترة فقط
    });

    // Auth Sanctum Routes (General Profile Management)
    Route::group(['middleware' => ['auth:sanctum', CheckUser::class]], function () { 
        Route::get('show-profile', [AuthController::class, 'showProfile']);
        Route::put('update-profile', [AuthController::class, 'updateProfile']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});
