<?php

use App\Http\Livewire\Authentication\AuthenticationComponent;
use Illuminate\Support\Facades\Route;

Route::middleware("checkerallreservationstatus")->group( function () {
Route::get("/login", AuthenticationComponent::class)->name('login');

});
