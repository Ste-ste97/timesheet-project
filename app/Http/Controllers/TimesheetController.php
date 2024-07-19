<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimeSheet\StoreTimeSheetRequest;
use App\Http\Requests\TimeSheet\UpdateTimeSheetRequest;
use App\Models\Company;
use App\Models\Timesheet;
use App\Models\User;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TimesheetController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Timesheet::class, 'timesheet');
    }


    public function index(Request $request): \Inertia\Response
    {
        $user = Auth::user();

//        dd($user,$timesheets);
        return Inertia::render('TimeSheet/Index', [
//            'timesheets' => $timesheets,
        ]);
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
}
