<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimeSheet\StoreTimeSheetRequest;
use App\Http\Requests\TimeSheet\UpdateTimeSheetRequest;
use App\Models\Company;
use App\Models\Timesheet;
use App\Models\User;
use Auth;
use DateTime;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

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
            $timesheetsUsers = User::where('is_admin', 0)->get();

            return Inertia::render('TimeSheet/IndexAdmin', [
                'timesheetsUsers' => $timesheetsUsers,
            ]);

        } else {
            //get user companies
            $timesheetsCompanies = $user->companies;

            $currentYear = Carbon::now()->year;
            //calculate total hours for each company for the user
            foreach ($timesheetsCompanies as $company) {
                $company->total_hours_for_user_in_company = $user->totalHoursForCompany($company->id, $currentYear);
                $company->cost                            = $user->totalCostForCompany($company->id, $currentYear);
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
        $timesheet->user_id    = $request->input('userId');
        $timesheet->company_id = $request->input('companyId');
        $timesheet->service_id = $request->input('serviceId');

        $timesheet->date         = date('Y-m-d H:i:s', strtotime($request->input('date')));
        $monthNumber             = date('n', strtotime($request->input('date')));
        $timesheet->month_number = $monthNumber;
        $timesheet->month        = DateTime::createFromFormat('!m', $monthNumber)->format('F');
        $timesheet->hours        = $request->input('hours');

        $timesheet->save();
    }

    public function getCompanies(Request $request): JsonResponse
    {
        $userId       = $request->input('userId');
        $user         = User::find($userId);
        $companies    = $user->companies;
        $selectedYear = $request->input('selectedYear');

        //calculate total hours for each company for the user
        foreach ($companies as $company) {
            $company->total_hours_for_user_in_company = $user->totalHoursForCompany($company->id, $selectedYear);
            $company->cost                            = $user->totalCostForCompany($company->id, $selectedYear);
        }
        return response()->json($companies);
    }

    public function getMonthlyTimeSheets(Request $request): JsonResponse
    {
        $userId    = $request->input('userId');
        $companyId = $request->input('companyId');


        $timesheets = Timesheet::with('user', 'company')
                               ->where('user_id', $userId)
                               ->where('company_id', $companyId)
                               ->get()
                               ->groupBy('month');

        $monthOrder = [
            'January'   => 1,
            'February'  => 2,
            'March'     => 3,
            'April'     => 4,
            'May'       => 5,
            'June'      => 6,
            'July'      => 7,
            'August'    => 8,
            'September' => 9,
            'October'   => 10,
            'November'  => 11,
            'December'  => 12,
        ];
        $timesheets = $timesheets->sortKeysUsing(function ($key1, $key2) use ($monthOrder) {
            return $monthOrder[$key1] <=> $monthOrder[$key2];
        });


        return response()->json($timesheets);
    }

    public function getServices(Request $request): JsonResponse
    {
        $userId       = $request->input('userId');
        $companyId    = $request->input('companyId');
        $month        = $request->input('monthNumber');
        $selectedYear = $request->input('selectedYear');

        $timesheets = Timesheet::with('user', 'company', 'service')
                               ->where('user_id', $userId)
                               ->where('company_id', $companyId)
                               ->where('month_number', $month)
                               ->whereBetween('date', [
                                   "{$selectedYear}-01-01",
                                   "{$selectedYear}-12-31"
                               ])
                               ->get();

        return response()->json($timesheets);
    }

}
