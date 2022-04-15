<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Spatie\Multitenancy\Models\Tenant;

class TenantDatabase
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
        // $landlord_db = 
        // Config::set('database.connections', 'landlord');
        if (Tenant::checkCurrent()) {
            // config(['database.connections.database', Tenant::current()->database]);
            // Config::set('database.connections.database', Tenant::current()->database);
            // $this->connection = 'landlord';
        }
        // dd(Config::get('database.connections'));
        // dd(Tenant::checkCurrent());
        // dd(config('database.connections.tenant.database'));
        
        return $next($request);
    }
}
