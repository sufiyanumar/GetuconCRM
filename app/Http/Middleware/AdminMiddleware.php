<?php

namespace App\Http\Middleware;

use App\Role;
use Closure;

class AdminMiddleware
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

        $admin = Role::where('name', 'Admin')->first();
        if (auth()->user()->role_id == 2) {
            return $next($request);
        }
        return '/dashboard';
    }
}
