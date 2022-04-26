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
use Illuminate\Support\Str;

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
            $this->create_tenant_admin($input['database'], $user->email);

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
        // Artisan::call('db:seed --class=CreateAdminUserSeeder');
        // Artisan::call('db:seed --class=PermissionTableSeeder');
        return;
    }

    public function create_tenant_admin($db_name, $admin_email, $connection='tenant')
    {
        $connection = 'tenant';
        $database_host = config('database.connections.'.$connection.'.host');
        $database_user = config('database.connections.'.$connection.'.username');
        $database_password = config('database.connections.'.$connection.'.password');

        $mysqli = new \mysqli($database_host, $database_user, $database_password, $db_name);
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }

        $token = Str::random(10);
        $password = bcrypt('password');
        $sql = "INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (NULL, 'Admin', ?, now(), ?, ?, now(), now())";
        $stmt = $mysqli->prepare($sql);

        $stmt->bind_param('sss', $admin_email, $password, $token);
        $stmt->execute();

        $user_id = $mysqli->insert_id;
        
        print_r(mysqli_error($mysqli));

        printf ("\n\n New user added. ID: %d.\n", $user_id);

        $query = "INSERT INTO `permissions` VALUES (NULL, 'create', 'web', now(), now()), (NULL, 'read', 'web', now(), now()), (NULL, 'update', 'web', now(), now()), (NULL, 'delete', 'web', now(), now())";
        $mysqli->query($query);
        printf ("\n\n Permission added.\n");

        $query = "INSERT INTO `roles` VALUES (NULL, 'admin', 'web', now(), now())";
        $mysqli->query($query);

        $role_id = $mysqli->insert_id;

        printf ("New role added. ID: %d.\n", $role_id);
        
        // $query = "INSERT INTO `role_has_permissions` VALUES (NULL, 'admin', 'web', now(), now())";
        // $mysqli->query($query);

        $stmt = $mysqli->prepare("SELECT `id` FROM `permissions`");
        $stmt->execute();

        $data = $stmt->get_result();

        while($row = mysqli_fetch_array($data)){
            $permission_id = $row['id'];
            $query = "INSERT INTO `role_has_permissions` VALUES ($permission_id, $role_id)";
            $mysqli->query($query);
            
            printf ("New role permission added. Role ID: %d and Permission ID: %d.\n", $role_id, $permission_id);
        }

        $query = "INSERT INTO `model_has_roles` VALUES ($role_id, 'App\Models\User', $user_id)";
        $mysqli->query($query);

        printf ("New model_has_roles added. Role ID: %d and User ID: %d.\n", $role_id, $user_id);

        $mysqli->close();

        // config(['database.connections.'.$connection.'.database' => $db_name]);
        // DB::purge($connection);
        // DB::reconnect($connection);
        // $user = new User();
        // $user = $user->setConnection($connection)->create([
        // // $user = DB::connection($connection)->table('users')->insert([
        //     'name' => 'Admin', 
        //     'email' => $admin_user->email,
        //     'password' => bcrypt('password')
        // ]);

        // $role = new TenantRole();
        // // config(['database.connections.'.$connection.'.database' => $db_name]);
        // $role = $role->setConnection($connection)->create(['name' => 'admin']);
        // // dd(config('database.connections.'.$connection.'.database'), DB::connection());
     
        // $permissions = new TenantPermission();
        // // config(['database.connections.'.$connection.'.database' => $db_name]);
        // $permissions = $permissions->setConnection($connection)->pluck('id','id')->all();
        // // dd($permissions);
   
        // // $role->syncPermissions($permissions);
        // // config(['database.connections.'.$connection.'.database' => $db_name]);
        // $role->permissions()->sync($permissions);
     
        // // config(['database.connections.'.$connection.'.database' => $db_name]);
        // $user->assignRole([$role->id]);
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
