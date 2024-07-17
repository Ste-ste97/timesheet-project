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
        $user = Role::findOrCreate('user');

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
        $admin->givePermissionTo([$users->children]);
        $admin->givePermissionTo([$permissions->children]);
        $admin->givePermissionTo([$roles->children]);
        $admin->givePermissionTo([$logs->children]);
        $admin->givePermissionTo([$translations->children]);

    }
}
