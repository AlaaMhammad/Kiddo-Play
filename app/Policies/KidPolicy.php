<?php

namespace App\Policies;

use App\Models\Kid;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class KidPolicy
{
    public function viewAny(User $user): bool
    {
        // يمكن للأب رؤية أطفاله
        return $user->role?->name === 'parent';
    }

    public function view(User $user, Kid $kid): bool
    {
        // الأب يمكنه رؤية أي طفل مرتبط به
        return $kid->parents->contains($user->id);
    }

    public function update(User $user, Kid $kid): bool
    {
        // الأب يمكنه تعديل أي طفل مرتبط به
        return $kid->parents->contains($user->id);
    }

    public function create(User $user): bool
    {
        return $user->role?->name === 'parent';
    }


    public function delete(User $user, Kid $kid): bool
    {
        // الأب يمكنه حذف الطفل المرتبط به
        return $kid->parents->contains($user->id);
    }
}
