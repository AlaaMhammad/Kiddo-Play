<?php

namespace App\Policies;

use App\Models\GameKid;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GameKidPolicy
{


    public function viewAny(User $user): bool
    {
        return $user->role?->name === 'parent';
    }

    public function view(User $user, GameKid $gameKid): bool
    {
        return $user->role->name === 'parent' && $gameKid->kid->parents->contains($user->id);
    }


    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, GameKid $gameKid): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, GameKid $gameKid): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, GameKid $gameKid): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, GameKid $gameKid): bool
    {
        return false;
    }
}
