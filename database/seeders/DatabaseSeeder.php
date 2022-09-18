<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\NavlinkSeeder;
use Database\Seeders\CityCountrySeeder;

class DatabaseSeeder extends Seeder
{
    public function run() {
        $this->call(CityCountrySeeder::class);
        $this->call(NavlinkSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(UserSeeder::class);
    }
}
