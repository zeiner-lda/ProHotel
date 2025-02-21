<?php

use App\Http\Livewire\Client\ClientDashboardComponent;
use App\Http\Livewire\Client\ClientProfileComponent;
use App\Http\Livewire\Client\CreateAccountClientComponent;
use \Illuminate\Support\Facades\Route;

Route::middleware("checkerallreservationstatus")->group( function () {
Route::get("/registar.nova.conta", CreateAccountClientComponent::class)->name("client.create.account");
Route::middleware(['auth'])->group(function () {
Route::get('/painel/cliente',ClientDashboardComponent::class)->name('prohotel.client.panel.dashboard');
Route::get("/painel/cliente/perfil/", ClientProfileComponent::class)->name('prohotel.client.panel.profile');
});
});
