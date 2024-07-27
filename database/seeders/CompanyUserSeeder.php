<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;

class CompanyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::where('id', '!=', 1)->get();
        $companies = Company::all();

        foreach ($companies as $company) {
            $company->users()->attach($users->pluck('id')->toArray());
        }
    }
}
