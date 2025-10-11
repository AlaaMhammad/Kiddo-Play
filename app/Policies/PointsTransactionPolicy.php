<?php

namespace App\Policies;

use App\Models\PointsTransaction;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PointsTransactionPolicy
{
    public function before(User $user, $ability)
    {
        if ($user->role->name === 'admin') return true;
    }
    public function viewAny(User $user): bool
    {
        return in_array($user->role->name, ['admin', 'parent']);
    }


    public function view(User $user, PointsTransaction $transaction): bool
    {
        return $user->role->name === 'parent' && $transaction->kid->parents->contains($user->id);
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
    public function update(User $user, PointsTransaction $pointsTransaction): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PointsTransaction $pointsTransaction): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PointsTransaction $pointsTransaction): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PointsTransaction $pointsTransaction): bool
    {
        return false;
    }
}
