<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Models\Client;
use App\Models\User;
use Arr;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Client::class, 'client');
    }

    public function index(Request $request): Response
    {
        return Inertia::render('Client/Index', [
            'clients'     => Client::setUpQuery()->paginate($request->input('per_page', 10)),
            'dataColumns' => Client::getDataColumns(['id', 'name', 'is_private', 'mobile_phone', 'landline_phone', 'address', 'fax', 'postal_code']),
            'users'       => User::all(),
        ]);
    }

    public function store(StoreClientRequest $request): RedirectResponse
    {
        $client = Client::create($request->validated());

        //has permission to assign users to clients
        if (auth()->user()->hasPermissionTo('users.assign')) {
            $client->users()->sync($request->input('users'));
        }

        $request->session()->flash('message', [
            'type'    => 'success', // error, success, info
            'message' => __('Client has been created.')
        ]);

        return redirect()->back();
    }

    public function update(UpdateClientRequest $request, Client $client): RedirectResponse
    {
        $client->update($request->validated());

        //has permission to assign users to clients
        if (auth()->user()->hasPermissionTo('users.assign')) {
            $client->users()->sync($request->input('users'));
        }

        $request->session()->flash('message', [
            'type'    => 'success', // error, success, info
            'message' => __('Client has been updated.')
        ]);

        return redirect()->back();
    }

    public function destroy(Request $request, Client $client): RedirectResponse
    {
        $client->delete();

        $request->session()->flash('message', [
            'type'    => 'success', // error, success, info
            'message' => __('Client has been deleted.')
        ]);

        return redirect()->back();
    }

    public function massDestroy(Request $request): RedirectResponse
    {
        $this->authorize('delete', Client::class);
        $clientIDs = Arr::pluck($request->input('selected'), 'id');

        Client::whereIn('id', $clientIDs)->delete();

        $request->session()->flash('message', [
            'type'    => 'success', // error, success, info
            'message' => __('Clients have been deleted.')
        ]);

        return redirect()->route('clients.index');
    }
}
