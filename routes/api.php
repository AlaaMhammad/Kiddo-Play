<?php

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\QuizController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\RewardController;
use App\Http\Controllers\Api\DailyGoalController;
use App\Http\Controllers\Api\AchievementController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\OtpController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/*
|--------------------------------------------------------------------------
| Public Routes (Guest)
|--------------------------------------------------------------------------
*/
// Route::get('/home', [HomeController::class, 'index']);
// Route::get('/about', [HomeController::class, 'about']);
// Route::get('/contact', [HomeController::class, 'contact']);
// Route::get('/games/preview', [GameController::class, 'preview']);
// Route::get('/lessons/sample', [LessonController::class, 'sample']);

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
// Route::post('/verify-otp', [OtpController::class, 'verify']);
Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');



    /*
    |--------------------------------------------------------------------------
    | Protected Routes (Kid / Parent / Admin)
    |--------------------------------------------------------------------------
    */
    // Route::middleware('auth:sanctum')->group(function () {

    //     // Profile & Settings
    //     Route::get('/profile', [ProfileController::class, 'show']);
    //     Route::put('/profile', [ProfileController::class, 'update']);
    //     Route::get('/settings', [SettingController::class, 'index']);
    //     Route::put('/settings', [SettingController::class, 'update']);

    //     // Games
    //     Route::get('/games', [GameController::class, 'index']);
    //     Route::post('/games/play', [GameController::class, 'play']);
    //     Route::get('/games/{id}', [GameController::class, 'show']);

    //     // Lessons & Quizzes
    //     Route::get('/lessons', [LessonController::class, 'index']);
    //     Route::get('/quizzes', [QuizController::class, 'index']);
    //     Route::post('/quizzes/{id}/submit', [QuizController::class, 'submit']);

    //     // Daily Goals & Achievements
    //     Route::get('/daily-goals', [DailyGoalController::class, 'index']);
    //     Route::get('/achievements', [AchievementController::class, 'index']);

    //     // Rewards & Store
    //     Route::get('/rewards', [RewardController::class, 'index']);
    //     Route::post('/rewards/claim', [RewardController::class, 'claim']);

    //     // Notifications
    //     Route::get('/notifications', [NotificationController::class, 'index']);
    //     Route::post('/notifications/read', [NotificationController::class, 'markAsRead']);
    // });
});

