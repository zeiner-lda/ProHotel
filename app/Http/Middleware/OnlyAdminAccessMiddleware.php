<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OnlyAdminAccessMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->profile === "admin") {
            return $next($request);
        }else{
            return redirect()->back();
        }
    }
}
