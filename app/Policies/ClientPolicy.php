<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('clients.view');
    }

    public function view(User $user, Client $client): bool
    {
        return $user->hasPermissionTo('clients.view');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('clients.create');
    }

    public function update(User $user, Client $client): bool
    {
        return $user->hasPermissionTo('clients.edit');
    }

    public function delete(User $user): bool
    {
        return $user->hasPermissionTo('clients.delete');
    }
}
