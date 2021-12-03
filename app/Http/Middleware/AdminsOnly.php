<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminsOnly
{
    /**
     * Allow access to admin (first user in database) only
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (User::first()->name != Auth::user()->name) {
            abort(403);
        }

        return $next($request);
    }
}
