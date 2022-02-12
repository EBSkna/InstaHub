<?php

namespace App\Http\Middleware;

use App\Models\User;
use Auth;
use Closure;
use Session;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (! $request->user()->allowed($role)) {
            flash(__('You are not allowed to do this!'))->error();

            return redirect('/');
        } else {
            return $next($request);
        }
    }
}
