<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(CityCountrySeeder::class);
        $this->call(NavlinkSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(TimesheetSeeder::class);
        $this->call(ContactSeeder::class);
    }
}
