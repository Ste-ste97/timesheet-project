<?php

namespace App\Policies;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('contacts.view');
    }

    public function view(User $user, Contact $contact): bool
    {
        return $user->hasPermissionTo('contacts.view');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('contacts.create');
    }

    public function update(User $user, Contact $contact): bool
    {
        return $user->hasPermissionTo('contacts.edit');
    }

    public function delete(User $user, Contact $contact): bool
    {
        return $user->hasPermissionTo('contacts.delete');
    }

    public function massDelete(User $user): bool
    {
        return $user->hasPermissionTo('contacts.delete');
    }
}
