<?php

namespace App\Http\Livewire\Reception;

use App\Models\Checkout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class GuestComponent extends Component
{
    use WithPagination, LivewireAlert;
    public function render()
    {
        return view('livewire.reception.guest-component',[
            'guests' => $this->getAllGuests()
        ])->layout('layouts.admin.app');
    }

    public function getAllGuests() {
        try {
            return Checkout::where('hotel_id', auth()->user()->company_id)
            ->with('reservation')
            ->paginate(6);
        } catch (\Throwable $th) {
         $this->alert('error', 'ERRO', [
                'toast' =>false,
                'position'=>'center',
                'showConfirmButton'=>true,
                'confirmButtonText'=>'OK',
                'timer' => 300000,
                'allowOutsideClick'=>false,
                'text'=>'Ocorreu o seguinte erro: '.$th->getMessage()
                ]);
        }
    }
}
