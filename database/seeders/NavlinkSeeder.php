<?php

namespace Database\Seeders;

use App\Models\Navlink;
use Illuminate\Database\Seeder;

class NavlinkSeeder extends Seeder
{
    public function run(): void
    {
        Navlink::create([
            'name'        => 'Dashboard',
            'icon'        => 'pi pi-home',
            'permissions' => 'dashboard.view',
            'route_name'  => 'dashboard'
        ]);

        Navlink::create([
            'name'        => 'Timesheets',
            'icon'        => 'pi pi-calendar',
            'permissions' => 'timesheets.view',
            'route_name'  => 'timesheets.index'
        ]);

        Navlink::create([
            'name'        => 'Total Timesheets Cost',
            'icon'        => 'pi pi-calendar-times',
            'permissions' => 'totalTimesheetsCost.view',
            'route_name'  => 'totalTimesheetsCost.index',
        ]);


        Navlink::create([
            'name'        => 'Companies',
            'icon'        => 'pi pi-building',
            'permissions' => 'companies.view',
            'route_name'  => 'companies.index'
        ]);

        Navlink::create([
            'name'        => 'Services',
            'icon'        => 'pi pi-briefcase',
            'permissions' => 'services.view',
            'route_name'  => 'services.index'
        ]);

        $user_management = Navlink::create([
            'name'        => 'User Management',
            'permissions' => 'users.view|permissions.view|roles.view', // or
            'icon'        => 'pi pi-users',
        ]);

        Navlink::create([
            'name'        => 'Users',
            'icon'        => 'pi pi-user',
            'permissions' => 'users.view',
            'parent_id'   => $user_management->id,
            'route_name'  => 'users.index'
        ]);

        Navlink::create([
            'name'        => 'Roles',
            'icon'        => 'pi pi-user-plus',
            'permissions' => 'roles.view',
            'parent_id'   => $user_management->id,
            'route_name'  => 'roles.index'
        ]);

        Navlink::create([
            'name'        => 'Permissions',
            'icon'        => 'pi pi-user-plus',
            'permissions' => 'permissions.view',
            'parent_id'   => $user_management->id,
            'route_name'  => 'permissions.index'
        ]);

        Navlink::create([
            'name'        => 'Log Viewer',
            'icon'        => 'pi pi-book',
            'external'    => true,
            'permissions' => 'logs.view',
            'route_name'  => 'blv.index'
        ]);

        Navlink::create([
            'name'        => 'Translations',
            'icon'        => 'pi pi-globe',
            'route_name'  => 'translations.index',
            'permissions' => 'translations.view'
        ]);

    }
}
