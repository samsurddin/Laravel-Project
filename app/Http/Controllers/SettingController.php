<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Http\Requests\StoreSettingRequest;
use App\Http\Requests\UpdateSettingRequest;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::orderBy('id','DESC')->paginate(5);
        return view('settings.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSettingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store($lang, StoreSettingRequest $request)
    {
        $input = $this->validate($request, [
            'key' => 'required|unique:settings,key',
            'value' => 'nullable',
        ]);
    
        $role = Setting::create($input);
    
        return redirect()->route('settings.index', app()->getLocale())
                        ->with('success','Settings saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show($lang, Setting $setting)
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
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit($lang)
    {
        $permissions = Permission::get();
        $rolePermissions = $role->permissions->pluck('id')->toArray();
    
        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSettingRequest  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update($lang, UpdateSettingRequest $request, Setting $setting)
    {
        $input = $this->validate($request, [
            'name' => 'required',
            'permission' => 'nullable',
        ]);
    
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
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang, Setting $setting)
    {
        $role->delete();
        return redirect()->route('roles.index', app()->getLocale())
                        ->with('success','Role deleted successfully');
    }
}
