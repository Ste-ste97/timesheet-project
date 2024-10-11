<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Timesheet;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Client;

class TimesheetSeeder extends Seeder
{
    public function run()
    {
        $users    = User::where('id', '!=', 1)->get();
        $clients  = Client::all();
        $services = Service::all();

        $months = [
            'January'   => ['date' => '2024-01-01', 'number' => 1],
            'February'  => ['date' => '2024-02-01', 'number' => 2],
            'March'     => ['date' => '2024-03-01', 'number' => 3],
            'April'     => ['date' => '2024-04-01', 'number' => 4],
            'May'       => ['date' => '2024-05-01', 'number' => 5],
            'June'      => ['date' => '2024-06-01', 'number' => 6],
            'July'      => ['date' => '2024-07-01', 'number' => 7],
            'August'    => ['date' => '2024-08-01', 'number' => 8],
            'September' => ['date' => '2024-09-01', 'number' => 9],
            'October'   => ['date' => '2024-10-01', 'number' => 10],
            'November'  => ['date' => '2024-11-01', 'number' => 11],
            'December'  => ['date' => '2024-12-01', 'number' => 12],
        ];

        foreach ($users as $user) {
            foreach ($clients as $client) {
                foreach ($months as $monthName => $monthData) {
                    foreach ($services as $service) {
                        Timesheet::create([
                            'user_id'      => $user->id,
                            'client_id'    => $client->id,
                            'service_id'   => $service->id,
                            'month'        => $monthName,
                            'date'         => $monthData['date'],
                            'month_number' => $monthData['number'],
                            'hours'        => rand(1, 8),
                        ]);
                    }
                }
            }
        }
    }
}
