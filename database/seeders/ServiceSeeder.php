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
            ['name' => 'Accounting'],
            ['name' => 'Audit'],
            ['name' => 'Taxation'],
            ['name' => 'Social Insurance'],
            ['name' => 'Registral'],
            ['name' => 'Services'],
            ['name' => 'Vat Services'],
            ['name' => 'Consultants'],
            ['name' => 'Payroll'],
            ['name' => 'Management'],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
