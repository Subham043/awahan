<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RefreshController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ResendOTPController;
use App\Http\Controllers\Auth\VerifyUserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ProfileUpdateController;
use App\Http\Controllers\Auth\PasswordUpdateController;

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

Route::group(['middleware' => ['cors', 'json.response']], function () {

    Route::prefix('/auth')->group(function () {
        Route::group(['middleware' => 'throttle:3,1'], function () {
            Route::post('/login', [LoginController::class, 'login', 'as' => 'login']);
            Route::post('/admin-login', [AdminLoginController::class, 'login', 'as' => 'login']);
            Route::post('/verify-user/{user_id}', [VerifyUserController::class, 'verify_user', 'as' => 'verify_user']);
            Route::post('/reset-password/{user_id}', [ResetPasswordController::class, 'reset_password', 'as' => 'reset_password']);
            Route::get('/resend-otp/{user_id}', [ResendOTPController::class, 'send_otp', 'as' => 'send_otp']);
        });
        Route::post('/register', [RegisterController::class, 'register', 'as' => 'register']);
        Route::post('/forgot-password', [ForgotPasswordController::class, 'forgot_password', 'as' => 'forgot_password']);
        Route::group(['middleware' => ['auth:api','has.access']], function () {
            Route::get('/refresh', [RefreshController::class, 'refresh', 'as' => 'refresh']);
            Route::get('/profile', [ProfileController::class, 'profile', 'as' => 'profile']);
            Route::post('/profile-update', [ProfileUpdateController::class, 'profile_update', 'as' => 'profile_update']);
            Route::post('/password-update', [PasswordUpdateController::class, 'password_update', 'as' => 'password_update']);
            Route::get('/logout', [LogoutController::class, 'logout', 'as' => 'logout']);
        });
    });
});