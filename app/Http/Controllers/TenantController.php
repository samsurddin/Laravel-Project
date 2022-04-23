<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Http\Requests\TenantRequest;
use App\Models\Plan;
use App\Models\User;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tenants = Tenant::with('user')->with('plan')->orderBy('id','DESC')->paginate(5);
        return view('tenants.index', compact('tenants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        $plans = Plan::all();
        return view('tenants.create', compact('users', 'plans'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TenantRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store($lang, TenantRequest $request)
    {
        $input = $request->validated();
        $input['plan_expire_datetime'] = now()->subDays(30);
        $input['database'] = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', str_replace('.', '-', $input['domain'])));
    
        $tenant = Tenant::create($input);
    
        return redirect()->route('tenants.index', app()->getLocale())
                        ->with('success','Tenant created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tenant  $tenant
     * @return \Illuminate\Http\Response
     */
    public function show($lang, Tenant $tenant)
    {
        return view('tenants.show', compact('tenant'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tenant  $tenant
     * @return \Illuminate\Http\Response
     */
    public function edit($lang, Tenant $tenant)
    {
        $users = User::all();
        $plans = Plan::all();
        return view('tenants.edit', compact('tenant', 'users', 'plans'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TenantRequest  $request
     * @param  \App\Models\Tenant  $tenant
     * @return \Illuminate\Http\Response
     */
    public function update($lang, TenantRequest $request, Tenant $tenant)
    {
        $input = $request->validated();
        // $input['plan_expire_datetime'] = now();
        $input['database'] = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', str_replace('.', '-', $input['domain'])));

        $tenant->update($input);
    
        return redirect()->route('tenants.index', app()->getLocale())
                        ->with('success','Tenant updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tenant  $tenant
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang, Tenant $tenant)
    {
        $tenant->delete();
        return redirect()->route('tenants.index', app()->getLocale())
                        ->with('success','Tenant deleted successfully');
    }
}
