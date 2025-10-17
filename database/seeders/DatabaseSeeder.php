<?php

namespace Database\Seeders;

use App\Models\Avatar;
use App\Models\DailyGoal;
use App\Models\Game;
use App\Models\Kid;
use App\Models\Lesson;
use App\Models\ParentChild;
use App\Models\PointsTransaction;
use App\Models\Purchase;
use App\Models\Reward;
use App\Models\Role;
use App\Models\StoreItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // --- Roles ---
        Role::firstOrCreate(['name' => 'admin'], ['lable' => 'Administrator']);
        Role::firstOrCreate(['name' => 'kid'], ['lable' => 'Kid User']);
        $parentRole = Role::firstOrCreate(['name' => 'parent'], ['lable' => 'Parent User']);

        // --- Admin user ---
        $this->call([UserSeeder::class]);

        // --- Parents ---
        $parents = User::factory(5)->create([
            'role_id' => $parentRole->id,
        ]);

        // --- Kids ---
        $kids = Kid::factory(15)->create();

        // --- Parent-Child relations ---
        foreach ($kids as $kid) {
            ParentChild::create([
                'parent_id' => $parents->random()->id,
                'kid_id' => $kid->id,
            ]);
        }

        // --- Avatars ---
        Avatar::factory(10)->create();

        // --- Games ---
        $games = Game::factory(10)->create();

        // --- Lessons ---
        Lesson::factory(8)->create();

        // --- Daily Goals ---
        $dailyGoals = DailyGoal::factory(20)->create();

        // --- Rewards ---
        Reward::factory(10)->create();

        // --- Store Items ---
        $storeItems = StoreItem::factory(10)->create();

        // --- Purchases ---
        foreach ($kids as $kid) {
            Purchase::factory(rand(1, 3))->create([
                'kid_id' => $kid->id,
                'store_item_id' => $storeItems->random()->id,
            ]);
        }

        // --- Points Transactions ---
        foreach ($kids as $kid) {
            // معاملات عشوائية (spend / adjust)
            PointsTransaction::factory(rand(1, 3))->create([
                'kid_id' => $kid->id,
            ]);
        }

        // معاملات "earn" بناءً على الأهداف اليومية المكتملة
        $completedGoals = DailyGoal::where('is_completed', true)->get();
        foreach ($completedGoals as $goal) {
            PointsTransaction::create([
                'kid_id' => $goal->kid_id,
                'type' => 'earn',
                'amount' => $goal->target_points,
                'source' => 'Daily Goal: ' . $goal->title,
                'reference_id' => $goal->id,
                'meta' => json_encode([
                    'goal_date' => $goal->goal_date,
                    'game_id' => $goal->game_id,
                ]),
            ]);
        }

        $this->command->info('✅ Database seeded successfully with full realistic data!');
    }
}
