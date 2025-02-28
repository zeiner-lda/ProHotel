<?php

namespace App\Http\Livewire\Stock;

use App\Models\Product;
use App\Models\StockRoom;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class StockRoomComponent extends Component
{
    use LivewireAlert, WithPagination;
    public $item, $itemName,$selectedItem,$products ,$stockroomId, $itemId , $quantity , $description , $searcher , $status, $startdate ,$enddate;
    public int $product;
    protected $listeners = ['confirmItemDeletion'];
    public function render()
    {
        return view('livewire.stock.stock-room-component',[
            "data" =>$this->getItemsInStockRoom(),
            "products" =>$this->getProducts(),
        ])->layout('layouts.admin.app');
    }

    public function getItemsInStockRoom() {
        try {
         if ($this->searcher) {
            return $data = StockRoom::query()
            ->where('hotel_id', auth()->user()->company_id)
            ->where('item', 'like', '%'.$this->searcher.'%')
           ->paginate(6);

         }else if ($this->startdate && $this->enddate) {
            return $data = StockRoom::query()
            ->where('hotel_id', auth()->user()->company_id)
            ->whereBetween("created_at",[$this->startdate,$this->enddate])
            ->paginate(6);

         }else{
             return $data = StockRoom::query()
             ->where('hotel_id', auth()->user()->company_id)
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

    public function getProducts () {
        try {
            return $this->products = Product::query()
            ->where('hotel_id', auth()->user()->company_id)
           ->get();
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

    public function save (StockRoom $stockroom) {
        $this->validate();
        try {

            DB::beginTransaction();
            $stockroom->create([
                "item" =>$this->item,
                "quantity" =>$this->quantity,
                "description" =>$this->description,
                'hotel_id' => auth()->user()->company_id,
                "user_id" =>auth()->user()->id
            ]);
            DB::commit();
            $this->alert('success', 'SUCESSO', [
                'toast' =>false,
                'position'=>'center',
                'showConfirmButton'=>true,
                'confirmButtonText'=>'OK',
                'timer' => 300000,
                'allowOutsideClick'=>false,
                'text'=>'Item adicionado com sucesso!'
            ]);
            $this->resetValuesByDefault();

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

    public function closeModal() {
        try {
       fn () => $this->resetValuesByDefault();
        } catch (\Throwable $th) {
        $this->alert('success', 'SUCESSO', [
                'toast' =>false,
                'position'=>'center',
                'showConfirmButton'=>true,
                'confirmButtonText'=>'OK',
                'timer' => 300000,
                'allowOutsideClick'=>false,
                'text'=>'Categoria salva com sucesso!'
            ]);
        }
    }

    public function resetValuesByDefault () {
        try {
         $this->selectedItem = false;
         $this->status = false;
         $this->reset(['item','quantity', 'description', 'itemId']);
        } catch (\Throwable $th) {
         $this->alert('success', 'SUCESSO', [
                'toast' =>false,
                'position'=>'center',
                'showConfirmButton'=>true,
                'confirmButtonText'=>'OK',
                'timer' => 300000,
                'allowOutsideClick'=>false,
                'text'=>'Categoria salva com sucesso!'
            ]);
        }
    }

    public function delete ($itemId) {
        $this->itemId = $itemId;
        $this->alert('warning', 'Confirmar', [
            'icon' => 'warning',
            'position' => 'center',
            'toast' => false,
            'html' => "Deseja realmente excluir este item?",
            'showConfirmButton' => true,
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancelar',
            'confirmButtonText' => 'Confirmar',
            'confirmButtonColor' => '#3085d6',
            'cancelButtonColor' => '#d33',
            'timer' => '300000',
            'onConfirmed' => 'confirmItemDeletion'
        ]);
    }

    public function confirmItemDeletion (StockRoom $stockItem) {
        try {
         DB::beginTransaction();
         $stockItem->destroy($this->itemId);
         DB::commit();
        } catch (\Throwable $th) {
        DB::commit();
        $this->alert('success', 'SUCESSO', [
         'toast' =>false,
         'position'=>'center',
         'showConfirmButton'=>true,
         'confirmButtonText'=>'OK',
         'timer' => 300000,
         'allowOutsideClick'=>false,
         'text'=>'Categoria salva com sucesso!'
         ]);
        }
    }

    public function edit ($itemId) {
        try {
            $this->itemId = $itemId;
            $this->selectedItem = true;
            $this->status = true;
            $stockItem = StockRoom::find($this->itemId);
            $this->itemName = $stockItem->item;
            $this->quantity = $stockItem->quantity;
            $this->description = $stockItem->description;
        } catch (\Throwable $th) {
        $this->alert('success', 'SUCESSO', [
                'toast' =>false,
                'position'=>'center',
                'showConfirmButton'=>true,
                'confirmButtonText'=>'OK',
                'timer' => 300000,
                'allowOutsideClick'=>false,
                'text'=>'Categoria salva com sucesso!'
                ]);
        }
    }

    public function update (StockRoom $data) {
        try {
        DB::BeginTransaction();
         $data->find($this->itemId)->update([
            'quantity' =>$this->quantity,
            'item' =>$this->itemName,
            'description' =>$this->description,
            'hotel_id' => auth()->user()->company_id,
            "user_id" =>auth()->user()->id
         ]);

        DB::commit();
         $this->alert('success', 'SUCESSO', [
            'toast' =>false,
            'position'=>'center',
            'showConfirmButton'=>true,
            'confirmButtonText'=>'OK',
            'timer' => 300000,
            'allowOutsideClick'=>false,
            'text'=>'Item atualizado com sucesso!'
            ]);
        } catch (\Throwable $th) {
        DB::rollBack();
        $this->alert('success', 'SUCESSO', [
                'toast' =>false,
                'position'=>'center',
                'showConfirmButton'=>true,
                'confirmButtonText'=>'OK',
                'timer' => 300000,
                'allowOutsideClick'=>false,
                'text'=>'Categoria salva com sucesso!'
          ]);
        }
    }

    public function buttonAddItem () {
        try {
        $this->selectedItem = false;
        } catch (\Throwable $th) {
        $this->alert('success', 'SUCESSO', [
                'toast' =>false,
                'position'=>'center',
                'showConfirmButton'=>true,
                'confirmButtonText'=>'OK',
                'timer' => 300000,
                'allowOutsideClick'=>false,
                'text'=>'Categoria salva com sucesso!'
          ]);
        }
    }
}

