<?php

namespace App\Http\Controllers;

use App\Http\Requests\Service\StoreServiceRequest;
use App\Http\Requests\Service\UpdateServiceRequest;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Service::class, 'service');
    }


    public function index(Request $request): \Inertia\Response
    {
        return Inertia::render('Service/Index', [
            'services'   => Service::setUpQuery(request())->paginate($request->input('per_page', 10)),
            'dataColumns' => Service::getDataColumns([]),
        ]);
    }

    public function store(StoreServiceRequest $request): RedirectResponse
    {
        $service = new Service();
        $this->bindService($request, $service);

        $request->session()->flash('message', [
            'type'    => 'success',
            'message' => __('Service has been created.')
        ]);

        return redirect()->back();
    }

    public function update(UpdateServiceRequest $request, Service $service): RedirectResponse
    {
        $this->bindService($request, $service);

        $request->session()->flash('message', [
            'type'    => 'success',
            'message' => __('Service has been updated.')
        ]);

        return redirect()->back();
    }

    public function destroy(Request $request, Service $service): RedirectResponse
    {
        $service->delete();

        $request->session()->flash('message', [
            'type'    => 'success',
            'message' => __('Service has been deleted.')
        ]);

        return redirect()->back();
    }

    public function massDestroy(Request $request): RedirectResponse
    {
        $this->authorize('massDelete', Service::class);

        Service::whereIn('id', collect($request->input('selected'))->pluck('id'))->delete();

        $request->session()->flash('message', [
            'type'    => 'success',
            'message' => __('Services have been deleted.')
        ]);

        return redirect()->back();
    }

    public function bindService($request, Service $service): void
    {
        $data = $request->validated();

        $service->fill($data);

        $service->save();
    }
}
