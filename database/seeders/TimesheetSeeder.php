<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Timesheet;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;

class TimesheetSeeder extends Seeder
{
    public function run()
    {
        $users     = User::where('id', '!=', 1)->get();
        $companies = Company::all();
        $services  = Service::all();

        // Define the first day of each month
        $months = [
            'January'   => '2024-01-01',
            'February'  => '2024-02-01',
            'March'     => '2024-03-01',
            'April'     => '2024-04-01',
            'May'       => '2024-05-01',
            'June'      => '2024-06-01',
            'July'      => '2024-07-01',
            'August'    => '2024-08-01',
            'September' => '2024-09-01',
            'October'   => '2024-10-01',
            'November'  => '2024-11-01',
            'December'  => '2024-12-01',
        ];

        foreach ($users as $user) {
            foreach ($companies as $company) {
                foreach ($services as $service) {
                    foreach ($months as $monthName => $firstDay) {
                        Timesheet::create([
                            'user_id'    => $user->id,
                            'company_id' => $company->id,
                            'service_id' => $service->id,
                            'month'      => $monthName,
                            'date'       => $firstDay, // Store the first day of the month
                            'hours'      => rand(1, 8),
                        ]);
                    }
                }
            }
        }
    }
}
