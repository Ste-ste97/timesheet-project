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

        $users = Permission::create(['name' => 'users',
                            'resource_name' => 'users']);

        Permission::create(['name' => 'users.view',
                            'resource_name' => 'users',
                            'parent_id' => $users->id]);
        Permission::create(['name' => 'users.edit',
                            'resource_name' => 'users',
                            'parent_id' => $users->id]);
        Permission::create(['name' => 'users.create',
                            'resource_name' => 'users',
                            'parent_id' => $users->id]);
        Permission::create(['name' => 'users.delete',
                            'resource_name' => 'users',
                            'parent_id' => $users->id]);
    }
}
