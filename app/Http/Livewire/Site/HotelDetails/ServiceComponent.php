<?php

namespace App\Http\Livewire\Site\HotelDetails;

use App\Models\Service;
use Livewire\Component;

class ServiceComponent extends Component
{
    public $hotelId , $searchService;

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
        return view('livewire.site.hotel-details.service-component',[
            "services" =>$this->getAllServices()
        ]);
    }

    public function getAllServices () {
        try {
            if ($this->searchService) {
                return Service::query()->where('hotel_id',$this->hotelId)
                ->where("servicename", "like" , "%".$this->searchService."%")
                ->paginate(6);
            }else{
                return Service::query()->where('hotel_id',$this->hotelId)
                ->paginate(6);
            }
        }catch(\Throwable $th) {
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
