<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Timesheet;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TotalTimesheetsCostController extends Controller
{
    public function index(): \Inertia\Response
    {
        $timesheetsCompanies = Company::with('users')->get();

        foreach ($timesheetsCompanies as $company) {
            $companyTotalCost = 0;

            foreach ($company->users as $user) {
                $user->total_hours_for_user_in_company = $user->totalHoursForCompany($company->id);
                $user->total_cost_for_user_in_company = $user->totalCostForCompany($company->id);
                $companyTotalCost += $user->total_cost_for_user_in_company;
            }

            $company->total_cost = $companyTotalCost;
        }

        return Inertia::render('TotalTimeSheets/Index', [
            'timesheetsCompanies' => $timesheetsCompanies,
        ]);
    }

}
