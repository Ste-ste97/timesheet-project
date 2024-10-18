<?php

namespace Database\Seeders;

use App\Models\Navlink;
use Illuminate\Database\Seeder;

class NavlinkSeeder extends Seeder
{
    public function run(): void
    {
        Navlink::firstOrCreate([
            'name'        => 'Dashboard',
            'icon'        => 'pi pi-home',
            'permissions' => 'dashboard.view',
            'route_name'  => 'dashboard'
        ]);

        Navlink::firstOrCreate([
            'name'        => 'Timesheets',
            'icon'        => 'pi pi-calendar',
            'permissions' => 'timesheets.view',
            'route_name'  => 'timesheets.index'
        ]);

        Navlink::firstOrCreate([
            'name'        => 'Advanced Timesheets',
            'icon'        => 'pi pi-calendar-plus',
            'permissions' => 'timesheets.view',
            'route_name'  => 'timesheets.search',
        ]);

        Navlink::firstOrCreate([
            'name'        => 'Total Timesheets Cost',
            'icon'        => 'pi pi-calendar-times',
            'permissions' => 'totalTimesheetsCost.view',
            'route_name'  => 'totalTimesheetsCost.index',
        ]);

        Navlink::firstOrCreate([
            'name'        => 'Clients',
            'icon'        => 'pi pi-building',
            'permissions' => 'clients.view',
            'route_name'  => 'clients.index'
        ]);

        Navlink::firstOrCreate([
            'name'        => 'Services',
            'icon'        => 'pi pi-briefcase',
            'permissions' => 'services.view',
            'route_name'  => 'services.index'
        ]);

        $user_management = Navlink::firstOrCreate([
            'name'        => 'User Management',
            'permissions' => 'users.view|permissions.view|roles.view',
            'icon'        => 'pi pi-users',
        ]);

        Navlink::firstOrCreate([
            'name'        => 'Users',
            'icon'        => 'pi pi-user',
            'permissions' => 'users.view',
            'parent_id'   => $user_management->id,
            'route_name'  => 'users.index'
        ]);

        Navlink::firstOrCreate([
            'name'        => 'Roles',
            'icon'        => 'pi pi-user-plus',
            'permissions' => 'roles.view',
            'parent_id'   => $user_management->id,
            'route_name'  => 'roles.index'
        ]);

        Navlink::firstOrCreate([
            'name'        => 'Permissions',
            'icon'        => 'pi pi-user-plus',
            'permissions' => 'permissions.view',
            'parent_id'   => $user_management->id,
            'route_name'  => 'permissions.index'
        ]);

        Navlink::firstOrCreate([
            'name'        => 'Log Viewer',
            'icon'        => 'pi pi-book',
            'external'    => true,
            'permissions' => 'logs.view',
            'route_name'  => 'blv.index'
        ]);

        Navlink::firstOrCreate([
            'name'        => 'Translations',
            'icon'        => 'pi pi-globe',
            'route_name'  => 'translations.index',
            'permissions' => 'translations.view'
        ]);

    }
}
