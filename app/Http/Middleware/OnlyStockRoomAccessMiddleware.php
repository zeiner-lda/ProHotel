<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OnlyStockRoomAccessMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->profile === "stockroom_manager") {
            return $next($request);
        }else{
            return redirect()->route('login');
        }
    }
}
