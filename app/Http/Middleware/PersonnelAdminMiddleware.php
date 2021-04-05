<?php

namespace App\Http\Middleware;

use App\Role;
use Closure;

class PersonnelAdminMiddleware
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
        $admin = Role::where('name', 'Personnel Admin')->first();
        if (auth()->user()->role_id == $admin->id) {
            return $next($request);
        }
        return $next($request);
        // return '/dashboard';
    }
}
