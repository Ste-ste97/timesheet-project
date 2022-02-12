<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'admin']);

        // user permissions
        $users = Permission::create(['name' => 'users',
                            'resource_name' => 'users']);

        Permission::create(['name' => 'users.view',
                            'resource_name' => 'users',
                            'description' => 'Can view users.',
                            'parent_id' => $users->id]);
        Permission::create(['name' => 'users.edit',
                            'resource_name' => 'users',
                            'description' => 'Can edit existing users.',
                            'parent_id' => $users->id]);
        Permission::create(['name' => 'users.create',
                            'resource_name' => 'users',
                            'description' => 'Can create new users.',
                            'parent_id' => $users->id]);
        Permission::create(['name' => 'users.delete',
                            'resource_name' => 'users',
                            'description' => 'Can delete users.',
                            'parent_id' => $users->id]);

        // roles permissions
        $roles = Permission::create(['name' => 'roles',
                            'resource_name' => 'roles']);

        Permission::create(['name' => 'roles.view',
                            'resource_name' => 'roles',
                            'description' => 'Can view roles.',
                            'parent_id' => $roles->id]);
        Permission::create(['name' => 'roles.edit',
                            'resource_name' => 'roles',
                            'description' => 'Can edit existing roles.',
                            'parent_id' => $roles->id]);
        Permission::create(['name' => 'roles.create',
                            'resource_name' => 'roles',
                            'description' => 'Can create new roles.',
                            'parent_id' => $roles->id]);
        Permission::create(['name' => 'roles.delete',
                            'resource_name' => 'roles',
                            'description' => 'Can delete roles.',
                            'parent_id' => $roles->id]);
        Permission::create(['name' => 'roles.assign',
                            'resource_name' => 'roles',
                            'description' => 'Can assign roles to models (typically to users).',
                            'parent_id' => $roles->id]);

        // permissions permissions
        $permissions = Permission::create(['name' => 'permissions',
                            'resource_name' => 'permissions']);

        Permission::create(['name' => 'permissions.view',
                            'resource_name' => 'permissions',
                            'description' => 'Can view permissions.',
                            'parent_id' => $permissions->id]);
        Permission::create(['name' => 'permissions.edit',
                            'resource_name' => 'permissions',
                            'description' => 'Can edit existing permissions.',
                            'parent_id' => $permissions->id]);
        Permission::create(['name' => 'permissions.create',
                            'resource_name' => 'permissions',
                            'description' => 'Can create new permissions.',
                            'parent_id' => $permissions->id]);
        Permission::create(['name' => 'permissions.delete',
                            'resource_name' => 'permissions',
                            'description' => 'Can delete permissions.',
                            'parent_id' => $permissions->id]);
        Permission::create(['name' => 'permissions.assign',
                            'resource_name' => 'permissions',
                            'description' => 'Can assign permissions to models (typically to roles).',
                            'parent_id' => $permissions->id]);

    }
}
