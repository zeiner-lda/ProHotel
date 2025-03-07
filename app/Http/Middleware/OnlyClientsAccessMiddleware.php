<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OnlyClientsAccessMiddleware
{
    
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->profile === "guest") {
            return $next($request);
        }else{
            return redirect()->back();
        }
    }
}
