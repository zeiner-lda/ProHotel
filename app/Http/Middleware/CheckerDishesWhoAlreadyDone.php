<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckerDishesWhoAlreadyDone
{
   public $orders;
    public function handle(Request $request, Closure $next)
    {
        try {
            $this->checkerDishes();
            return $next($request);
        }catch(Exception $ex){
            return back()->with(["error" => $ex->GetMessage()],500);
        }
    }

    public function checkerDishes() {
        try {
            $this->orders = \App\Models\OrderClient::query()->where("order_status", "finished")->get();
            if ($this->orders) {
                foreach ($this->orders as $order) {
                    $currentTime = \Carbon\Carbon::now();
                    $hoursDifference = $order->created_at->diffInHours($currentTime);
                    if ($hoursDifference >= 3 ) {
                        DB::beginTransaction();
                        \App\Models\OrderClient::destroy([$order->id]);
                        DB::commit();
                    }
                }
            }
        } catch (Exception $ex) {
            return back()->with(["error" => $ex->GetMessage()],500);
        }
    }
}
