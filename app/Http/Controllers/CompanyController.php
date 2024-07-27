<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Company::class, 'company');
    }


    public function index(Request $request): \Inertia\Response
    {
        return Inertia::render('Company/Index', [
            'companies'   => Company::setUpQuery(request())->paginate($request->input('per_page', 10)),
            'dataColumns' => Company::getDataColumns([]),
        ]);
    }

    public function store(StoreCompanyRequest $request): RedirectResponse
    {
        $company = new Company();
        $this->bindCompany($request, $company);

        $request->session()->flash('message', [
            'type'    => 'success',
            'message' => __('Company has been created.')
        ]);

        return redirect()->back();
    }

    public function update(UpdateCompanyRequest $request, Company $company): RedirectResponse
    {
        $this->bindCompany($request, $company);

        $request->session()->flash('message', [
            'type'    => 'success',
            'message' => __('Company has been updated.')
        ]);

        return redirect()->back();
    }

    public function destroy(Request $request, Company $company): RedirectResponse
    {
        $company->delete();

        $request->session()->flash('message', [
            'type'    => 'success',
            'message' => __('Company has been deleted.')
        ]);

        return redirect()->back();
    }

    public function massDestroy(Request $request): RedirectResponse
    {
        $this->authorize('massDelete', Company::class);

        Company::whereIn('id', collect($request->input('selected'))->pluck('id'))->delete();

        $request->session()->flash('message', [
            'type'    => 'success',
            'message' => __('Companies have been deleted.')
        ]);

        return redirect()->back();
    }

    public function bindCompany($request, Company $company): void
    {
        //can add custom code to alter the fields
        $data = $request->validated();

        $company->fill($data);

        $company->save();
    }
}
