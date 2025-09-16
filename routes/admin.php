<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Mails\VerficationEmailController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/signin', [AuthController::class, 'signin'])->name('signin');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// otp
Route::get('verfactionemail/{token}', [VerficationEmailController::class, 'verficationemailpage'])->name('verficationemailpage');
Route::post('verify-email', [VerficationEmailController::class, 'verifyemail'])->name('verifyemail');
