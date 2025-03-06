<?php

namespace App\Http\Livewire\Reception;

use \App\Models\{Reservation, Room, Testimonial};
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class ReceptionComponent extends Component
{
    use LivewireAlert, WithPagination;
    public $reservations, $rooms, $testimonials;

    public function mount (Reservation $reservation, Room $room, Testimonial $testimonial)
    {
        $this->reservations = new $reservation();
        $this->rooms = new $room();
        $this->testimonials = new $testimonial();
    }
    public function render()
    {
        return view('livewire.reception.reception-component',[
            "reservationsCounter" =>$this->getReservationsCounter($this->reservations),
            "testimonialsCounter" =>$this->getTestimonialsCounter($this->testimonials),
            "roomsCounter" =>$this->getRoomsCounter($this->rooms),
            "occupiedRooms" =>$this->getOccupiedRoomsCounter($this->rooms),
            "availableRooms" =>$this->getAvailableRoomsCounter($this->rooms)
        ])->layout('layouts.admin.app');
    }

    public function getAvailableRoomsCounter (Room $roomsCounter) {
        try {
            return $roomsCounter->query()->where("hotel_id", auth()->user()->company_id)->where('status', 'available')->count();
        } catch (\Throwable $th) {
        $this->alert('error', 'ERRO', [
                'toast' =>false,
                'position' =>'center',
                'showConfirmButton' =>true,
                'confirmButtonText' =>'OK',
                'timer' => 300000,
                'allowOutsideClick' => false,
                'text'=> 'Ocorreu o seguinte erro: '.$th->getMessage()
            ]);
        }
    }

    public function getOccupiedRoomsCounter (Room $roomsCounter) {
        try {
            return $roomsCounter->query()->where("hotel_id", auth()->user()->company_id)->where('status', 'occupied')->count();
        } catch (\Throwable $th) {
        $this->alert('error', 'ERRO', [
                'toast' =>false,
                'position' =>'center',
                'showConfirmButton' =>true,
                'confirmButtonText' =>'OK',
                'timer' => 300000,
                'allowOutsideClick' => false,
                'text'=> 'Ocorreu o seguinte erro: '.$th->getMessage()
            ]);
        }
    }

    public function getReservationsCounter (Reservation $dataCounter) {
        try {
            return $dataCounter::query()->where("hotel_id", auth()->user()->company_id)
            ->whereYear('created_at', date('Y'))
            ->count();
        } catch (\Throwable $th) {
            $this->alert('error', 'ERRO', [
                'toast' =>false,
                'position' =>'center',
                'showConfirmButton' =>true,
                'confirmButtonText' =>'OK',
                'timer' => 300000,
                'allowOutsideClick' => false,
                'text'=> 'Ocorreu o seguinte erro: '.$th->getMessage()
            ]);
        }
    }

    public function getRoomsCounter (Room $roomsCounter) {
        try {
           return $roomsCounter->query()->where("hotel_id", auth()->user()->company_id)->count();
        } catch (\Throwable $th) {
            $this->alert('error', 'ERRO', [
                'toast' =>false,
                'position' =>'center',
                'showConfirmButton' =>true,
                'confirmButtonText' =>'OK',
                'timer' => 300000,
                'allowOutsideClick' => false,
                'text'=> 'Ocorreu o seguinte erro: '.$th->getMessage()
            ]);
        }
    }

    public function getTestimonialsCounter (Testimonial $testimoniesCounter) {
        try {
            return $testimoniesCounter::query()->where("hotel_id", auth()->user()->company_id)->count();
        } catch (\Throwable $th) {
            $this->alert('error', 'ERRO', [
            'toast' =>false,
            'position' =>'center',
            'showConfirmButton' =>true,
            'confirmButtonText' =>'OK',
            'timer' => 300000,
            'allowOutsideClick' => false,
            'text'=> 'Ocorreu o seguinte erro: '.$th->getMessage()
        ]);
        }
    }
}
