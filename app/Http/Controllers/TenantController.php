<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Http\Requests\TenantRequest;
use App\Models\Plan;
use App\Models\TenantPermission;
use App\Models\TenantRole;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use PDO;

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

        $user = User::find((int) $input['user_id']);
        
        $db_created = $this->create_db($input['database']);
        
        if ($db_created === true) {
            $this->tenant_db_migration($input['database']);
            $user = User::find($input['user_id']);
            $this->create_tenant_admin($input['database'], $user);

            $tenant = Tenant::create($input);
            return redirect()->route('tenants.index', app()->getLocale())
                        ->with('success','Tenant created successfully');
        }
        return redirect()->back()
                        ->with('error', $db_created);
    }

    public function create_db($db_name)
    {
        try{
            $connection = 'tenant';
   
            $hasDb = DB::connection($connection)->select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = " . "'" . $db_name . "'");
   
            if(empty($hasDb)) {
                DB::connection($connection)->select('CREATE DATABASE `'. $db_name . '`');
                $this->tenant_db_migration($db_name);

                return true;
            }
            else {
                return "Database `$db_name` already exists for $connection connection";
            }
        }
        catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function tenant_db_migration($db_name, $connection='tenant')
    {
        config(['database.connections.'.$connection.'.database' => $db_name]);
        Schema::connection($connection)->getConnection()->reconnect();
        Artisan::call('migrate:fresh --path=database/migrations/tenant --database='. $connection);
        Artisan::call('db:seed --class=PermissionTableSeeder');
        return;
    }

    public function create_tenant_admin($db_name, $user, $connection='tenant')
    {
        config(['database.connections.'.$connection.'.database' => $db_name]);
        $user = DB::connection('tenant')->table('users')->create([
            'name' => 'Admin', 
            'email' => $user->email,
            'password' => bcrypt('password')
        ]);
    
        $role = TenantRole::create(['name' => 'admin']);
     
        $permissions = TenantPermission::pluck('id','id')->all();
        // dd($permissions);
   
        // $role->syncPermissions($permissions);
        $role->permissions()->sync($permissions);
     
        $user->assignRole([$role->id]);
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
