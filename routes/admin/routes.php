<?php

use App\Http\Livewire\Admin\AdminComponent;
use App\Http\Livewire\Admin\AdminProfileComponent;
use App\Http\Livewire\Admin\UserComponent;
use \Illuminate\Support\Facades\Route;



Route::middleware(["auth" , "only.admin.access", "checkerallreservationstatus"])->group( function () {
Route::prefix("/admin")->group(function (){
Route::get('/inicio', AdminComponent::class)->name('admin.home');
Route::get("/utilizadores", UserComponent::class)->name('admin.users');
Route::get("/perfil/detalhes/", AdminProfileComponent::class)->name('admin.profile');

});
});
