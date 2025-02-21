<?php

namespace App\Http\Livewire\Kitchen;

use App\Models\OrderClient;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class OrderClientComponent extends Component
{
    use LivewireAlert, WithPagination;
    public $orderId,$order,$searcher, $startdate,$enddate, $status;
    protected $listeners = ["confirmFulfillOrder" => "confirmFulfillOrder"];
    public function render()
    {
        return view('livewire.kitchen.order-client-component',[
            "orders" => $this->getOrdersByClients()
        ])->layout('layouts.admin.app');
    }

    public function getOrdersByClients () {
        try {
            if ($this->searcher) {
                return OrderClient::query()->where("hotel_id", auth()->user()->company_id)
                ->where("order_name", "like", "%". $this->searcher . "%")
                ->where("status", true)          
                ->where("order_status", "pending")     
                ->orWhere("order_status", "in_preparation")
                ->orderBy("id", "DESC")
                ->paginate(6);

            }else if ($this->startdate && $this->enddate)  {
                return OrderClient::query()->where("hotel_id", auth()->user()->company_id)
                ->whereBetween("created_at", [$this->startdate,$this->enddate])
                ->where("status", true)
                ->where("order_status", "pending")     
                ->orWhere("order_status", "in_preparation")               
                ->orderBy("id", "DESC")
                ->paginate(6);
            }else{
                return OrderClient::query()->where("hotel_id", auth()->user()->company_id)
                ->where("status", true)     
                ->where("order_status", "pending")     
                ->orWhere("order_status", "in_preparation")        
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

    public function fulfillOrder ($orderId) {
        try {
          $this->orderId = $orderId;
          $this->alert('warning', 'Confirmar', [
            'icon' => 'warning',
            'position' => 'center',
            'toast' => false,
            'showConfirmButton' => true,
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancelar',
            'confirmButtonText' => 'Confirmar',
            'confirmButtonColor' => '#3085d6',
            'cancelButtonColor' => '#d33',
            'timer' => '300000',              
            'text' => "Deseja atender a este pedido?",
            'onConfirmed' => 'confirmFulfillOrder'
            ]);
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

    public function confirmFulfillOrder () {
        try {
        $this->order = OrderClient::find($this->orderId);      
        if ($this->order->order_status == "pending") {
            DB::BeginTransaction();
            OrderClient::find($this->orderId)->update([
            "order_status" =>  "in_preparation" 
            ]);  
            DB::commit();

        }else if ($this->order->order_status == "in_preparation") {
            DB::BeginTransaction();
            OrderClient::find($this->orderId)->update([
            "order_status" =>  "finished" 
            ]);  
            DB::commit();
        }

        } catch (\Throwable $th) {
        DB::rollBack();
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
