<?php

namespace App\Http\Livewire\Stock;

use App\Models\{Category, Product};
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class ProductComponent extends Component
{
    use LivewireAlert, WithPagination;
    public $productId,$startdate, $enddate,$status ,$product ,$category, $quantity, $searcher;
    protected $listeners = ['confirmProductDeletion' => 'confirmProductDeletion'];
    public function render()
    {
        return view('livewire.stock.product-component',[
            "products" =>$this->getProducts(),
            'categories' =>$this->getCategories()
        ])->layout('layouts.admin.app');
    }

    public function getProducts () {
        try{
            if ($this->searcher) {
            return Product::query()->where('hotel_id', auth()->user()->company_id)
            ->with("category")
            ->paginate(5);

            }else if ($this->startdate && $this->enddate) {
                return Product::query()->where('hotel_id', auth()->user()->company_id)
                ->whereBetween('created_at',[$this->startdate,$this->enddate])
                ->with("category")
                ->paginate(5);
            }else{
                return Product::query()->where('hotel_id', auth()->user()->company_id)
                ->with("category")
                ->paginate(5);
            }
        }catch(\Throwable $th) {

        }
    }

    public function save (Product $product) {
        try {
          DB::BeginTransaction();
          $product->query()->create([
          "product" =>$this->product,
          "category_id" =>$this->category,
          "user_id" => auth()->user()->id,
          'hotel_id' => auth()->user()->company_id
          ]);
          DB::commit();
          $this->alert('success', 'SUCESSO', [
            'toast' =>false,
            'position'=>'center',
            'showConfirmButton'=>true,
            'confirmButtonText'=>'OK',
            'timer' => 300000,
            'allowOutsideClick'=>false,
            'text'=>'Produto cadastrado com sucesso!'
        ]);
        $this->reset(["product","category","quantity"]);
        } catch (\Exception $th) {
          DB::rollBack();
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


    public function getCategories () {
        try {
           return Category::query()
           ->select(['id', 'category'])
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

    public function closeModal () {
        try {
           $this->status = false;
           $this->reset(['product', 'category' ,'quantity']);
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

    public function edit ($id) {
        try {
          $this->status = true;
          $this->productId = $id;
          $data = Product::find($this->productId);
          $this->product = $data->product;
          $this->category = $data->category_id;

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

    public function delete ($id) {
        try {
            $this->this->productId = $id;
            $this->alert('warning', 'Confirmar', [
                'icon' => 'warning',
                'position' => 'center',
                'toast' => false,
                'text' => "Deseja excluir este produto?",
                'showConfirmButton' => true,
                'showCancelButton' => true,
                'cancelButtonText' => 'Cancelar',
                'confirmButtonText' => 'Confirmar',
                'confirmButtonColor' => '#3085d6',
                'cancelButtonColor' => '#d33',
                'timer' => '300000',
                'onConfirmed' => 'confirmProductDeletion'
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

    public function confirmProductDeletion () {
        try {
           DB::beginTransaction();
           Product::destroy($this->$this->productId);
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

    public function update (Product $product) {
            try {
            DB::BeginTransaction();
            $product->query()->find($this->productId)->update([
                'product' =>$this->product,
                'category_id' =>$this->category,
                'hotel_id' => auth()->user()->company_id
            ]);
            DB::commit();
            $this->alert('success', 'SUCESSO', [
                'toast' =>false,
                'position'=>'center',
                'showConfirmButton'=>true,
                'confirmButtonText'=>'OK',
                'timer' => 300000,
                'allowOutsideClick'=>false,
                'text'=>'Produto atualizado com sucesso!'
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
}
