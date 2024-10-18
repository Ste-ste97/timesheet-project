<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimeSheet\StoreTimeSheetRequest;
use App\Http\Requests\TimeSheet\UpdateTimeSheetRequest;
use App\Models\Client;
use App\Models\Service;
use App\Models\Timesheet;
use App\Models\User;
use Auth;
use DateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Carbon\Carbon;
use Inertia\Response;

class TimesheetController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Timesheet::class, 'timesheet');
    }

    public function index(): Response
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $timesheetsUsers = User::where('is_admin', 0)->get();

            return Inertia::render('TimeSheet/IndexAdmin', [
                'timesheetsUsers' => $timesheetsUsers,
            ]);

        } else {
            //get user clients
            $timesheetsClients = $user->clients;

            $currentYear = Carbon::now()->year;
            //calculate total hours for each client for the user
            foreach ($timesheetsClients as $client) {
                $client->total_hours_for_user_in_company = $user->totalHoursForCompany($client->id, $currentYear);
                $client->cost                            = $user->totalCostForCompany($client->id, $currentYear);
            }


            return Inertia::render('TimeSheet/IndexUser', [
                'timesheetsClients' => $timesheetsClients,
            ]);
        }
    }

    public function search(): Response
    {
        $this->authorize('search', Timesheet::class);

        $timesheets = Timesheet::publicSearch()->paginate(request('per_page', 10));


        return Inertia::render('TimeSheet/IndexWithFilter', [
            'timesheets' => $timesheets,
            'users'    => User::where('is_admin', 0)->get(),
            'clients'  => Client::all(),
            'services' => Service::all()
        ]);
    }

    public function store(StoreTimeSheetRequest $request): RedirectResponse
    {
        $timesheet = new Timesheet();
        $this->bindTimeSheet($request, $timesheet);
        $serviceUser                    = DB::table('service_user')
                                            ->where('user_id', $timesheet->user_id)
                                            ->where('service_id', $timesheet->service_id)
                                            ->first();
        $timesheet->current_hourly_rate = $serviceUser->cost_per_hour ?? 0;
        $timesheet->save();

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
        $timesheet->client_id  = $request->input('clientId');
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
        $clients      = $user->clients;
        $selectedYear = $request->input('selectedYear');

        //calculate total hours for each client for the user
        foreach ($clients as $client) {
            $client->total_hours_for_user_in_company = $user->totalHoursForCompany($client->id, $selectedYear);
            $client->cost                            = $user->totalCostForCompany($client->id, $selectedYear);
        }
        return response()->json($clients);
    }

    public function getMonthlyTimeSheets(Request $request): JsonResponse
    {
        $userId    = $request->input('userId');
        $companyId = $request->input('clientId');


        $timesheets = Timesheet::with('user', 'client')
                               ->where('user_id', $userId)
                               ->where('client_id', $companyId)
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
        $companyId    = $request->input('clientId');
        $month        = $request->input('monthNumber');
        $selectedYear = $request->input('selectedYear');

        $timesheets = Timesheet::with('user', 'client', 'service')
                               ->where('user_id', $userId)
                               ->where('client_id', $companyId)
                               ->where('month_number', $month)
                               ->whereBetween('date', [
                                   "{$selectedYear}-01-01",
                                   "{$selectedYear}-12-31"
                               ])
                               ->get();

        return response()->json($timesheets);
    }

}
