<?php

namespace App\Policies;

use App\Models\ParentalControl;
use App\Models\User;

class ParentalControlPolicy
{
    public function viewAny(User $user)
    {
        // الأدمن يرى كل السجلات، الأب يرى سجلاته وأطفاله، الطفل يرى سجلاته
        return in_array($user->role->name, ['admin', 'parent', 'kid']);
    }

    public function view(User $user, ParentalControl $control)
    {
        if ($user->role->name === 'admin') return true;

        if ($user->role->name === 'parent') {
            $kidsIds = $user->children()->pluck('kids.id')->toArray();
            return $control->parent_id === $user->id || in_array($control->kid_id, $kidsIds);
        }

        if ($user->role->name === 'kid') {
            return $control->kid_id === $user->kid?->id;
        }

        return false;
    }

    public function create(User $user)
    {
        return $user->role->name === 'admin';
    }

    public function update(User $user, ParentalControl $control)
    {
        return $user->role->name === 'admin';
    }

    public function delete(User $user, ParentalControl $control)
    {
        return $user->role->name === 'admin';
    }
}
