<?php

namespace App\Http\Livewire\Kitchen;

use App\Models\{StockRoom};
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class RequestItemToStockRoomComponent extends Component
{
    use LivewireAlert, WithPagination;
    public $itemId,$status, $itemRequested, $quantity, $searcher ,$startdate,$enddate;
    public function render()
    {
        return view('livewire.kitchen.request-item-to-stock-room-component',[
        'avaliableItems' =>$this->getAvailableProductsInStockRoom(),
        ])->layout('layouts.admin.app');
    }

    public function getAvailableProductsInStockRoom () {
        try {
            if ($this->searcher) {
              return StockRoom::query()
              ->where('item', 'like', '%'.$this->searcher.'%')
              ->where('quantity', '>', 0)
              ->paginate(5);
            }else if ($this->startdate and $this->enddate) {
                return StockRoom::query()
                ->whereBetween('created_at', [$this->startdate,$this->enddate])
                ->where('quantity', '>', 0)
                ->paginate(5);
            }else{
                return StockRoom::query()
                ->where('quantity', '>', 0)
                ->paginate(5);
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

    public function requestItem ($id, StockRoom $item) {
        try {
            $this->itemId = $id;
            $this->status = true;
            $data = $item->find( $this->itemId);
            $this->itemRequested = $data->item;
            $this->quantity = $data->quantity;
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

    public function restoreItem ($id, StockRoom $item) {
        try {
            $this->itemId = $id;
            $this->status = false;
            $data =$item->find($this->itemId);
            $this->itemRequested = $data->item;
            $this->quantity = $data->quantity;
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

    public function saveRequestItem (StockRoom $item) {
        try {
        DB::BeginTransaction();
        $item->find($this->itemId)->decrement('quantity', $this->quantity);
        DB::commit();
        $this->alert('success', 'SUCESSO', [
            'toast' =>false,
            'position'=>'center',
            'showConfirmButton'=>true,
            'confirmButtonText'=>'OK',
            'timer' => 300000,
            'allowOutsideClick'=>false,
            'text'=>'Operação realizada com sucesso!'
        ]);
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

    public function saveRestoreItem () {
        try {
        DB::BeginTransaction();
        StockRoom::find($this->itemId)->increment('quantity', $this->quantity);
        DB::commit();
        $this->alert('success', 'SUCESSO', [
            'toast' =>false,
            'position'=>'center',
            'showConfirmButton'=>true,
            'confirmButtonText'=>'OK',
            'timer' => 300000,
            'allowOutsideClick'=>false,
            'text'=>'Operação realizada com sucesso!'
          ]);
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

    public function closeModal () {
        try {
           $this->status = false;
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
