<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\PlanController;

use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;
use Spatie\Multitenancy\Models\Tenant;

// landlord-frontend
use App\Http\Controllers\Frontend\FrontendPlanController;

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
        Route::get('plan', [FrontendPlanController::class, 'index']);
        Route::get('signup/{plan}', [FrontendPlanController::class, 'signup'])->name('signup');
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
                Route::resource('settings', SettingController::class)->except([
                    'show'
                ]);
                // Route::get('settings/edit', [SettingController::class, 'edit'])->name('settings.edit');
            });

            // landlord admin routes
            Route::middleware('landlord')->group(function ()
            {
                Route::resource('tenants', TenantController::class);
                Route::resource('plans', PlanController::class);
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