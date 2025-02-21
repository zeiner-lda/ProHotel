<?php

namespace App\Http\Livewire\Stock;

use App\Models\{Category};
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryComponent extends Component
{
    use LivewireAlert, WithPagination;
    public $searcher, $startdate, $enddate, $status, $category, $categoryId;
    protected $listeners = ['confirmCategoryDeletion' => 'confirmCategoryDeletion'];
    public function render()
    {
        return view('livewire.stock.category-component',[
            "categories" =>$this->getCategories(),
        ])->layout('layouts.admin.app');
    }

    public function getCategories () {
        try {
            if ($this->searcher) {
                return Category::query()->orderBy("id", "DESC")               
                ->where('category', 'like','%'.$this->searcher.'%')
                ->where('hotel_id', auth()->user()->company_id)
                ->paginate(6);
            }else if($this->startdate && $this->enddate){
                return Category::query()->orderBy("id", "DESC")               
                ->whereBetween('created_at', [$this->startdate,$this->enddate])
                ->where('hotel_id', auth()->user()->company_id)
                ->paginate(6);           
             }else{
                return Category::query()->orderBy("id", "DESC")   
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

    public function save (Category $category) {
        try {
            DB::BeginTransaction();
            $category->query()->create([
                "category" =>$this->category,
                "user_id" => auth()->user()->id,
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
                'text'=>'Categoria salva com sucesso!'
            ]);
            $this->reset(["category"]);
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

    public function delete ($id) {
        try {
            $this->categoryId = $id;
            $this->alert('warning', 'Confirmar', [
                'icon' => 'warning',
                'position' => 'center',
                'toast' => false,
                'html' => "<span>Deseja remover esta categoria?</span>",
                'showConfirmButton' => true,
                'showCancelButton' => true,
                'cancelButtonText' => 'Cancelar',
                'confirmButtonText' => 'Confirmar',
                'confirmButtonColor' => '#3085d6',
                'cancelButtonColor' => '#d33',
                'timer' => '300000',
                'onConfirmed' => 'confirmCategoryDeletion'
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

    public function confirmCategoryDeletion(Category $category) {
        try {
          DB::BeginTransaction();
          $category->destroy($this->categoryId);
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

    public function edit ($categoryId) {
        try {
            $this->status = true;
            $this->categoryId = $categoryId;          
            $data = Category::where('id',$this->categoryId)->first();
            $this->category = $data->category;
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
        try {
            DB::BeginTransaction();
            Category::find($this->categoryId)->update([
            "category" =>$this->category,
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
                'text'=>'Categoria atualizada com sucesso!'
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
            $this->reset(["category"]);
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
