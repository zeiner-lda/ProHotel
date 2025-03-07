<?php

use App\Http\Livewire\GeneralAdmin\GeneralAdminComponent;
use \Illuminate\Support\Facades\Route;

Route::get('/geral/admin/inicio/', GeneralAdminComponent::class)->name('s_admin.home');
