<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\PlanController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Spatie\Multitenancy\Models\Tenant;

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

Route::group(['prefix' => '{locale}', 'where' => ['locale' => '[a-zA-Z]{2}']], function()
{
    Route::get('/', function () {
        if (!Tenant::checkCurrent()) {
            // dd(\App\Models\LandlordUser::all());
        }
        // dd(DB::connection()->getDatabaseName());
        // dd(\Spatie\Multitenancy\Models\Tenant::current());
        return view('welcome');
    });

    // tenants public routes
    Route::middleware('tenant')->group(function ()
    {
    });

    // landlord public routes
    Route::middleware('landlord')->group(function ()
    {
    });

    Route::group(['middleware' => ['auth']], function()
    {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        Route::get('/profile', function () {
            return view('dashboard');
        })->name('profile');
        
        // admin routes for all
        Route::prefix('admin')->group(function()
        {
            Route::resource('users', UserController::class);
            Route::resource('roles', RoleController::class);

            // tenants admin routes
            Route::middleware('tenant')->group(function ()
            {
            });

            // landlord admin routes
            Route::middleware('landlord')->group(function ()
            {
                Route::resource('tenants', TenantController::class);
                Route::resource('plans', PlanController::class);

                Route::get('create/db/{db_name}', function ($lang, $db_name) {
                    try{
                        $connection = 'tenant';
               
                        $hasDb = DB::connection($connection)->select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = " . "'" . $db_name . "'");
               
                        if(empty($hasDb)) {
                            DB::connection($connection)->select('CREATE DATABASE '. $db_name);
                            config(['database.connections.tenant.database' => $db_name]);
                            // DB::purge('tenant');
                            // DB::reconnect('tenant');
                            Schema::connection('tenant')->getConnection()->reconnect();
                            Artisan::call('migrate --database=tenant');
                            Artisan::call('db:seed --class=PermissionTableSeeder');
                            echo "Database '$db_name' created for '$connection' connection";
                        }
                        else {
                            echo "Database $db_name already exists for $connection connection";
                        }
                    }
                    catch (\Exception $e){
                        dd($e->getMessage());
                    }
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

    require __DIR__.'/auth.php';
});

Route::get('{any}', function ($any) {
    if (request()->segment(1) && strlen(request()->segment(1)) != 2) {
        return redirect('/'.app()->getLocale().'/'.request()->path());
    }
})->where('any', '.*');