<?php


use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Mails\VerficationEmailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Users\UserController;
use App\Http\Controllers\Admin\Users\RoleController;
use App\Http\Controllers\Admin\AvatarController;
use App\Http\Controllers\Admin\Kids\{
    KidController,
    ParentChildController,
    KidAchievementController,
    KidLessonProgressController,
    KidSessionController,
    OtpController
};
use App\Http\Controllers\Admin\Games\{
    GameController,
    GameKidController
};
use App\Http\Controllers\Admin\DailyGoals\DailyGoalController;
use App\Http\Controllers\Admin\Rewards\RewardController;
use App\Http\Controllers\Admin\Store\{
    StoreItemController,
    PurchaseController
};
use App\Http\Controllers\Admin\Lessons\{
    LessonController,
    QuizController,
    QuestionController,
    QuizAttemptController,
    QuizAnswerController
};
use App\Http\Controllers\Admin\Points\{
    PointsTransactionController,
    AchievementController
};
use App\Http\Controllers\Admin\Notifications\NotificationController;
use App\Http\Controllers\Admin\Settings\{
    UserSettingController,
    ParentalControlController
};

use App\Http\Controllers\ParentApp\{
    ParentDashboardController,
    ParentChildController as ParentAppChildController,
    ParentControlController,
    ParentReportController,
    ParentSessionController,
    ParentSettingController,
    ParentNotificationController
};
use App\Http\Controllers\KidApp\{
    KidDashboardController,
    KidLessonController,
    KidQuizController,
    KidAttemptController,
    KidStoreController,
    KidPurchaseController,
    KidRewardController,
    KidGoalController,
    KidAchievementController as KidAppAchievementController,
    KidNotificationController,
    KidProfileController
};
use App\Http\Controllers\Guest\HomeController;


// Route::middleware(['isAuth'])->prefix('admin')->name('admin.')->group(function () {
//     // Dashboard
//     Route::get('/', [AdminController::class, 'index'])->name('index');

//     // Acount
//     Route::prefix('account')->name('account.')->group(function () {
//         Route::get('/', [AdminController::class, 'profile'])->name('profile');
//         Route::post('/update', [AdminController::class, 'update']);
//         Route::post('/delete', [AdminController::class, 'delete']);
//         Route::post('/password/change', [AdminController::class, 'change_password'])->name('change_password');;
//     });

//     // Users
//     Route::resource('users', UserController::class);
//     Route::resource('roles', RoleController::class);
//     Route::resource('avatars', AvatarController::class);

//     // Kids
//     Route::resource('kids', KidController::class);
//     Route::resource('parent-children', ParentChildController::class);
//     Route::resource('kid-achievements', KidAchievementController::class);
//     Route::resource('kid-lesson-progresses', KidLessonProgressController::class);
//     Route::resource('kid-sessions', KidSessionController::class);
//     Route::resource('otps', OtpController::class);

//     // Games
//     Route::resource('games', GameController::class);
//     Route::resource('game-kids', GameKidController::class);

//     // Daily Goals
//     Route::resource('daily-goals', DailyGoalController::class);

//     // Rewards
//     Route::resource('rewards', RewardController::class);

//     // Store
//     Route::resource('store-items', StoreItemController::class);
//     Route::resource('purchases', PurchaseController::class);

//     // Lessons & Quizzes
//     Route::resource('lessons', LessonController::class);
//     Route::resource('quizzes', QuizController::class);
//     Route::resource('questions', QuestionController::class);
//     Route::resource('quiz-attempts', QuizAttemptController::class);
//     Route::resource('quiz-answers', QuizAnswerController::class);

//     // Points & Achievements
//     Route::resource('points-transactions', PointsTransactionController::class);
//     Route::resource('achievements', AchievementController::class);

//     // Notifications & Settings
//     Route::resource('notifications', NotificationController::class);
//     Route::resource('user-settings', UserSettingController::class);
//     Route::resource('parental-controls', ParentalControlController::class);

//     Route::middleware('role:parent')->group(function () {

