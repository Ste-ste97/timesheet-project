<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\StoreContactRequest;
use App\Http\Requests\Contact\UpdateContactRequest;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Contact::class, 'contact');
    }


    public function index(Request $request): \Inertia\Response
    {
        return Inertia::render('Contact/Index', [
            'contacts'    => Contact::setUpQuery(request())->paginate($request->input('per_page', 10)),
            'dataColumns' => Contact::getDataColumns(['id', 'full_name', 'mobile_phone', 'landline_phone', 'address', 'fax', 'postal_code',]),
        ]);
    }

    public function store(StoreContactRequest $request): RedirectResponse
    {
        $contact = new Contact();
        $this->bindContact($request, $contact);

        $request->session()->flash('message', [
            'type'    => 'success',
            'message' => __('Contact has been created.')
        ]);

        return redirect()->back();
    }

    public function update(UpdateContactRequest $request, Contact $contact): RedirectResponse
    {
        $this->bindContact($request, $contact);

        $request->session()->flash('message', [
            'type'    => 'success',
            'message' => __('Contact has been updated.')
        ]);

        return redirect()->back();
    }

    public function destroy(Request $request, Contact $contact): RedirectResponse
    {
        $contact->delete();

        $request->session()->flash('message', [
            'type'    => 'success',
            'message' => __('Contact has been deleted.')
        ]);

        return redirect()->back();
    }

    public function massDestroy(Request $request): RedirectResponse
    {
        $this->authorize('massDelete', Contact::class);

        Contact::whereIn('id', collect($request->input('selected'))->pluck('id'))->delete();

        $request->session()->flash('message', [
            'type'    => 'success',
            'message' => __('Contacts have been deleted.')
        ]);

        return redirect()->back();
    }

    public function bindContact($request, Contact $contact): void
    {
        //can add custom code to alter the fields
        $data = $request->validated();

        $contact->fill($data);

        $contact->save();
    }
}
