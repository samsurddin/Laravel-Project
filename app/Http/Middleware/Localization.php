<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $current_path = $request->path();
        if ($request->segment(1) && in_array($request->segment(1), config('app.available_locales'))) {
            session()->put('locale', $request->segment(1));
            app()->setLocale(session()->get('locale'));
        }
        if ($request->segment(1) && strlen($request->segment(1)) != 2) {
            if (session()->has('locale')) {
                app()->setLocale(session()->get('locale'));
            }
        }
        if (app()->getLocale() == null) {
            // app()->setLocale(config('app.locale'));
            if (session()->has('locale')) {
                app()->setLocale(session()->get('locale'));
            }
        }
        if ($request->segment(1) == null) {
            return redirect('/'.app()->getLocale());
        }
        if ($request->segment(1) && strlen($request->segment(1)) != 2) {
            return redirect('/'.app()->getLocale().'/'.$current_path);
        }
        return $next($request);
    }
}
