<?php

namespace App\Policies;

use App\Models\KidLessonProgress;
use App\Models\User;
use Illuminate\Auth\Access\Response;


class KidLessonProgressPolicy
{

    public function viewAny(User $user): bool
    {
        return $user->role?->name === 'parent';
    }


    // الأب: رؤية أطفاله فقط
    public function view(User $user, KidLessonProgress $kidLessonProgress): bool
    {
        return $user->role->name === 'parent' && $kidLessonProgress->kid->parents->contains($user->id);
    }

    // الأب لا يمكنه إنشاء أو تعديل أو حذف
    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, KidLessonProgress $kidLessonProgress): bool
    {
        return false;
    }

    public function delete(User $user, KidLessonProgress $kidLessonProgress): bool
    {
        return false;
    }
}
