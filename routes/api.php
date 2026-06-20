<?php

use App\Http\Controllers\Api\Store\StoreController;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Lessons\LessonProgressController;
use App\Http\Controllers\Api\Points\PointsController;
use App\Http\Controllers\Api\Settings\ParentalController;
use App\Http\Controllers\Api\Store\AchievementController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\VerficationEmailController;
use App\Http\Controllers\Api\Games\GameController;
use App\Http\Controllers\Api\Lessons\LessonController;
use App\Http\Controllers\Api\Lessons\QuizController;
use App\Http\Controllers\Api\Auth\ProfileController;
use App\Http\Controllers\Api\Avatar\AvatarController;
use App\Http\Controllers\Api\Rewards\RewardController;
use App\Http\Controllers\Api\DailyGoals\DailyGoalController;
// use App\Http\Controllers\Api\AchievementController;
use App\Http\Controllers\Api\Notifications\NotificationController;
use App\Http\Controllers\Api\Settings\SettingController;
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

    Route::get('verfactionemail', [VerficationEmailController::class, 'verifyEmailToken']);
    Route::post('verify-email', [VerficationEmailController::class, 'verifyEmailOtp']);



    /*
    |--------------------------------------------------------------------------
    | Protected Routes (Kid / Parent / Admin)
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth:sanctum')->group(function () {

        //  Profile
        Route::prefix('profile')->group(function () {
            Route::get('/', [ProfileController::class, 'getProfile']);
            Route::put('/', [ProfileController::class, 'updateProfile']);
            Route::post('/change-password', [ProfileController::class, 'changePassword']);
            Route::delete('/delete-account', [ProfileController::class, 'deleteAccount']);
        });

        //  Games
        Route::prefix('games')->group(function () {
            Route::get('/', [GameController::class, 'index']);
            Route::post('/play', [GameController::class, 'play']);
            Route::get('/{game}', [GameController::class, 'show']);
        });


        //  Lessons & Quizzes
        Route::prefix('lessons')->group(function () {
            Route::get('/', [LessonController::class, 'index']);
            Route::get('/{id}', [LessonController::class, 'show']);
            Route::post('/progress', [LessonProgressController::class, 'update']);
            Route::get('/{id}/quizzes', [QuizController::class, 'byLesson']);
        });

        Route::prefix('quizzes')->group(function () {
            Route::get('/attempts', [QuizController::class, 'attempts']);
            Route::get('/{id}', [QuizController::class, 'show']);
            Route::post('/{id}/start', [QuizController::class, 'startAttempt']);
            Route::post('/{id}/submit', [QuizController::class, 'submitAttempt']);
        });

        //  Achievements
        Route::prefix('achievements')->group(function () {
            Route::get('/', [AchievementController::class, 'index']);
            Route::get('/my', [AchievementController::class, 'myAchievements']);
        });

        //  Daily Goals & Rewards
        Route::get('/daily-goals', [DailyGoalController::class, 'index']);
        Route::post('/daily-goals/{id}/complete', [DailyGoalController::class, 'complete']);
        Route::post('/daily-goals/{id}/progress', [DailyGoalController::class, 'progress']);
        Route::get('/rewards', [RewardController::class, 'index']);
        Route::post('/rewards/{id}/claim', [RewardController::class, 'claim']);

        //  Points & Store
        Route::get('/points', [PointsController::class, 'index']);
        Route::get('/store', [StoreController::class, 'index']);
        Route::post('/store/{id}/purchase', [StoreController::class, 'purchase']);

        //  Notifications
        Route::get('/notifications', [NotificationController::class, 'index']);
        Route::post('/notifications/read', [NotificationController::class, 'markAsRead']);

        //  Settings & Parental Controls
        Route::get('/settings', [SettingController::class, 'index']);
        Route::put('/settings', [SettingController::class, 'update']);
        Route::get('/parental-controls', [ParentalController::class, 'index']);
        Route::put('/parental-controls/{kid}', [ParentalController::class, 'update']);

        // Avatar Shop
        Route::prefix('avatars')->group(function () {
            Route::get('/', [AvatarController::class, 'index']);
            Route::get('/owned', [AvatarController::class, 'owned']);
            Route::post('/{avatar}/buy', [AvatarController::class, 'buy']);
            Route::post('/{avatar}/select', [AvatarController::class, 'select']);
        });
    });
});

