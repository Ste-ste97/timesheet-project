<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TotalTimesheetsCostController extends Controller
{
    public function index(Request $request): Response
    {
        $timesheetsClients = Client::with('users')->get();
        $currentYear         = Carbon::now()->year;
        $year                = $currentYear;

        foreach ($timesheetsClients as $client) {
            $companyTotalCost = 0;

            foreach ($client->users as $user) {
                $user->total_hours_for_user_in_company = $user->totalHoursForCompany($client->id, $year);
                $user->total_cost_for_user_in_company  = $user->totalCostForCompany($client->id, $year);
                $companyTotalCost                      += $user->total_cost_for_user_in_company;
            }

            $client->total_cost = $companyTotalCost;
        }

        return Inertia::render('TotalTimeSheets/Index', [
            'timesheetsClients' => $timesheetsClients,
        ]);
    }

    public function changeYear(Request $request): JsonResponse
    {
        $timesheetsClients = Client::with('users')->get();
        $currentYear         = Carbon::now()->year;
        $year                = $request->input('year', $currentYear);

        foreach ($timesheetsClients as $client) {
            $companyTotalCost = 0;

            foreach ($client->users as $user) {
                $user->total_hours_for_user_in_company = $user->totalHoursForCompany($client->id, $year);
                $user->total_cost_for_user_in_company  = $user->totalCostForCompany($client->id, $year);
                $companyTotalCost                      += $user->total_cost_for_user_in_company;
            }

            $client->total_cost = $companyTotalCost;
        }

        return response()->json([
            'timesheetsClients' => $timesheetsClients,
        ]);
    }

}
