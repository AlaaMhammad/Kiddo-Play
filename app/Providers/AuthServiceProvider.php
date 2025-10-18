<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

// استيراد الموديلات
use App\Models\{
    GameKid,
    Game,
    KidAchievement,
    KidLessonProgress,
    Kid,
    KidSession,
    ParentChild,
    PointsTransaction,
    Reward,
    ParentalControl
};

// استيراد السياسات (Policies)
use App\Policies\{
    GameKidPolicy,
    GamePolicy,
    KidAchievementPolicy,
    KidLessonProgressPolicy,
    KidPolicy,
    KidSessionPolicy,
    ParentChildPolicy,
    PointsTransactionPolicy,
    RewardPolicy,
    ParentalControlPolicy
};

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     */
    protected $policies = [
        GameKid::class => GameKidPolicy::class,
        Game::class => GamePolicy::class,
        KidAchievement::class => KidAchievementPolicy::class,
        KidLessonProgress::class => KidLessonProgressPolicy::class,
        Kid::class => KidPolicy::class,
        KidSession::class => KidSessionPolicy::class,
        ParentChild::class => ParentChildPolicy::class,
        PointsTransaction::class => PointsTransactionPolicy::class,
        Reward::class => RewardPolicy::class,
        ParentalControl::class => ParentalControlPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // 🔒 السماح للأدمن بالوصول الكامل لأي صلاحية
        Gate::before(function ($user, $ability) {
            if ($user->role && $user->role->name === 'admin') {
                return true;
            }
        });
    }
}
