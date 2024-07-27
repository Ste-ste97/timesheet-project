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

        //time sheet permissions
        $timesheets = Permission::create([
            'name'       => 'timesheets',
            'group_name' => 'timesheets'
        ]);

        Permission::create([
            'name'        => 'timesheets.view',
            'group_name'  => 'timesheets',
            'description' => 'Can view timesheets.',
            'parent_id'   => $timesheets->id
        ]);

        Permission::create([
            'name'        => 'timesheets.edit',
            'group_name'  => 'timesheets',
            'description' => 'Can edit existing timesheets.',
            'parent_id'   => $timesheets->id
        ]);

        Permission::create([
            'name'        => 'timesheets.create',
            'group_name'  => 'timesheets',
            'description' => 'Can create new timesheets.',
            'parent_id'   => $timesheets->id
        ]);

        Permission::create([
            'name'        => 'timesheets.delete',
            'group_name'  => 'timesheets',
            'description' => 'Can delete timesheets.',
            'parent_id'   => $timesheets->id
        ]);

        //total timesheet cost permissions
        $totalTimesheetsCost = Permission::create([
            'name'       => 'totalTimesheetsCost',
            'group_name' => 'totalTimesheetsCost'
        ]);

        Permission::create([
            'name'        => 'totalTimesheetsCost.view',
            'group_name'  => 'totalTimesheetsCost',
            'description' => 'Can view total timesheets cost.',
            'parent_id'   => $totalTimesheetsCost->id
        ]);


        //company permissions
        $companies = Permission::create([
            'name'       => 'companies',
            'group_name' => 'companies'
        ]);

        Permission::create([
            'name'        => 'companies.view',
            'group_name'  => 'companies',
            'description' => 'Can view companies.',
            'parent_id'   => $companies->id
        ]);

        Permission::create([
            'name'        => 'companies.edit',
            'group_name'  => 'companies',
            'description' => 'Can edit existing companies.',
            'parent_id'   => $companies->id
        ]);

        Permission::create([
            'name'        => 'companies.create',
            'group_name'  => 'companies',
            'description' => 'Can create new companies.',
            'parent_id'   => $companies->id
        ]);

        Permission::create([
            'name'        => 'companies.delete',
            'group_name'  => 'companies',
            'description' => 'Can delete companies.',
            'parent_id'   => $companies->id
        ]);

        Permission::create([
            'name'        => 'companies.assign',
            'group_name'  => 'companies',
            'description' => 'Can assign companies to models (typically to users).',
            'parent_id'   => $companies->id
        ]);

        //Service permissions
        $services = Permission::create([
            'name'       => 'services',
            'group_name' => 'services'
        ]);

        Permission::create([
            'name'        => 'services.view',
            'group_name'  => 'services',
            'description' => 'Can view services.',
            'parent_id'   => $services->id
        ]);

        Permission::create([
            'name'        => 'services.edit',
            'group_name'  => 'services',
            'description' => 'Can edit existing services.',
            'parent_id'   => $services->id
        ]);

        Permission::create([
            'name'        => 'services.create',
            'group_name'  => 'services',
            'description' => 'Can create new services.',
            'parent_id'   => $services->id
        ]);

        Permission::create([
            'name'        => 'services.delete',
            'group_name'  => 'services',
            'description' => 'Can delete services.',
            'parent_id'   => $services->id
        ]);


        // user permissions
        $users = Permission::create([
            'name'       => 'users',
            'group_name' => 'users'
        ]);

        Permission::create([
            'name'        => 'users.view',
            'group_name'  => 'users',
            'description' => 'Can view users.',
            'parent_id'   => $users->id
        ]);
        Permission::create([
            'name'        => 'users.edit',
            'group_name'  => 'users',
            'description' => 'Can edit existing users.',
            'parent_id'   => $users->id
        ]);
        Permission::create([
            'name'        => 'users.create',
            'group_name'  => 'users',
            'description' => 'Can create new users.',
            'parent_id'   => $users->id
        ]);
        Permission::create([
            'name'        => 'users.delete',
            'group_name'  => 'users',
            'description' => 'Can delete users.',
            'parent_id'   => $users->id
        ]);

        // roles permissions
        $roles = Permission::create([
            'name'       => 'roles',
            'group_name' => 'roles'
        ]);

        Permission::create([
            'name'        => 'roles.view',
            'group_name'  => 'roles',
            'description' => 'Can view roles.',
            'parent_id'   => $roles->id
        ]);
        Permission::create([
            'name'        => 'roles.edit',
            'group_name'  => 'roles',
            'description' => 'Can edit existing roles.',
            'parent_id'   => $roles->id
        ]);
        Permission::create([
            'name'        => 'roles.create',
            'group_name'  => 'roles',
            'description' => 'Can create new roles.',
            'parent_id'   => $roles->id
        ]);
        Permission::create([
            'name'        => 'roles.delete',
            'group_name'  => 'roles',
            'description' => 'Can delete roles.',
            'parent_id'   => $roles->id
        ]);
        Permission::create([
            'name'        => 'roles.assign',
            'group_name'  => 'roles',
            'description' => 'Can assign roles to models (typically to users).',
            'parent_id'   => $roles->id
        ]);

        // permissions permissions
        $permissions = Permission::create([
            'name'       => 'permissions',
            'group_name' => 'permissions'
        ]);

        Permission::create([
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
        Permission::create([
            'name'        => 'permissions.create',
            'group_name'  => 'permissions',
            'description' => 'Can create new permissions.',
            'parent_id'   => $permissions->id
        ]);
        Permission::create([
            'name'        => 'permissions.delete',
            'group_name'  => 'permissions',
            'description' => 'Can delete permissions.',
            'parent_id'   => $permissions->id
        ]);
        Permission::create([
            'name'        => 'permissions.assign',
            'group_name'  => 'permissions',
            'description' => 'Can assign permissions to models (typically to roles).',
            'parent_id'   => $permissions->id
        ]);

        // log permissions
        $logs = Permission::create([
            'name'       => 'logs',
            'group_name' => 'logs'
        ]);

        Permission::create([
            'name'        => 'logs.view',
            'group_name'  => 'logs',
            'description' => 'Can view websites logs.',
            'parent_id'   => $logs->id
        ]);

        // Translation permission
        $translations = Permission::create([
            'name'       => 'translations',
            'group_name' => 'translations'
        ]);

        Permission::create([
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
        Permission::create([
            'name'        => 'translations.create',
            'group_name'  => 'translations',
            'description' => 'Can create new translations.',
            'parent_id'   => $translations->id
        ]);
        Permission::create([
            'name'        => 'translations.delete',
            'group_name'  => 'translations',
            'description' => 'Can delete translations.',
            'parent_id'   => $translations->id
        ]);


        // assign permissions to admin
        $admin->givePermissionTo([$timesheets->children]);
        $admin->givePermissionTo([$totalTimesheetsCost->children]);
        $admin->givePermissionTo([$companies->children]);
        $admin->givePermissionTo([$users->children]);
        $admin->givePermissionTo([$permissions->children]);
        $admin->givePermissionTo([$roles->children]);
        $admin->givePermissionTo([$services->children]);


        //assign permissions to user
        $user->givePermissionTo([$timesheets->children]);
    }
}
