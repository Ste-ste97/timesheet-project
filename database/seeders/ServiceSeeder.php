<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['name' => 'Accounting', 'price_per_hour' => rand(7, 15)],
            ['name' => 'Audit', 'price_per_hour' => rand(7, 15)],
            ['name' => 'Taxation', 'price_per_hour' => rand(7, 15)],
            ['name' => 'Social Insurance', 'price_per_hour' => rand(7, 15)],
            ['name' => 'Registral', 'price_per_hour' => rand(7, 15)],
            ['name' => 'Services', 'price_per_hour' => rand(7, 15)],
            ['name' => 'Vat Services', 'price_per_hour' => rand(7, 15)],
            ['name' => 'Consultants', 'price_per_hour' => rand(7, 15)],
            ['name' => 'Payroll', 'price_per_hour' => rand(7, 15)],
            ['name' => 'Management', 'price_per_hour' => rand(7, 15)],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
