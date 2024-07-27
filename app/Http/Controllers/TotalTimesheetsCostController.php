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
        $timesheetsCompanies = Timesheet::with(['user', 'company'])
                                        ->select('company_id')
                                        ->groupBy('company_id')
                                        ->paginate(36);

        $users = User::all();

        //calculate total hours for each company for the user
        foreach ($timesheetsCompanies as $company) {
            $company->total_hours_for_user_in_company = 0;
            foreach ($users as $user) {
                $company->total_hours_for_user_in_company += Timesheet::getTotalHoursForUserInCompany($user->id, $company->company_id);
                $company->cost                            = $company->total_hours_for_user_in_company * $user->salary_per_hour;
            }
        }


        return Inertia::render('TotalTimeSheets/Index', [
            'timesheetsCompanies' => $timesheetsCompanies,
        ]);
    }

    public function getUserTotalCostByCompanyId(Request $request): \Illuminate\Http\JsonResponse
    {

        $company_id = $request->input('companyId');

        $company = Company::find($company_id);

        $users = $company->users;

        foreach ($users as $user) {
            $user->total_hours = Timesheet::getTotalHoursForUserInCompany($user->id, $company_id);
            $user->cost = $user->total_hours * $user->salary_per_hour;
        }


        return response()->json($users);
    }

}
