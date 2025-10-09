<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DailyGoals\DailyGoalController;
use App\Http\Controllers\Admin\Games\GameController;
use App\Http\Controllers\Admin\Games\GameKidController;
use App\Http\Controllers\Admin\Kids\KidAchievementController;
use App\Http\Controllers\Admin\Kids\KidController;
use App\Http\Controllers\Admin\Kids\KidLessonProgressController;
use App\Http\Controllers\Admin\Kids\KidSessionController;
use App\Http\Controllers\Admin\Kids\OtpController;
use App\Http\Controllers\Admin\Kids\ParentChildController;
use App\Http\Controllers\Admin\Lessons\LessonController;
use App\Http\Controllers\Admin\Lessons\QuestionController;
use App\Http\Controllers\Admin\Lessons\QuizAnswerController;
use App\Http\Controllers\Admin\Lessons\QuizAttemptController;
use App\Http\Controllers\Admin\Lessons\QuizController;
use App\Http\Controllers\Admin\Notifications\NotificationController;
use App\Http\Controllers\Admin\Points\PointsTransactionController;
use App\Http\Controllers\Admin\Points\AchievementController;
use App\Http\Controllers\Admin\Rewards\RewardController;
use App\Http\Controllers\Admin\Settings\ParentalControlController;
use App\Http\Controllers\Admin\Settings\UserSettingController;
use App\Http\Controllers\Admin\Store\PurchaseController;
use App\Http\Controllers\Admin\Store\StoreItemController;
use App\Http\Controllers\Admin\Users\AvatarController;
use App\Http\Controllers\Admin\Users\RoleController;
use App\Http\Controllers\Admin\Users\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Mails\VerficationEmailController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'index'])->name('index');

    // Acount
    Route::prefix('account')->name('account.')->group(function () {
        Route::get('/', [AdminController::class, 'profile'])->name('profile');
        Route::post('/update', [AdminController::class, 'update']);
        Route::post('/delete', [AdminController::class, 'delete']);
        Route::post('/password/change', [AdminController::class, 'change_password'])->name('change_password'); ;
    });

    // Users
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('avatars', AvatarController::class);

    // Kids
    Route::resource('kids', KidController::class);
    Route::resource('parent-children', ParentChildController::class);
    Route::resource('kid-achievements', KidAchievementController::class);
    Route::resource('kid-lesson-progresses', KidLessonProgressController::class);
    Route::resource('kid-sessions', KidSessionController::class);
    Route::resource('otps', OtpController::class);

    // Games
    Route::resource('games', GameController::class);
    Route::resource('game-kids', GameKidController::class);

    // Daily Goals
    Route::resource('daily-goals', DailyGoalController::class);

    // Rewards
    Route::resource('rewards', RewardController::class);

    // Store
    Route::resource('store-items', StoreItemController::class);
    Route::resource('purchases', PurchaseController::class);

    // Lessons & Quizzes
    Route::resource('lessons', LessonController::class);
    Route::resource('quizzes', QuizController::class);
    Route::resource('questions', QuestionController::class);
    Route::resource('quiz-attempts', QuizAttemptController::class);
    Route::resource('quiz-answers', QuizAnswerController::class);

    // Points & Achievements
    Route::resource('points-transactions', PointsTransactionController::class);
    Route::resource('achievements', AchievementController::class);

    // Notifications & Settings
    Route::resource('notifications', NotificationController::class);
    Route::resource('user-settings', UserSettingController::class);
    Route::resource('parental-controls', ParentalControlController::class);
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/signin', [AuthController::class, 'signin'])->name('signin');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// otp
Route::get('verfactionemail/{token}', [VerficationEmailController::class, 'verficationemailpage'])->name('verficationemailpage');
Route::post('verify-email', [VerficationEmailController::class, 'verifyemail'])->name('verifyemail');
