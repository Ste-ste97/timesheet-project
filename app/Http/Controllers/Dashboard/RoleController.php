<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Models\Permission;

class RoleController extends Controller
{

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->authorizeResource(Role::class, 'role');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response {
        return Inertia::render('Role/Index', [
            'roles'       => Role::with('permissions')->get(),
            'permissions' => Permission::whereNull('parent_id')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRoleRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRoleRequest $request): RedirectResponse {
        $role       = new Role();
        $role->name = $request->input('name');
        $role->save();

        // has permission to assign permissions
        if (auth()->user()->hasPermissionTo('permissions.assign')) {
            $role->syncPermissions($request->input('permissions'));
        }

        $request->session()->flash('message', [
            'type'    => 'success', // error, success, info
            'message' => __('Role has been created.')
        ]);

        return redirect()->route('roles.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRoleRequest $request
     * @param Role              $role
     * @return RedirectResponse
     */
    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse {
        $role->name = $request->input('name');

        $role->save();

        // has permission to assign permissions
        if (auth()->user()->hasPermissionTo('permissions.assign')) {
            $role->syncPermissions($request->input('permissions'));
        }

        $request->session()->flash('message', [
            'type'    => 'success', // error, success, info
            'message' => __('Role has been updated.')
        ]);

        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Role    $role
     * @return RedirectResponse
     */
    public function destroy(Request $request, Role $role): RedirectResponse {
        $role->delete();

        $request->session()->flash('message', [
            'type'    => 'success', // error, success, info
            'message' => __('Role has been deleted.')
        ]);

        return redirect()->route('roles.index');
    }


    /**
     * Remove all the specified resource from storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function massDestroy(Request $request): RedirectResponse {
        $this->authorize('delete', Role::class);

        Role::whereIn('id', collect($request->input('roles'))->pluck('id'))->delete();

        $request->session()->flash('message', [
            'type'    => 'success', // error, success, info
            'message' => __('Role has been deleted.')
        ]);

        return redirect()->route('roles.index');
    }
}
