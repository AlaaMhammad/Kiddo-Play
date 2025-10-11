<?php

namespace App\Policies;

use App\Models\ParentChild;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ParentChildPolicy
{

    public function before(User $user, $ability)
    {
        if ($user->role->name === 'admin') return true;
    }

    public function viewAny(User $user): bool
    {
        return in_array($user->role->name, ['admin', 'parent']);
    }

    public function view(User $user, $parentChild): bool
    {
        return $user->role->name === 'parent' && $parentChild->parent_id === $user->id;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, $parentChild): bool
    {
        return false;
    }

    public function delete(User $user, $parentChild): bool
    {
        return false;
    }
}
