<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimeSheet\StoreTimeSheetRequest;
use App\Http\Requests\TimeSheet\UpdateTimeSheetRequest;
use App\Models\Company;
use App\Models\Timesheet;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TimesheetController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Timesheet::class, 'timesheet');
    }


    public function index(): \Inertia\Response
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $timesheetsUsers = Timesheet::with(['user', 'company'])
                                        ->select('user_id')
                                        ->groupBy('user_id')
                                        ->paginate(10);

            return Inertia::render('TimeSheet/IndexAdmin', [
                'timesheetsUsers' => $timesheetsUsers,
            ]);

        } else {
            $timesheetsCompanies = Timesheet::with(['user', 'company'])
                                            ->where('user_id', $user->id)
                                            ->select('company_id')
                                            ->groupBy('company_id')
                                            ->paginate(36);

            //calculate total hours for each company for the user
            foreach ($timesheetsCompanies as $company) {
                $company->total_hours_for_user_in_company = Timesheet::getTotalHoursForUserInCompany($user->id, $company->company_id);
                $company->cost                            = $company->total_hours_for_user_in_company * $user->salary_per_hour;
            }

            return Inertia::render('TimeSheet/IndexUser', [
                'timesheetsCompanies' => $timesheetsCompanies,
            ]);
        }


    }

    public function store(StoreTimeSheetRequest $request): RedirectResponse
    {
        $timesheet = new Timesheet();
        $this->bindTimeSheet($request, $timesheet);

        $request->session()->flash('message', [
            'type'    => 'success',
            'message' => __('Timesheet has been created.')
        ]);

        return redirect()->back();
    }

    public function update(UpdateTimeSheetRequest $request, Timesheet $timesheet): RedirectResponse
    {
        $this->bindTimeSheet($request, $timesheet);

        $request->session()->flash('message', [
            'type'    => 'success',
            'message' => __('Timesheet has been updated.')
        ]);

        return redirect()->back();
    }

    public function destroy(Request $request, Timesheet $timesheet): RedirectResponse
    {
        $timesheet->delete();

        $request->session()->flash('message', [
            'type'    => 'success',
            'message' => __('Timesheet has been deleted.')
        ]);

        return redirect()->back();
    }

    public function massDestroy(Request $request): RedirectResponse
    {
        $this->authorize('massDelete', Timesheet::class);

        Timesheet::whereIn('id', collect($request->input('selected'))->pluck('id'))->delete();

        $request->session()->flash('message', [
            'type'    => 'success',
            'message' => __('TimeSheets have been deleted.')
        ]);

        return redirect()->back();
    }

    public function bindTimeSheet($request, Timesheet $timesheet): void
    {
        //can add custom code to alter the fields
        $data = $request->validated();
        $timesheet->fill($data);

        $timesheet->save();
    }

    public function getCompaniesByUserId(Request $request): JsonResponse
    {
        $userId    = $request->input('userId');
        $user      = User::find($userId);
        $companies = $user->companies;

        //calculate total hours for each company for the user
        foreach ($companies as $company) {
            $company->total_hours_for_user_in_company = Timesheet::getTotalHoursForUserInCompany($userId, $company->id);
            $company->cost                            = $company->total_hours_for_user_in_company * $user->salary_per_hour;
        }
        return response()->json($companies);
    }

    public function getTimeSheetsByUserIdCompanyId(Request $request): JsonResponse
    {
        $userId    = $request->input('userId');
        $companyId = $request->input('companyId');


        $timesheets = Timesheet::with('user', 'company')
                               ->where('user_id', $userId)
                               ->where('company_id', $companyId)
                               ->get();

        return response()->json($timesheets);
    }

}
