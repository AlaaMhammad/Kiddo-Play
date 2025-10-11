<?php

namespace App\Policies;

use App\Models\Kid;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class KidPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role?->name === 'parent';
    }


    public function view(User $user, Kid $kid): bool
    {
        return $user->role->name === 'parent' && $kid->parents->contains($user->id);
    }

    public function update(User $user, Kid $kid): bool
    {
        return $user->role->name === 'parent' && $kid->parents->contains($user->id);
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function delete(User $user, Kid $kid): bool
    {
        return false;
    }
}
