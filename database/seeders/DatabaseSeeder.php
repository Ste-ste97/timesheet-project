<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\NavlinkSeeder;
use Database\Seeders\CityCountrySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CityCountrySeeder::class);
        $this->call(NavlinkSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(RolePermissionSeeder::class);
    }
}
