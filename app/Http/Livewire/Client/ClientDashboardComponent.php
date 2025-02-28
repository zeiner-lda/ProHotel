<?php

namespace App\Http\Livewire\Client;

use App\Models\{Company, Testimonial, OrderClient};
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class ClientDashboardComponent extends Component
{
    use LivewireAlert, WithPagination;
    public $searcher, $startdate ,$enddate;
    protected $listeners = ['confirmTestimonialDeletion' => 'confirmTestimonialDeletion'];

    public function render () {
        return view('livewire.client.client-dashboard-component',[
            "orders" => $this->getOrders(),
            "testimonialCounter" => $this->getTestimonialCounter(),
            "orderCounter" => $this->getOrderCounter()
        ])->layout("layouts.client-dashboard.app");
    }

    public function getTestimonialCounter () {

        try {
            return Testimonial::query()->where("user_id", auth()->user()->id)
            ->where("visibility", "public")
           ->count();
        } catch (\Throwable $th) {
            $this->alert('error', 'ERRO', [
                'toast' => false,
                'position'=>'center',
                'showConfirmButton'=>true,
                'confirmButtonText'=>'OK',
                'timer' => 300000,
                'allowOutsideClick'=>false,
                'text'=> $th->GetMessage(),
            ]);
        }
    }

    public function getOrderCounter () {
        try {
           return OrderClient::query()->where("user_id", auth()->user()->id)
           ->where("order_status", "pending")
           ->count();
        } catch (\Throwable $th) {
            $this->alert('error', 'ERRO', [
                'toast' => false,
                'position'=>'center',
                'showConfirmButton'=>true,
                'confirmButtonText'=>'OK',
                'timer' => 300000,
                'allowOutsideClick'=>false,
                'text'=> $th->GetMessage(),
            ]);
        }
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

    public function getAllHotelsInAngola () {
        try {
          return Company::query()->select(['id','companyname'])->get();
        } catch (\Throwable $th) {
        $this->alert('error', 'ERRO', [
                'toast' =>false,
                'position'=>'center',
                'showConfirmButton'=>true,
                'confirmButtonText'=>'OK',
                'timer' => 300000,
                'allowOutsideClick'=>false,
                'text'=>$th->GetMessage(),
            ]);
        }
    }


}
