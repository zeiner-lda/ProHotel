<?php

use App\Http\Livewire\Client\ClientDashboardComponent;
use App\Http\Livewire\Client\ClientProfileComponent;
use App\Http\Livewire\Client\CreateAccountClientComponent;
use App\Http\Livewire\Client\TestimonialComponent;
use \Illuminate\Support\Facades\Route;

Route::middleware(["checkerallreservationstatus"])->group( function () {
Route::get("/registar.nova.conta", CreateAccountClientComponent::class)->name("client.create.account");
Route::middleware(["checker.dishes.already.finished", "auth"])->group(function () {
Route::prefix("/painel/cliente")->group(function() {
Route::get('/inicio',ClientDashboardComponent::class)->name('prohotel.client.panel.dashboard');
Route::get("/painel/cliente/perfil/", ClientProfileComponent::class)->name('prohotel.client.panel.profile');
Route::get("/depoimentos", TestimonialComponent::class)->name('prohotel.client.panel.testimonials');

});
});
});
