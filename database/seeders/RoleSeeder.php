<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        Role::firstOrCreate([
            'name' => 'admin',
        ], [
            'lable' => 'Administrator',
        ]);

        // Parent
        Role::firstOrCreate(
            ['name' => 'parent'],
            ['lable' => 'Parent User']
        );
    }
}
