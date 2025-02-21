<?php

use App\Http\Livewire\Reception\ReceptionIndexComponent;
use App\Http\Livewire\Reception\{CheckinComponent, CheckoutComponent, NotificationComponent, ReceptionComponent, ReservationComponent, RoomComponent, TestimonialComponent};
use \Illuminate\Support\Facades\Route;


Route::middleware(["auth", "checkerallreservationstatus"])->group( function () {
Route::prefix("/recepcao")->group(function () {
Route::get("/inicio", ReceptionComponent::class)->name('dashboard.reception.index');
Route::get("/quartos" , RoomComponent::class)->name("reception.rooms");
Route::get('/reservas', ReservationComponent::class)->name('reception.reservations');
Route::get('/checkins', CheckinComponent::class)->name('reception.checkins');
Route::get('/checkout', CheckoutComponent::class)->name('reception.checkout');
Route::get('/notificacoes', NotificationComponent::class)->name('reception.notifications');
Route::get('/depoimentos',TestimonialComponent::class)->name('reception.testimonials');
});
});
