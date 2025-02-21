<?php

namespace App\Http\Livewire\Kitchen;

use App\Models\Category;
use App\Models\{Dish, Item};
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class DishComponent extends Component
{
    use LivewireAlert, WithFileUploads, WithPagination;   
    protected $listeners = ["confirmDishDeletion" => "confirmDishDeletion"];
    public $category,$dishId, $dishInfo, $searcher, $startdate, $enddate , $status, $dishName, $price, $photo;
    public function render()
    {
        return view('livewire.kitchen.dish-component',[
           "dishes" => $this->getDishesOfHotel()
        ])->layout('layouts.admin.app');
    }

    public function getDishesOfHotel () {
        try {
        if ($this->searcher) {
            return Item::query()->where('hotel_id', auth()->user()->company_id)
            ->where('category', 'dish')
            ->where('name', 'like', '%'.$this->searcher.'%')
            ->paginate(6);
        }else if ($this->startdate && $this->enddate) {
            return Item::query()->where('hotel_id', auth()->user()->company_id)
            ->where('category', 'dish')
            ->whereBetween("created_at", [$this->startdate, $this->enddate])
            ->paginate(6);
        }else{
            return Item::query()->where('hotel_id', auth()->user()->company_id)
            ->where('category', 'dish')
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
                "name" => $this->dishName,
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

    public function edit ($dishId) {
        try {
        $this->dishId = $dishId;
        $this->status = true;
        $dishInfo = Item::find($dishId);
        $this->dishName = $dishInfo->name;
        $this->category = $dishInfo->category;
        $this->price = $dishInfo->price;
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
            $oldInfo = Item::find($this->dishId);
            Item::find($this->dishId)->update([
            "name" => $this->dishName,
            "price" => $this->price,
            "photo" => $file != '' ? $file : $oldInfo->photo,
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

    public function delete ($dishId) {
        try {
           $this->dishId = $dishId;
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
            'onConfirmed' => 'confirmDishDeletion'
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

    public function confirmDishDeletion () {
        try {
        DB::beginTransaction();
        Dish::destroy($this->dishId);
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
         $this->reset(["dishName", "price", "category", "photo"]);
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
