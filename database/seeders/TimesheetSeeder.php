<?php

namespace Database\Seeders;

use App\Models\Timesheet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TimesheetSeeder extends Seeder
{
    public function run(): void
    {
        $months = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December'
        ];

        for ($user_id = 2; $user_id <= 11; $user_id++) {
            for ($company_id = 1; $company_id <= 36; $company_id++) {
                foreach ($months as $month) {
                    Timesheet::create([
                        'user_id'    => $user_id,
                        'company_id' => $company_id,
                        'month'      => $month,
                    ]);
                }
            }
        }
    }
}
