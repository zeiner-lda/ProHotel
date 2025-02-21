<?php

use App\Http\Livewire\Home\HotelDetails\RoomsServicesAndTestimonialsOfHotelComponent;
use \App\Http\Livewire\Site\Home\HomeComponent;
use App\Http\Livewire\Site\HotelDetails\HotelServices;
use \Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;


//Limpar a memoria cache
Route::get('/clean/cache', function () {
    Artisan::call('optimize:clear');
    return "Cache limpo com sucesso!";
});

//Criar link simbolico
Route::get("/link", function (){
    $target = storage_path('app/public');
    $link = public_path('storage');

    if (file_exists($link)) {
        return "O link simbólico já existe!";
    }

    if (symlink($target, $link)) {
        return "Link simbólico criado com sucesso!";
    } else {
        return "Erro ao criar o link simbólico!";
    }
});

Route::middleware("checkerallreservationstatus")->group( function () {
Route::get('/', HomeComponent::class)->name('site.index');
Route::get('/detalhes/hotel/{hotelId}', HotelServices::class)->name('prohotel.hotel.informations');
//
});

