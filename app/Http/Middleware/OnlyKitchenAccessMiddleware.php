<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OnlyKitchenAccessMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->profile === "kitchen_manager") {
            return $next($request);
        }else{
            return redirect()->back();
        }
    }
}
