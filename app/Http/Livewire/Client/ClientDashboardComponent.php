<?php

namespace App\Http\Livewire\Client;

use App\Models\Company;
use App\Models\OrderClient;
use App\Models\Testimonial;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ClientDashboardComponent extends Component
{
    use LivewireAlert;
    public $searcher, $startdate ,$enddate;
    protected $listeners = ['confirmTestimonialDeletion' => 'confirmTestimonialDeletion'];
    protected $rules = [
        'hotelId' =>'required',
        'testimonial' =>'required',
    ];
    protected $messages = [
        'hotelId.required' =>'Campo obrigatório*',
        'testimonial.required' =>'Campo obrigatório*',
    ];

    public function render()
    {
        return view('livewire.client.client-dashboard-component',[
            "orders" => $this->getOrders(),
            "testimonials" => $this->getTestimonials(),
            "allAvailableHotelsInAngola" => $this->getAllHotelsInAngola()
        ])->layout("layouts.client-dashboard.app");
    }

    public function getOrders () {
        try {
            if ($this->searcher) {
                return OrderClient::query()->where("user_id", auth()->user()->id)
                ->when($this->searcher, fn ($search) => $search
                ->where("order_name", 'like', '%{$this->searcher}%')
                )->with("hotel")
                ->get();
            }else if ($this->startdate && $this->enddate) {
                return OrderClient::query()->where("user_id", auth()->user()->id)
                ->whereBetween("created_at", [$this->startdate, $this->enddate])
                ->with("hotel")
                ->get();
            }else{
                return OrderClient::query()->where("user_id", auth()->user()->id)
                ->with("hotel")
                ->get();
            }
        } catch (\Throwable $th) {
            $this->alert('error', 'ERRO', [
                'toast' =>false,
                'position'=>'center',
                'showConfirmButton'=>true,
                'confirmButtonText'=>'OK',
                 'timer' => 300000,
                'allowOutsideClick'=>false,
                 'text'=>'Ocorreu o seguinte erro: '.$th->GetMessage()
                 ]);
        }
    }


}
