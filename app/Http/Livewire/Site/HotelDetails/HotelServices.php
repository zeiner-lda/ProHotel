<?php

namespace App\Http\Livewire\Site\HotelDetails;

use App\Models\Company;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class HotelServices extends Component
{
    use LivewireAlert;
    public $hotelName, $hotelId;

    public function mount($hotelId) {
        try {
            $this->hotelId = $hotelId;
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


    public function render()
    {
        return view('livewire.site.hotel-details.hotel-services',[
            'hotel' =>$this->getDetailsClickedHotelByUser()
        ]);
    }

    public function getDetailsClickedHotelByUser () {
        try {
            return Company::find($this->hotelId);
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
