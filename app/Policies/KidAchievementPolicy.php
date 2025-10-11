<?php

namespace App\Policies;

use App\Models\KidAchievement;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class KidAchievementPolicy
{

    public function viewAny(User $user): bool
    {
        return $user->role?->name === 'parent';
    }

    public function view(User $user, $achievement): bool
    {
        return $user->role->name === 'parent' && $achievement->kid->parents->contains($user->id);
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, $achievement): bool
    {
        return false;
    }

    public function delete(User $user, $achievement): bool
    {
        return false;
    }
}
