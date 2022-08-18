<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\City;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use App\Models\Country;
use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Requests\Profile\UpdatePasswordRequest;
use App\Models\Address;

class ProfileController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index() {
        auth()->user()->load('address');

        return Inertia::render('Profile/Index', [
            'countries' => Country::all(),
            'cities'    => City::with('Country')->get(),
        ]);
    }

    /**
     * Update profile of the authenticated user.
     *
     * @param UpdateProfileRequest $request
     * @return RedirectResponse
     */

    public function updateProfile(UpdateProfileRequest $request): RedirectResponse {
        $user = auth()->user();

        $user->name  = $request->input('name');
        $user->email = $request->input('email');

        $address = $user->address ?? new Address();

        if (!$request->input('city') && $user->address) {
            $address->delete();
        } else {
            if ($request->input('city')) {
                $address->city_id = $request->input('city');
                $address->user()->associate($user);
                $address->state = $request->input('state');
                $address->save();
            }
        }

        $user->save();

        $request->session()->flash('message', [
            'type'    => 'success', // error, success, info
            'message' => __('Profile has been updated.')
        ]);

        return redirect()->route('profile');
    }


    /**
     * Update password of the authenticated user.
     *
     * @param UpdatePasswordRequest $request
     * @return RedirectResponse
     */

    public function updatePassword(UpdatePasswordRequest $request): RedirectResponse {
        $user = auth()->user();

        $user->password = bcrypt($request->input('new_password'));

        $user->save();

        $request->session()->flash('message', [
            'type'    => 'success', // error, success, info
            'message' => __('Profile has been updated.')
        ]);

        return redirect()->route('profile');
    }

}
