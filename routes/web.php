<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
        return view('welcome');
    });

    Route::resource('users', UserController::class);

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth'])->name('dashboard');

    require __DIR__.'/auth.php';
    
});

Route::get('{any}', function ($any) {
    if (request()->segment(1) && strlen(request()->segment(1)) != 2) {
        return redirect('/'.app()->getLocale().'/'.request()->path());
    }
})->where('any', '.*');