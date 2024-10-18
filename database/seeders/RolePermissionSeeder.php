<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        $admin = Role::findOrCreate('admin');
        $user  = Role::findOrCreate('user');

        //dashboard permissions
        $dashboard = Permission::firstOrCreate([
            'name'       => 'dashboard',
            'group_name' => 'dashboard'
        ]);

        Permission::firstOrCreate([
            'name'        => 'dashboard.view',
            'group_name'  => 'dashboard',
            'description' => 'Can view dashboard.',
            'parent_id'   => $dashboard->id
        ]);

        //time sheet permissions
        $timesheets = Permission::firstOrCreate([
            'name'       => 'timesheets',
            'group_name' => 'timesheets'
        ]);

        Permission::firstOrCreate([
            'name'        => 'timesheets.view',
            'group_name'  => 'timesheets',
            'description' => 'Can view timesheets.',
            'parent_id'   => $timesheets->id
        ]);

        Permission::firstOrCreate([
            'name'        => 'timesheets.edit',
            'group_name'  => 'timesheets',
            'description' => 'Can edit existing timesheets.',
            'parent_id'   => $timesheets->id
        ]);

        Permission::firstOrCreate([
            'name'        => 'timesheets.create',
            'group_name'  => 'timesheets',
            'description' => 'Can create new timesheets.',
            'parent_id'   => $timesheets->id
        ]);

        Permission::firstOrCreate([
            'name'        => 'timesheets.delete',
            'group_name'  => 'timesheets',
            'description' => 'Can delete timesheets.',
            'parent_id'   => $timesheets->id
        ]);

        Permission::firstOrCreate([
            'name'        => 'timesheets.search',
            'group_name'  => 'timesheets',
            'description' => 'Can search timesheets.',
            'parent_id'   => $timesheets->id
        ]);

        //total timesheet cost permissions
        $totalTimesheetsCost = Permission::firstOrCreate([
            'name'       => 'totalTimesheetsCost',
            'group_name' => 'totalTimesheetsCost'
        ]);

        Permission::firstOrCreate([
            'name'        => 'totalTimesheetsCost.view',
            'group_name'  => 'totalTimesheetsCost',
            'description' => 'Can view total timesheets cost.',
            'parent_id'   => $totalTimesheetsCost->id
        ]);


        //client permissions
        $clients = Permission::firstOrCreate([
            'name'       => 'clients',
            'group_name' => 'clients'
        ]);

        Permission::firstOrCreate([
            'name'        => 'clients.view',
            'group_name'  => 'clients',
            'description' => 'Can view clients.',
            'parent_id'   => $clients->id
        ]);

        Permission::firstOrCreate([
            'name'        => 'clients.edit',
            'group_name'  => 'clients',
            'description' => 'Can edit existing clients.',
            'parent_id'   => $clients->id
        ]);

        Permission::firstOrCreate([
            'name'        => 'clients.create',
            'group_name'  => 'clients',
            'description' => 'Can create new clients.',
            'parent_id'   => $clients->id
        ]);

        Permission::firstOrCreate([
            'name'        => 'clients.delete',
            'group_name'  => 'clients',
            'description' => 'Can delete clients.',
            'parent_id'   => $clients->id
        ]);

        Permission::firstOrCreate([
            'name'        => 'clients.assign',
            'group_name'  => 'clients',
            'description' => 'Can assign clients to models (typically to users).',
            'parent_id'   => $clients->id
        ]);

        //Service permissions
        $services = Permission::firstOrCreate([
            'name'       => 'services',
            'group_name' => 'services'
        ]);

        Permission::firstOrCreate([
            'name'        => 'services.view',
            'group_name'  => 'services',
            'description' => 'Can view services.',
            'parent_id'   => $services->id
        ]);

        Permission::firstOrCreate([
            'name'        => 'services.edit',
            'group_name'  => 'services',
            'description' => 'Can edit existing services.',
            'parent_id'   => $services->id
        ]);

        Permission::firstOrCreate([
            'name'        => 'services.create',
            'group_name'  => 'services',
            'description' => 'Can create new services.',
            'parent_id'   => $services->id
        ]);

        Permission::firstOrCreate([
            'name'        => 'services.delete',
            'group_name'  => 'services',
            'description' => 'Can delete services.',
            'parent_id'   => $services->id
        ]);

        Permission::firstOrCreate([
            'name'        => 'services.assign',
            'group_name'  => 'services',
            'description' => 'Can assign services to models (typically to users).',
            'parent_id'   => $services->id
        ]);

        // user permissions
        $users = Permission::firstOrCreate([
            'name'       => 'users',
            'group_name' => 'users'
        ]);

        Permission::firstOrCreate([
            'name'        => 'users.view',
            'group_name'  => 'users',
            'description' => 'Can view users.',
            'parent_id'   => $users->id
        ]);
        Permission::firstOrCreate([
            'name'        => 'users.edit',
            'group_name'  => 'users',
            'description' => 'Can edit existing users.',
            'parent_id'   => $users->id
        ]);
        Permission::firstOrCreate([
            'name'        => 'users.create',
            'group_name'  => 'users',
            'description' => 'Can create new users.',
            'parent_id'   => $users->id
        ]);
        Permission::firstOrCreate([
            'name'        => 'users.delete',
            'group_name'  => 'users',
            'description' => 'Can delete users.',
            'parent_id'   => $users->id
        ]);

        Permission::firstOrCreate([
            'name'        => 'users.assign',
            'group_name'  => 'users',
            'description' => 'Can assign users to models (typically to clients).',
            'parent_id'   => $users->id
        ]);

        // roles permissions
        $roles = Permission::firstOrCreate([
            'name'       => 'roles',
            'group_name' => 'roles'
        ]);

        Permission::firstOrCreate([
            'name'        => 'roles.view',
            'group_name'  => 'roles',
            'description' => 'Can view roles.',
            'parent_id'   => $roles->id
        ]);
        Permission::firstOrCreate([
            'name'        => 'roles.edit',
            'group_name'  => 'roles',
            'description' => 'Can edit existing roles.',
            'parent_id'   => $roles->id
        ]);
        Permission::firstOrCreate([
            'name'        => 'roles.create',
            'group_name'  => 'roles',
            'description' => 'Can create new roles.',
            'parent_id'   => $roles->id
        ]);
        Permission::firstOrCreate([
            'name'        => 'roles.delete',
            'group_name'  => 'roles',
            'description' => 'Can delete roles.',
            'parent_id'   => $roles->id
        ]);
        Permission::firstOrCreate([
            'name'        => 'roles.assign',
            'group_name'  => 'roles',
            'description' => 'Can assign roles to models (typically to users).',
            'parent_id'   => $roles->id
        ]);

        // permissions permissions
        $permissions = Permission::firstOrCreate([
            'name'       => 'permissions',
            'group_name' => 'permissions'
        ]);

        Permission::firstOrCreate([
            'name'        => 'permissions.view',
            'group_name'  => 'permissions',
            'description' => 'Can view permissions.',
            'parent_id'   => $permissions->id
        ]);
        Permission::firstOrCreate([
            'name'        => 'permissions.edit',
            'group_name'  => 'permissions',
            'description' => 'Can edit existing permissions.',
            'parent_id'   => $permissions->id
        ]);
        Permission::firstOrCreate([
            'name'        => 'permissions.create',
            'group_name'  => 'permissions',
            'description' => 'Can create new permissions.',
            'parent_id'   => $permissions->id
        ]);
        Permission::firstOrCreate([
            'name'        => 'permissions.delete',
            'group_name'  => 'permissions',
            'description' => 'Can delete permissions.',
            'parent_id'   => $permissions->id
        ]);
        Permission::firstOrCreate([
            'name'        => 'permissions.assign',
            'group_name'  => 'permissions',
            'description' => 'Can assign permissions to models (typically to roles).',
            'parent_id'   => $permissions->id
        ]);

        // log permissions
        $logs = Permission::firstOrCreate([
            'name'       => 'logs',
            'group_name' => 'logs'
        ]);

        Permission::firstOrCreate([
            'name'        => 'logs.view',
            'group_name'  => 'logs',
            'description' => 'Can view websites logs.',
            'parent_id'   => $logs->id
        ]);

        // Translation permission
        $translations = Permission::firstOrCreate([
            'name'       => 'translations',
            'group_name' => 'translations'
        ]);

        Permission::firstOrCreate([
            'name'        => 'translations.view',
            'group_name'  => 'translations',
            'description' => 'Can view translations.',
            'parent_id'   => $translations->id
        ]);
        Permission::firstOrCreate([
            'name'        => 'translations.edit',
            'group_name'  => 'translations',
            'description' => 'Can edit existing translations.',
            'parent_id'   => $translations->id
        ]);
        Permission::firstOrCreate([
            'name'        => 'translations.create',
            'group_name'  => 'translations',
            'description' => 'Can create new translations.',
            'parent_id'   => $translations->id
        ]);
        Permission::firstOrCreate([
            'name'        => 'translations.delete',
            'group_name'  => 'translations',
            'description' => 'Can delete translations.',
            'parent_id'   => $translations->id
        ]);


        // assign permissions to admin
        $admin->givePermissionTo([$dashboard->children]);
        $admin->givePermissionTo([$timesheets->children]);
        $admin->givePermissionTo([$totalTimesheetsCost->children]);
        $admin->givePermissionTo([$clients->children]);
        $admin->givePermissionTo([$users->children]);
        $admin->givePermissionTo([$permissions->children]);
        $admin->givePermissionTo([$roles->children]);
        $admin->givePermissionTo([$services->children]);


        //assign permissions to user
        $user->givePermissionTo([$timesheets->children]);
    }
}
