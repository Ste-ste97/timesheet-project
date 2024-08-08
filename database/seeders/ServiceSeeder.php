<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\User;
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


        $users = User::all();
        $services = Service::all();

        foreach ($users as $user) {
            foreach ($services as $service) {
                $cost = $user->is_admin ? 50 : 20;
                $user->services()->attach($service->id, ['cost_per_hour' => $cost]);
            }
        }


    }
}
