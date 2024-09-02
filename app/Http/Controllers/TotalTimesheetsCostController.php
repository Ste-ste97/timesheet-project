<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TotalTimesheetsCostController extends Controller
{
    public function index(Request $request): Response
    {
        $timesheetsCompanies = Company::with('users')->get();
        $currentYear         = Carbon::now()->year;
        $year                = $currentYear;

        foreach ($timesheetsCompanies as $company) {
            $companyTotalCost = 0;

            foreach ($company->users as $user) {
                $user->total_hours_for_user_in_company = $user->totalHoursForCompany($company->id, $year);
                $user->total_cost_for_user_in_company  = $user->totalCostForCompany($company->id, $year);
                $companyTotalCost                      += $user->total_cost_for_user_in_company;
            }

            $company->total_cost = $companyTotalCost;
        }

        return Inertia::render('TotalTimeSheets/Index', [
            'timesheetsCompanies' => $timesheetsCompanies,
        ]);
    }

    public function changeYear(Request $request): JsonResponse
    {
        $timesheetsCompanies = Company::with('users')->get();
        $currentYear         = Carbon::now()->year;
        $year                = $request->input('year', $currentYear);

        foreach ($timesheetsCompanies as $company) {
            $companyTotalCost = 0;

            foreach ($company->users as $user) {
                $user->total_hours_for_user_in_company = $user->totalHoursForCompany($company->id, $year);
                $user->total_cost_for_user_in_company  = $user->totalCostForCompany($company->id, $year);
                $companyTotalCost                      += $user->total_cost_for_user_in_company;
            }

            $company->total_cost = $companyTotalCost;
        }

        return response()->json([
            'timesheetsCompanies' => $timesheetsCompanies,
        ]);
    }

}
