<?php

namespace App\Http\Livewire\Site\HotelDetails;
use App\Models\{Company, Testimonial};
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class TestimonialComponent extends Component
{
    use LivewireAlert;
    public $hotelId, $testimonials;

    public function mount($hotelId)
    {
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
        return view('livewire.site.hotel-details.testimonial-component',[
            "allTestimonials"  =>  $this->getTestimonials(),
            "allAvailableHotelsInAngola"  =>  $this->getAllHotelsInAngola()
        ]);
    }

    public function getTestimonials () {
        try {
          return Testimonial::query()->where('hotel_id',  $this->hotelId)
          ->where("visibility", "public")
            ->with('user')
            ->with('hotel')
            ->get();
        } catch (\Throwable $th) {
            $this->alert('error', 'ERRO', [
                'toast'  => false,
                'position' => 'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'timer'  =>  300000,
                'allowOutsideClick' => false,
                'text' => $th->GetMessage(),
            ]);
        }
    }

    public function getAllHotelsInAngola () {
        try {
           return Company::query()->select(['id','companyname'])->get();
        } catch (\Throwable $th) {
        $this->alert('error', 'ERRO', [
                'toast'  => false,
                'position' => 'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'timer'  =>  300000,
                'allowOutsideClick' => false,
                'text' => $th->GetMessage(),
            ]);
        }
    }
}
