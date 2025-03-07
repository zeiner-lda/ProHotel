<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OnlyReceptionAccessMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->profile === "reception") {
            return $next($request);
        }else{
            return redirect()->back();
        }
    }
}
