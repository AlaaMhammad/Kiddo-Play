<?php

namespace App\Policies;

use App\Models\OTP;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OTPPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function before(User $user, $ability)
    {
        if ($user->role->name === 'admin') return true;
    }
    public function viewAny(User $user): bool
    {
        return in_array($user->role->name, ['admin', 'parent']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, OTP $oTP): bool
    {
        return $user->role->name === 'parent' && $oTP->kid->parents->contains($user->id);
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
    public function update(User $user, OTP $oTP): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, OTP $oTP): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, OTP $oTP): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, OTP $oTP): bool
    {
        return false;
    }
}
