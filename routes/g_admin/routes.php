<?php

use App\Http\Livewire\GeneralAdmin\AdminUserComponent;
use App\Http\Livewire\GeneralAdmin\GeneralAdminComponent;
use App\Http\Livewire\GeneralAdmin\HotelComponent;
use \Illuminate\Support\Facades\Route;

Route::middleware(["auth" , "only.g_admin.access", "checkerallreservationstatus"])->group( function () {
Route::prefix("/geral/admin/")->group(function () {
Route::get('inicio/', GeneralAdminComponent::class)->name('g_admin.home');
Route::get("/hoteis", HotelComponent::class)->name('g_admin.hotels');
Route::get("/utilizadores", AdminUserComponent::class)->name('g_admin.users');

});
});
