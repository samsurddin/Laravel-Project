<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
    
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        //  $this->middleware('permission:list|create|edit|delete', ['only' => ['index','store']]);
        //  $this->middleware('permission:create', ['only' => ['create','store']]);
        //  $this->middleware('permission:edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::orderBy('id','DESC')->paginate(5);
        return view('roles.index', compact('roles'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::get();
        return view('roles.create', compact('permissions'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($lang, Request $request)
    {
        $input = $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'nullable',
        ]);
    
        $role = Role::create(['name' => $input['name']]);

        if (isset($input['permission'])) {
            $role->syncPermissions($input['permission']);
        }
    
        return redirect()->route('roles.index', app()->getLocale())
                        ->with('success','Role created successfully');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($lang, Role $role)
    {
        // $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
        //     ->where("role_has_permissions.role_id", $id)
        //     ->get();
        $rolePermissions = $role->permissions;
    
        return view('roles.show', compact('role', 'rolePermissions'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($lang, Role $role)
    {
        // $role = Role::find($id);
        $permissions = Permission::get();
        // $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
        //     ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
        //     ->all();
        $rolePermissions = $role->permissions;
    
        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($lang, Request $request, Role $role)
    {
        $input = $this->validate($request, [
            'name' => 'required',
            'permission' => 'nullable',
        ]);
    
        // $role = Role::find($id);
        $role->name = $input['name'];
        $role->save();
    
        if (isset($input['permission'])) {
            $role->syncPermissions($input['permission']);
        }
    
        return redirect()->route('roles.index', app()->getLocale())
                        ->with('success','Role updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang, Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index', app()->getLocale())
                        ->with('success','Role deleted successfully');
    }
}