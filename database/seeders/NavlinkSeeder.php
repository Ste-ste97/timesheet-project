<?php

namespace Database\Seeders;

use App\Models\Navlink;
use Illuminate\Database\Seeder;

class NavlinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Navlink::create([
            'name' => 'Dashboard',
            'icon' => 'pi pi-home',
            'route_name' => 'dashboard'
        ]);

        $user_management = Navlink::create([
            'name' => 'User Management',
            'icon' => 'pi pi-users',
        ]);

        Navlink::create([
            'name' => 'Users',
            'icon' => 'pi pi-user',
            'parent_id' => $user_management->id,
            'route_name' => 'users.index'
        ]);

        Navlink::create([
            'name' => 'Roles',
            'icon' => 'pi pi-user-plus',
            'parent_id' => $user_management->id,
            'route_name' => 'roles.index'
        ]);

        Navlink::create([
            'name' => 'Permissions',
            'icon' => 'pi pi-user-plus',
            'parent_id' => $user_management->id,
            'route_name' => 'permissions.index'
        ]);


    }
}
