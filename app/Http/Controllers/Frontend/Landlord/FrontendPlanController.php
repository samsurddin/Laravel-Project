<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\User;
use App\Models\Tenant;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Enums\BillType;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class FrontendPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(now(), now()->addDay(), now()->subDay(), now()->addDays(1), now()->subDays(1), now()->addMonth(), now()->subMonth(), now()->addMonths(1), now()->subMonths(1), now()->addYear(), now()->subYear(), now()->addYears(1), now()->subYears(1));

        $plans = Plan::all();
        $max_discount = $plans->max('discount');
        $max_discount_yearly = $plans->max('discount_yearly');
        // dd($max_discount, $max_discount_yearly);
        return view('frontend.plans.index', compact('plans', 'max_discount', 'max_discount_yearly'));
    }

    public function signup($lang, Request $request, $plan)
    {
        // dd($lang, $request, (int) $plan);
        $bill_type = $request->bill_type;
        $plans = Plan::all()->map->only(['id', 'name', 'price', 'price_yearly', 'discount', 'discount_yearly']);
        $plan = Plan::find((int) $plan);
        // dd($plan);
        return view('frontend.plans.signup', compact('plans', 'plan', 'bill_type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        // validation
        $valid = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:App\Models\User'],
            'password' => ['required', 'confirmed', Password::defaults()],

            'tenant_name' => 'required|string|max:255',
            // 'domain' => 'required|string|regex:/^(?!:\/\/)(?=.{1,255}$)((.{1,63}\.){1,127}(?![0-9]*$)[a-z0-9-]+\.?)$/i|unique:App\Models\Tenant,domain',
            'domain' => 'required|string|regex:/^[a-zA-Z0-9][a-zA-Z0-9.-]+[a-zA-Z0-9]$/|unique:App\Models\Tenant,domain',
            'plan' => 'required',
            // 'bill_type' => [new Enum(BillType::class)]
            'bill_type' => ['required', Rule::in(['monthly','annually'])]
        ]);
        // dd($valid);

        // register
        $user = User::create([
            'name' => $valid['name'],
            'email' => $valid['email'],
            'password' => Hash::make($valid['password']),
        ]);

        event(new Registered($user));

        // create new tenant
        $tenant = [
            'name' => $valid['tenant_name'],
            'domain' => $valid['domain'].'.mtdev.kit',
            'status' => 'active',
            'user_id' => $user->id,
            'plan_id' => $valid['plan']
        ];

        $tenant['plan_expire_datetime'] = now()->addMonth();
        if ($valid['bill_type'] == 'annually') {
            $tenant['plan_expire_datetime'] = now()->addYear();
        }
        $tenant['database'] = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', str_replace('.', '-', $tenant['domain'])));

        // $user = User::find((int) $tenant['user_id']);
        
        $db_created = $this->create_db($tenant['database']);
        
        if ($db_created === true) {
            $this->tenant_db_migration($tenant['database']);
            // $user = User::find($tenant['user_id']);
            $this->create_tenant_admin($tenant['database'], $user->email);

            $tenant = Tenant::create($tenant);
            // return redirect()->route('tenants.index', app()->getLocale())
                        // ->with('success','Tenant created successfully');

            Auth::login($user);
            return redirect(RouteServiceProvider::HOME);
        }
        return redirect()->route('signup', app()->getLocale())
                    ->with('error','ERROR: Database could not created! Please contact to administrator.');
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
        
        // print_r(mysqli_error($mysqli));

        // printf ("\n\n New user added. ID: %d.\n", $user_id);

        $query = "INSERT INTO `permissions` VALUES (NULL, 'create', 'web', now(), now()), (NULL, 'read', 'web', now(), now()), (NULL, 'update', 'web', now(), now()), (NULL, 'delete', 'web', now(), now())";
        $mysqli->query($query);
        // printf ("\n\n Permission added.\n");

        $query = "INSERT INTO `roles` VALUES (NULL, 'admin', 'web', now(), now())";
        $mysqli->query($query);

        $role_id = $mysqli->insert_id;

        // printf ("New role added. ID: %d.\n", $role_id);
        
        // $query = "INSERT INTO `role_has_permissions` VALUES (NULL, 'admin', 'web', now(), now())";
        // $mysqli->query($query);

        $stmt = $mysqli->prepare("SELECT `id` FROM `permissions`");
        $stmt->execute();

        $data = $stmt->get_result();

        while($row = mysqli_fetch_array($data)){
            $permission_id = $row['id'];
            $query = "INSERT INTO `role_has_permissions` VALUES ($permission_id, $role_id)";
            $mysqli->query($query);
            
            // printf ("New role permission added. Role ID: %d and Permission ID: %d.\n", $role_id, $permission_id);
        }

        $query = "INSERT INTO `model_has_roles` VALUES ($role_id, 'App\Models\User', $user_id)";
        $mysqli->query($query);

        // printf ("New model_has_roles added. Role ID: %d and User ID: %d.\n", $role_id, $user_id);

        $mysqli->close();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
