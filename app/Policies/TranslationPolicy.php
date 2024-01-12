<?php

namespace App\Policies;

use App\Models\Translation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TranslationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('translations.view');
    }

    public function view(User $user, Translation $translation): bool
    {
        return $user->hasPermissionTo('translations.view');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('translations.create');
    }

    public function update(User $user, Translation $translation): bool
    {
        return $user->hasPermissionTo('translations.edit');
    }

    public function delete(User $user): bool
    {
        return $user->hasPermissionTo('translations.delete');
    }
}