//         // Kids
//         Route::resource('kids', KidController::class)->only(['index', 'show', 'edit', 'update']);
//         Route::resource('kid-achievements', KidAchievementController::class)->only(['index', 'show']);
//         Route::resource('kid-lesson-progresses', KidLessonProgressController::class)->only(['index', 'show']);
//         Route::resource('kid-sessions', KidSessionController::class)->only(['index', 'show']);
//         // Games & Goals
//         Route::resource('games', GameController::class)->only(['index', 'show']);
//         Route::resource('game-kids', GameKidController::class)->only(['index', 'show']);
//         Route::resource('daily-goals', DailyGoalController::class)->only(['index', 'show']);

//         // Rewards & Store
//         Route::resource('rewards', RewardController::class)->only(['index', 'show']);
//         Route::resource('store-items', StoreItemController::class)->only(['index', 'show']);
//         Route::resource('purchases', PurchaseController::class)->only(['index', 'show']);

//         // Education
//         Route::resource('lessons', LessonController::class)->only(['index', 'show']);
//         Route::resource('quizzes', QuizController::class)->only(['index', 'show']);
//         Route::resource('questions', QuestionController::class)->only(['index', 'show']);
//         Route::resource('quiz-attempts', QuizAttemptController::class)->only(['index', 'show']);
//         Route::resource('quiz-answers', QuizAnswerController::class)->only(['index', 'show']);

//         // Gamification
//         Route::resource('points-transactions', PointsTransactionController::class)->only(['index']);
//         Route::resource('achievements', AchievementController::class)->only(['index']);
//     });
// });

// Auth
Route::get('/login', [AuthController::class, 'login'])->name('login');


/*
|--------------------------------------------------------------------------
| Guest Routes (الزائر)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->name('guest.')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/about', [HomeController::class, 'about'])->name('about');
    Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
    Route::get('/games/preview', [HomeController::class, 'gamePreview'])->name('games.preview');
    Route::get('/lessons/sample', [HomeController::class, 'lessonSample'])->name('lessons.sample');
});

/*
    |--------------------------------------------------------------------------
    | Kid && Parent && Admin Routes
    |--------------------------------------------------------------------------
    */
Route::middleware('isKid')->prefix('admin')->name('admin.')->group(function () {

    // Acount
    Route::prefix('account')->name('account.')->group(function () {
        Route::get('/', [AdminController::class, 'profile'])->name('profile');
        Route::post('/update', [AdminController::class, 'update']);
        Route::delete('/delete', [AdminController::class, 'delete'])->name('delete');

        Route::post('/password/change', [AdminController::class, 'change_password'])->name('change_password');;
    });
    // Dashboard
    Route::get('/', [AdminController::class, 'index'])->name('index');

    // Kids
    Route::resource('kids', KidController::class);
    Route::get('kids/{kid}/show-auth', [KidController::class, 'showKidAuth'])->name('kids.show-auth');
    Route::resource('kid-achievements', KidAchievementController::class);
    Route::resource('kid-lesson-progresses', KidLessonProgressController::class);
    Route::resource('kid-sessions', KidSessionController::class);

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

    // Profile
    // Route::get('profile', [KidProfileController::class, 'show'])->name('profile');

    // Auth Modal (عرض البريد وكلمة المرور)
    // Route::get('auth-modal', [KidController::class, 'showKidAuth'])->name('auth-modal');
});

/*
    |--------------------------------------------------------------------------
    | Parent Routes (الوالد)
    |--------------------------------------------------------------------------
    */
