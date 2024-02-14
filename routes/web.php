<?php

use App\Http\Controllers\ForgotPasswordController;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Controllers\ResetPasswordController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/forgot-password', [ForgotPasswordController::class, 'getForgotPassword'])
->middleware('guest')->name('password.request');

Route::post('/forgot-password', [ForgotPasswordController::class, 'postForgotPassword'])
->middleware('guest')->name('password.email');


Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'getResetPasswordToken'])->middleware('guest')->name('password.reset');


Route::post('/reset-password', [ForgotPasswordController::class, 'postResetPasswordToken'])->middleware('guest')->name('password.update');





// Route::get('/forgot-password', [ResetPasswordController::class, 'forgotPasswordLoad']);
// Route::post('/forgot-password', [ResetPasswordController::class, 'forgetPassword'])->name('forgot.email');

// Route::get('/reset-password', [ResetPasswordController::class, 'resetPasswordLoad']);
// Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword']);
