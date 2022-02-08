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
        Navlink::firstOrCreate([
            'name' => 'Dashboard',
            'icon' => 'pi pi-home',
            'route_name' => 'dashboard'
        ]);

        $level1 = Navlink::firstOrCreate([
            'name' => 'Test Level 1',
            'icon' => 'pi pi-home',
        ]);

        $level2 = Navlink::firstOrCreate([
            'name' => 'Test-1 Level 2',
            'icon' => 'pi pi-home',
            'parent_id' => $level1->id
        ]);

        $level2_1 = Navlink::firstOrCreate([
            'name' => 'Test-2 Level 2',
            'icon' => 'pi pi-home',
            'parent_id' => $level1->id
        ]);

        $level3_1 = Navlink::firstOrCreate([
            'name' => 'Test-1 Level 3',
            'icon' => 'pi pi-home',
            'parent_id' => $level2->id,
            'route_name' => 'profile'
        ]);

        $level3_3 = Navlink::firstOrCreate([
            'name' => 'Test-2 Level 3',
            'icon' => 'pi pi-home',
            'parent_id' => $level2->id
        ]);

        $level3_3 = Navlink::firstOrCreate([
            'name' => 'Test-3 Level 3',
            'icon' => 'pi pi-home',
            'parent_id' => $level2->id
        ]);
    }
}
