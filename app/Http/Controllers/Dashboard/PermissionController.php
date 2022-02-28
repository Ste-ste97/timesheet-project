<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Inertia;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\StoreGroupRequest;
use App\Http\Requests\Permission\UpdateGroupRequest;
use App\Http\Requests\Permission\StorePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;

class PermissionController extends Controller
{

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Permission::class, 'permission');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Permission/Index', [
            'permissions' => Permission::whereNull('parent_id')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeGroup(StoreGroupRequest $request)
    {
        $permission = new Permission();

        $permission->name = $request->input('name');
        $permission->group_name = $request->input('name');
        $permission->guard_name = $request->input('guard_name');

        $permission->save();

        if ($request->input('is_crud')){
            $permission->makeCRUDPermissions($request);
        }

        $request->session()->flash('message', [
            'type' => 'success', // error, success, info
            'message' => __('Group has been created.')
        ]);

        return redirect()->route('permissions.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermissionRequest $request)
    {
        $permission = new Permission();
        $group = Permission::findOrFail($request->input('group'));

        $permission->name = $group->name . '.'. $request->input('type');
        $permission->group_name = $group->group_name;
        $permission->guard_name = $group->guard_name;
        $permission->parent_id = $group->id;
        $permission->description = $request->input('description');

        $permission->save();

        $request->session()->flash('message', [
            'type' => 'success', // error, success, info
            'message' => __('Permission has been created.')
        ]);

        return redirect()->route('permissions.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function updateGroup(UpdateGroupRequest $request, Permission $permission)
    {
        $permission->name = $request->input('name');
        $permission->group_name = $request->input('name');
        $permission->guard_name = $request->input('guard_name');
        $permission->save();

        $permission->children->map(function($child) use ($request){
            $child->name = $request->input('name').'.'.$child->type;
            $child->group_name =$request->input('name');
            $child->guard_name = $request->input('guard_name');
            $child->save();
        });

        $request->session()->flash('message', [
            'type' => 'success', // error, success, info
            'message' => __('Group has been updated.')
        ]);

        return redirect()->route('permissions.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $permission->name = $permission->group_name . '.'. $request->input('type');
        $permission->description = $request->input('description');

        $permission->save();

        $request->session()->flash('message', [
            'type' => 'success', // error, success, info
            'message' => __('Permission has been created.')
        ]);

        return redirect()->route('permissions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Permission $permission)
    {
        $permission->delete();

        $request->session()->flash('message', [
            'type' => 'success', // error, success, info
            'message' => __('Group/Permission has been deleted.')
        ]);

        return redirect()->route('permissions.index');
    }
}
