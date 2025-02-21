<?php

namespace App\Http\Livewire\Kitchen;

use App\Models\Drink;
use App\Models\Item;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class DrinkComponent extends Component
{
    use LivewireAlert , WithFileUploads,WithPagination;
   
    protected $listeners = ["confirmdrinkDeletion" => "confirmdrinkDeletion"];
    public $category,$drinkId, $drinkInfo, $searcher, $startdate, $enddate , $status, $drinkName, $price, $photo;
    public function render()
    {
        return view('livewire.kitchen.drink-component',[
            "drinks" => $this->getDrinksOfHotel()
        ])->layout('layouts.admin.app');
    }

    public function getDrinksOfHotel () {
        try {
        if ($this->searcher) {
            return Item::query()->where('hotel_id', auth()->user()->company_id)
            ->where('category', 'drink')
            ->where('name', 'like', '%'.$this->searcher.'%')
            ->paginate(6);
        }else if ($this->startdate && $this->enddate) {
            return Item::query()->where('hotel_id', auth()->user()->company_id)
            ->where('category', 'drink')
            ->whereBetween("created_at", [$this->startdate, $this->enddate])
            ->paginate(6);
        }else{
            return Item::query()->where('hotel_id', auth()->user()->company_id)
            ->where('category', 'drink')
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
    public function save () {
      DB::BeginTransaction();
        try {
            $file = '';
            if ($this->photo) {
            $fileName = md5($this->photo->getClientOriginalName()).'.'.$this->photo->getClientOriginalExtension();
            $file = $this->photo->storeAs("", $fileName);
            }
            Item::query()->create([
                "name" => $this->drinkName,
                "category" => $this->category,
                "price" => $this->price,
                "photo" => $file ,
                "hotel_id" => auth()->user()->company_id
            ]);
         DB::commit();
        $this->alert('success', 'SUCESSO', [
                'toast' =>false,
                'position'=>'center',
                'showConfirmButton'=>true,
                'confirmButtonText'=>'OK',
                 'timer' => 300000,
                'allowOutsideClick'=>false,
                'text'=> "Prato registado com sucesso!"
            ]);
            $this->closeModal();
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

    public function edit ($drinkId) {
        try {
        $this->drinkId = $drinkId;
        $this->status = true;
        $drinkInfo = Item::find($drinkId);
        $this->drinkName = $drinkInfo->name;
        $this->category = $drinkInfo->category;
        $this->price = $drinkInfo->price;
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

    public function update () {
        DB::beginTransaction();
        try {
            $file = '';
            if ($this->photo) {
            $fileName = md5($this->photo->getClientOriginalName()).'.'.$this->photo->getClientOriginalExtension();
            $file = $this->photo->storeAs("", $fileName);
            }

            $oldInfo = drink::find($this->drinkId);
            Item::find($this->drinkId)->update([
            "name" => $this->drinkName,
            "price" => $this->price,
            "category" => $this->category,
            "photo" => $file != ''  ? $file : $oldInfo->photo,
            "hotel_id" => auth()->user()->company_id
            ]);
            DB::commit();
            $this->alert('success', 'SUCESSO', [
                'toast' =>false,
                'position'=>'center',
                'showConfirmButton'=>true,
                'confirmButtonText'=>'OK',
                 'timer' => 300000,
                'allowOutsideClick'=>false,
                'text'=> "Dados atualizados com sucesso!"
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

    public function delete ($drinkId) {
        try {
           $this->drinkId = $drinkId;
           $this->alert('warning', 'Confirmar', [
            'icon' => 'warning',
            'position' => 'center',
            'toast' => false,
            'text' => "Deseja eliminar este registo?",
            'showConfirmButton' => true,
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancelar',
            'confirmButtonText' => 'Confirmar',
            'confirmButtonColor' => '#3085d6',
            'cancelButtonColor' => '#d33',
            'timer' => '300000',
            'onConfirmed' => 'confirmdrinkDeletion'
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

    public function confirmdrinkDeletion () {
        try {
        DB::beginTransaction();
        drink::destroy($this->drinkId);
        DB::commit();
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
         $this->reset(["drinkName", "category", "photo", "price"]);
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
