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
        $sAdmin = Role::create(['name' => 'super admin']);
        $admin = Role::create(['name' => 'admin']);

        // user permissions
        $users = Permission::create(['name' => 'users',
                            'group_name' => 'users']);

        Permission::create(['name' => 'users.view',
                            'group_name' => 'users',
                            'description' => 'Can view users.',
                            'parent_id' => $users->id]);
        Permission::create(['name' => 'users.edit',
                            'group_name' => 'users',
                            'description' => 'Can edit existing users.',
                            'parent_id' => $users->id]);
        Permission::create(['name' => 'users.create',
                            'group_name' => 'users',
                            'description' => 'Can create new users.',
                            'parent_id' => $users->id]);
        Permission::create(['name' => 'users.delete',
                            'group_name' => 'users',
                            'description' => 'Can delete users.',
                            'parent_id' => $users->id]);

        // roles permissions
        $roles = Permission::create(['name' => 'roles',
                            'group_name' => 'roles']);

        Permission::create(['name' => 'roles.view',
                            'group_name' => 'roles',
                            'description' => 'Can view roles.',
                            'parent_id' => $roles->id]);
        Permission::create(['name' => 'roles.edit',
                            'group_name' => 'roles',
                            'description' => 'Can edit existing roles.',
                            'parent_id' => $roles->id]);
        Permission::create(['name' => 'roles.create',
                            'group_name' => 'roles',
                            'description' => 'Can create new roles.',
                            'parent_id' => $roles->id]);
        Permission::create(['name' => 'roles.delete',
                            'group_name' => 'roles',
                            'description' => 'Can delete roles.',
                            'parent_id' => $roles->id]);
        Permission::create(['name' => 'roles.assign',
                            'group_name' => 'roles',
                            'description' => 'Can assign roles to models (typically to users).',
                            'parent_id' => $roles->id]);

        // permissions permissions
        $permissions = Permission::create(['name' => 'permissions',
                            'group_name' => 'permissions']);

        Permission::create(['name' => 'permissions.view',
                            'group_name' => 'permissions',
                            'description' => 'Can view permissions.',
                            'parent_id' => $permissions->id]);
        Permission::create(['name' => 'permissions.edit',
                            'group_name' => 'permissions',
                            'description' => 'Can edit existing permissions.',
                            'parent_id' => $permissions->id]);
        Permission::create(['name' => 'permissions.create',
                            'group_name' => 'permissions',
                            'description' => 'Can create new permissions.',
                            'parent_id' => $permissions->id]);
        Permission::create(['name' => 'permissions.delete',
                            'group_name' => 'permissions',
                            'description' => 'Can delete permissions.',
                            'parent_id' => $permissions->id]);
        Permission::create(['name' => 'permissions.assign',
                            'group_name' => 'permissions',
                            'description' => 'Can assign permissions to models (typically to roles).',
                            'parent_id' => $permissions->id]);

        // app settings
        $settings = Permission::create(['name' => 'settings',
                                     'group_name' => 'settings']);

        Permission::create(['name' => 'settings.view',
                            'group_name' => 'settings',
                            'description' => 'Can view settings.',
                            'parent_id' => $users->id]);
        Permission::create(['name' => 'settings.edit',
                            'group_name' => 'settings',
                            'description' => 'Can edit existing settings.',
                            'parent_id' => $users->id]);


        // assign permissions to super admin
        $sAdmin->givePermissionTo([$users->children]);
        $sAdmin->givePermissionTo([$permissions->children]);
        $sAdmin->givePermissionTo([$roles->children]);
        $sAdmin->givePermissionTo([$settings->children]);

        // assign permissions to admin
        $admin->givePermissionTo([$users->children]);
        $admin->givePermissionTo([$permissions->children]);
        $admin->givePermissionTo([$roles->children]);
    }
}
