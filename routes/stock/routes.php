<?php

use \App\Http\Livewire\Stock\CategoryComponent;
use \App\Http\Livewire\Stock\ProductComponent;
use \App\Http\Livewire\Stock\StockComponent;
use \App\Http\Livewire\Stock\StockRoomComponent;
use \Illuminate\Support\Facades\Route;

Route::middleware(["auth", "only.stockroom.access", "checkerallreservationstatus"])->group( function () {
Route::get("/gestao/stock/", StockComponent::class)->name('stock.management.index');
Route::get("/categorias", CategoryComponent::class)->name('stock.management.categories');
Route::get("/produtos", ProductComponent::class)->name('stock.management.products');
Route::get("/inventario", StockRoomComponent::class)->name('stock.management.stockroom');


});
