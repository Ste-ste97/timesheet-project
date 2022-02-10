<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Role/Index', [
            'roles' => Role::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    {
        $role = new Role();
        $role->name = $request->input('name');

        $role->save();

        $request->session()->flash('message', [
            'type' => 'success', // error, success, info
            'message' => __('Role has been created.')
        ]);

        return redirect()->route('roles.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->name = $request->input('name');

        $role->save();

        $request->session()->flash('message', [
            'type' => 'success', // error, success, info
            'message' => __('Role has been updated.')
        ]);

        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Role  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Role $role)
    {
        $role->delete();

        $request->session()->flash('message', [
            'type' => 'success', // error, success, info
            'message' => __('Role has been deleted.')
        ]);

        return redirect()->route('roles.index');
    }


    /**
     * Remove all the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function massDestroy(Request $request)
    {

        Role::whereIn('id', collect($request->input('roles'))->pluck('id'))->delete();

        $request->session()->flash('message', [
            'type' => 'success', // error, success, info
            'message' => __('Role has been deleted.')
        ]);

        return redirect()->route('roles.index');
    }
}