Route::middleware('isParent')->prefix('admin')->name('admin.')->group(function () {
    // // Kids
    // Route::resource('kids', KidController::class)->only(['index', 'show', 'edit', 'update']);
    // Route::get('kids/{kid}/show-auth', [KidController::class, 'showKidAuth'])->name('kids.show-auth');
    Route::post('kids/create-account', [KidController::class, 'createAccount'])
        ->name('kids.createAccount');


    // Route::resource('kid-achievements', KidAchievementController::class)->only(['index', 'show']);
    // Route::resource('kid-lesson-progresses', KidLessonProgressController::class)->only(['index', 'show']);
    // Route::resource('kid-sessions', KidSessionController::class)->only(['index', 'show']);
    // // Games & Goals
    // Route::resource('games', GameController::class)->only(['index', 'show']);
    // Route::resource('game-kids', GameKidController::class)->only(['index', 'show']);
    // Route::resource('daily-goals', DailyGoalController::class)->only(['index', 'show']);

    // // Rewards & Store
    // Route::resource('rewards', RewardController::class)->only(['index', 'show']);
    // Route::resource('store-items', StoreItemController::class)->only(['index', 'show']);
    // Route::resource('purchases', PurchaseController::class)->only(['index', 'show']);

    // Notifications & Settings
    Route::get('notifications/read', [NotificationController::class, 'markAllAsRead'])->name('notifications.read');
    Route::resource('notifications', NotificationController::class);

    // Route::get('/notifications/read/{id}', [NotificationController::class, 'markAllAsRead'])->name('notifications.read');

    Route::resource('user-settings', UserSettingController::class);
    Route::resource('parental-controls', ParentalControlController::class);
});

/*
|--------------------------------------------------------------------------
| Admin Routes (المشرف)
|--------------------------------------------------------------------------
*/
Route::middleware('isAdmin')->prefix('admin')->name('admin.')->group(function () {

    // // Acount
    // Route::prefix('account')->name('account.')->group(function () {
    //     Route::get('/', [AdminController::class, 'profile'])->name('profile');
    //     Route::post('/update', [AdminController::class, 'update']);
    //     Route::post('/delete', [AdminController::class, 'delete'])->name('delete');

    //     Route::post('/password/change', [AdminController::class, 'change_password'])->name('change_password');;
    // });

    // Users
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('avatars', AvatarController::class);

    // Kids
    // Route::resource('kids', KidController::class);
    // Route::get('kids/{kid}/show-auth', [KidController::class, 'showKidAuth'])->name('kids.show-auth');
    Route::resource('parent-children', ParentChildController::class);
    // Route::resource('kid-achievements', KidAchievementController::class);
    // Route::resource('kid-lesson-progresses', KidLessonProgressController::class);
    // Route::resource('kid-sessions', KidSessionController::class);
    Route::resource('otps', OtpController::class);

    // // Games
    // Route::resource('games', GameController::class);
    // Route::resource('game-kids', GameKidController::class);

    // // Daily Goals
    // Route::resource('daily-goals', DailyGoalController::class);

    // // Rewards
    // Route::resource('rewards', RewardController::class);

    // // Store
    // Route::resource('store-items', StoreItemController::class);
    // Route::resource('purchases', PurchaseController::class);

    // // Lessons & Quizzes
    // Route::resource('lessons', LessonController::class);
    // Route::resource('quizzes', QuizController::class);
    // Route::resource('questions', QuestionController::class);
    // Route::resource('quiz-attempts', QuizAttemptController::class);
    // Route::resource('quiz-answers', QuizAnswerController::class);

    // // Points & Achievements
    // Route::resource('points-transactions', PointsTransactionController::class);
    // Route::resource('achievements', AchievementController::class);

    // // Notifications & Settings
    // Route::resource('notifications', NotificationController::class);
    // Route::resource('user-settings', UserSettingController::class);
    // Route::resource('parental-controls', ParentalControlController::class);
});



// Auth
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/signin', [AuthController::class, 'signin'])->name('signin');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup');
//
Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('forgot_password');
Route::post('/reset-password', [AuthController::class, 'checkEmail'])->name('reset_password');
// صفحة إدخال كلمة مرور جديدة
Route::get('/set-new-password/{email}', [AuthController::class, 'showNewPasswordForm'])->name('set_new_password');
Route::post('/set-new-password/{email}', [AuthController::class, 'saveNewPassword'])->name('save_new_password');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// otp
Route::get('verfactionemail/{token}', [VerficationEmailController::class, 'verficationemailpage'])->name('verficationemailpage');
Route::post('verify-email', [VerficationEmailController::class, 'verifyemail'])->name('verifyemail');
