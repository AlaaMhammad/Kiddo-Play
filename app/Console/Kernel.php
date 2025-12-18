<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\GenerateDailyGoalsJob;

class Kernel extends ConsoleKernel
{
    /**
     * تسجيل الأوامر (Commands) المخصصة
     */
    protected $commands = [
        // يمكنك إضافة أي Commands مخصصة هنا
    ];

    /**
     * جدولة المهام
     */
    protected function schedule(Schedule $schedule)
    {
        // Job لإنشاء Daily Goals عند منتصف الليل
        $schedule->job(new GenerateDailyGoalsJob)->daily();

        // مثال: يمكنك إضافة أوامر أخرى
        // $schedule->command('some:command')->hourly();
    }

    /**
     * تسجيل Commands المخصصة
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
