<?php

use App\Http\Livewire\Kitchen\DishComponent;
use App\Http\Livewire\Kitchen\DrinkComponent;
use App\Http\Livewire\Kitchen\HistoryOrderClientComponent;
use App\Http\Livewire\Kitchen\KitchenComponent;
use App\Http\Livewire\Kitchen\OrderClientComponent;
use App\Http\Livewire\Kitchen\RequestItemToStockRoomComponent;
use \Illuminate\Support\Facades\Route;


Route::middleware(["auth", "checker.dishes.already.finished", "checkerallreservationstatus"])->group( function () {
Route::prefix("/cozinha")->group(function () {
    Route::get('/inicio', KitchenComponent::class)->name('kitchen.index');
    Route::get("/solicitar", RequestItemToStockRoomComponent::class)->name('kitchen.request.items');
    Route::get("/pratos", DishComponent::class)->name('kitchen.dishes');
    Route::get("/bebidas", DrinkComponent::class)->name('kitchen.drinks');
    Route::get("/pedidos", OrderClientComponent::class)->name('kitchen.orders');
    Route::get("/historico/pedidos", HistoryOrderClientComponent::class)->name('kitchen.history.orders');

});

});
