<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class ModeratorMiddlewaree
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
        if (Auth::check() && (Auth::user()->role->role == "Admin" || Auth::user()->role->role == "Moderator")) {
            return $next($request);
        } else {
            return redirect('/');
        }
    }
}
