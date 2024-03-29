<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

use App\Http\Controllers\RoleController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\UserController;

// ecommerce admin
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\SpecificationController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\QuestionAnswerController;

// ecommerce front
// use App\Http\Controllers\Frontend\ProductController as FrontProductController;

use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Spatie\Multitenancy\Models\Tenant;


use App\Http\Controllers\admin\InvoiceController;

use App\Http\Controllers\admin\CustomerController;

// landlord-frontend
use App\Http\Controllers\Frontend\Landlord\FrontendPlanController;

use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::prefix('piyal')->group(function()
// {
//     Route::resource('customers');
// });

// Route::get('/',[CustomerController::class,'index'])
// Route::get('/', 'CustomerController@index')
// Route::get('/',function(){
// })
// Route::get('/', null)
// Route::get('/')


Route::group(['prefix' => '{locale}', 'where' => ['locale' => '[a-zA-Z]{2}']], function()
{
    require __DIR__.'/auth.php';
    
    Route::get('/', function () {
        if (!Tenant::checkCurrent()) {
            // dd(\App\Models\LandlordUser::all());
        }
        // dd(DB::connection()->getDatabaseName());
        // dd(\Spatie\Multitenancy\Models\Tenant::current());
        return view('welcome');
    });

    Route::get('/images/image-upload', [ImageController::class, 'createForm']);
    Route::post('/images/image-upload', [ImageController::class, 'fileUpload'])->name('imageUpload');
            
    Route::get('clear_cache', function () {
        Artisan::call('cache:clear');
        dd("Cache is cleared");
    });
    Route::get('/linkstorage', function () {
        Artisan::call('storage:link');
        dd("storage link generated");
    });

    Route::group(['middleware' => ['auth']], function()
    {
        // admin routes for all
        Route::prefix('admin')->name('admin.')->group(function()
        {
            Route::resource('users', UserController::class);
            Route::resource('roles', RoleController::class);
            
            Route::get('/dashboard', function () {
                return view('dashboard');
            })->name('dashboard');

            // tenants admin routes
            Route::middleware('tenant')->group(function ()
            {
                Route::resource('invoices', InvoiceController::class);
                Route::resource('customers', CustomerController::class);
                

                // Route::get('check-segment',function(){
                //     $segment1 =  Request::segment(1);
                //     echo $segment1.'/'.app()->getLocale().'/'.request()->path();
                // });
               
                
                Route::resource('settings', SettingController::class)->except([
                    'show'
                ]);
                // Route::get('settings/edit', [SettingController::class, 'edit'])->name('settings.edit');

                Route::resources([
                    'images' => ImageController::class,
                    // 'invoices', InvoiceController::class,
                ]);
            });

            // landlord admin routes
            Route::middleware('landlord')->group(function ()
            {


               
               
                Route::get('/samsur', function()
                {
                    echo "hi samsur";
                });
                
                Route::resource('tenants', TenantController::class);
                Route::resource('plans', PlanController::class);

                Route::get('create/db/{db_name}/{admin_email}', function ($lang, $db_name, $admin_email) {
                    // dd($admin_email);

                    $connection = 'tenant';
                    $database_host = config('database.connections.'.$connection.'.host');
                    $database_user = config('database.connections.'.$connection.'.username');
                    $database_password = config('database.connections.'.$connection.'.password');

                    $mysqli = new mysqli($database_host, $database_user, $database_password, $db_name);
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

                    // try{
                    //     $connection = 'tenant';
               
                    //     $hasDb = DB::connection($connection)->select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = " . "'" . $db_name . "'");
               
                    //     if(empty($hasDb)) {
                    //         DB::connection($connection)->select('CREATE DATABASE '. $db_name);
                    //         config(['database.connections.tenant.database' => $db_name]);
                    //         // DB::purge('tenant');
                    //         // DB::reconnect('tenant');
                    //         Schema::connection('tenant')->getConnection()->reconnect();
                    //         Artisan::call('migrate --database=tenant');
                    //         Artisan::call('db:seed --class=PermissionTableSeeder');
                    //         echo "Database '$db_name' created for '$connection' connection";
                    //     }
                    //     else {
                    //         echo "Database $db_name already exists for $connection connection";
                    //     }
                    // }
                    // catch (\Exception $e){
                    //     dd($e->getMessage());
                    // }
                });
            });
        });

        // tenants routes for authenticated users
        Route::middleware('tenant')->group(function ()
        {
        });

        // landlord routes for authenticated users
        Route::middleware('landlord')->group(function ()
        {
        });

        Route::get('/profile', [UserController::class, 'profile'])->name('profile');
        Route::patch('/profile/{user}', [UserController::class, 'profile_update'])->name('profile_update');
    });

    // landlord public routes
    Route::middleware('landlord')->group(function ()
    {
        Route::get('plan', [FrontendPlanController::class, 'index']);
        Route::get('signup/{plan}', [FrontendPlanController::class, 'signup'])->name('signup');
        Route::post('signup', [FrontendPlanController::class, 'store'])->name('signup_post');
    });

    // tenants public routes
    Route::middleware('tenant')->group(function ()
    {
        
    });

    Route::get('media-test', function()
    {
        $url = 'https://images.unsplash.com/photo-1649667271518-707cabd28ad2';
        $user = User::find(1);
        $user->addMediaFromUrl($url)
        ->toMediaCollection();
    });

    Route::get('get-media', function()
    {
        $user = User::find(1);
        $mediaItems = $user->getMedia();
        dd($mediaItems);
    });
});

Route::get('{any}', function ($any) {
    if (request()->segment(1) && strlen(request()->segment(1)) != 2) {
        return redirect('/'.app()->getLocale().'/'.request()->path());
    }
})->where('any', '.*');







// Route::get('migrate', function() {
//     \Illuminate\Support\Facades\Artisan::call('migrate:fresh -—seed');
// });