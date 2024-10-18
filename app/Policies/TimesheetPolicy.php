<?php

namespace App\Policies;

use App\Models\TimeSheet;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TimesheetPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('timesheets.view');
    }

    public function view(User $user, TimeSheet $timesheet): bool
    {
        return $user->hasPermissionTo('timesheets.view');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('timesheets.create');
    }

    public function update(User $user, TimeSheet $timesheet): bool
    {
        return $user->hasPermissionTo('timesheets.edit');
    }

    public function delete(User $user, TimeSheet $timesheet): bool
    {
        return $user->hasPermissionTo('timesheets.delete');
    }

    public function massDelete(User $user): bool
    {
        return $user->hasPermissionTo('timesheets.delete');
    }

    public function search(User $user): bool
    {
        return $user->hasPermissionTo('timesheets.search');
    }
}
