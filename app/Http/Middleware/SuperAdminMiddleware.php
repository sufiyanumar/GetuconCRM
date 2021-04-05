<?php

namespace App\Http\Middleware;

use App\Role;
use Closure;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $admin = Role::where('name', 'Super Admin')->first();
        if (auth()->user()->role_id == $admin->id) {
            return $next($request);
        }
        return '/dashboard';
    }
}
