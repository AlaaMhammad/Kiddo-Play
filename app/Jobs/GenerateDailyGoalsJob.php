<?php

namespace App\Jobs;

use App\Services\DailyGoalService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateDailyGoalsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        // يمكن إضافة معطيات إذا احتجنا لاحقًا
    }

    public function handle()
    {
        // استدعاء Service لإنشاء أهداف اليوم لكل طفل
        DailyGoalService::generateForToday();
    }
}
