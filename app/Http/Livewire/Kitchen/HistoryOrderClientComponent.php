<?php

namespace App\Http\Livewire\Kitchen;
use App\Models\{OrderClient};
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class HistoryOrderClientComponent extends Component
{
    use LivewireAlert, WithPagination;
    public $orderId,$order,$searcher, $startdate,$enddate, $status;
    public function render()
    {
        return view('livewire.kitchen.history-order-client-component',[
            "orders" => $this->getOrdersByClients()
        ])->layout('layouts.admin.app');
    }

    public function getOrdersByClients () {
        try {
            if ($this->searcher) {
                return OrderClient::query()->where("hotel_id", auth()->user()->company_id)
                ->where("order_name", "like", "%". $this->searcher . "%")
                ->where("status", true)
                ->where("order_status", "finished")
                ->orderBy("id", "DESC")
                ->paginate(6);

            }else if ($this->startdate && $this->enddate)  {
                return OrderClient::query()->where("hotel_id", auth()->user()->company_id)
                ->whereBetween("created_at", [$this->startdate,$this->enddate])
                ->where("status", true)
                ->where("order_status", "finished")
                ->orderBy("id", "DESC")
                ->paginate(6);

            }else{
                return OrderClient::query()->where("hotel_id", auth()->user()->company_id)
                ->where("status", true)
                ->where("order_status", "finished")
                ->orderBy("id", "DESC")
                ->paginate(6);
            }

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
