<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
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
            dd(\App\Models\LandlordUser::all());
        }
        // dd(DB::connection()->getDatabaseName());
        // dd(\Spatie\Multitenancy\Models\Tenant::current());
        return view('welcome');
    });

    Route::middleware('tenant')->group(function ()
    {
        Route::get('/tenant', function()
        {
            // $con_name = DB::connection()->getDatabaseName();
            // dd(DB::connection()->getDatabaseName());
            dd(config('database.connections'));
        });
    });

    Route::group(['middleware' => ['auth']], function()
    {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        Route::get('/profile', function () {
            return view('dashboard');
        })->name('profile');
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