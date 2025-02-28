<?php

namespace App\Http\Livewire\Client;

use \App\Models\{Company, Testimonial};
use Exception;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class TestimonialComponent extends Component
{
    use LivewireAlert, WithPagination;
    public $status, $startdate, $enddate, $searcher, $testimony, $starquantity, $testimonyId, $hotelId, $hotelName ,$testimonial ,$choosedStar, $starNumbers;
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

        return view('livewire.client.testimonial-component',[
           'testimonials' => $this->getTestimonials(),
           'allAvailableHotelsInAngola' => $this->getAllHotelsInAngola()
        ])->layout("layouts.client-dashboard.app");

    }

    public function chooseStarQuantity ($starNumbers) {
        try {
            $this->choosedStar = true;
            $this->starNumbers = $starNumbers;
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

    public function save (Testimonial $testimonial) {
        $this->validate();
        try {
        $this->hotelName  = Company::find($this->hotelId);
        $clientAlreadyMadeTestimonial = Testimonial::query()->where('user_id',auth()->user()->id)
        ->where('visibility', 'public')
        ->where('hotel_id',$this->hotelId)
        ->pluck('user_id')
        ->first();


        if (!$clientAlreadyMadeTestimonial) {

            if (!$this->starNumbers) {
                $this->alert('warning', 'ATENÇÃO', [
                    'toast' =>false,
                    'position'=>'center',
                    'showConfirmButton'=>true,
                    'confirmButtonText'=>'OK',
                    'timer' => 300000,
                    'allowOutsideClick'=>false,
                    'html'=>'<span>Avalie-nos selecionando uma quantidade de estrelas!</span>'
                ]);

            }else{
                DB::BeginTransaction();
                $testimonial->query()->create([
                   "text" =>$this->testimonial,
                   'star_quantity' =>$this->starNumbers,
                   'hotel_id' =>$this->hotelId,
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
                   'html'=>'<span>O seu depoimento foi adicionado com sucesso e será revisado pela nossa equipa para posterior aprovação!</span>'
               ]);
               $this->reset(["testimonial", "starNumbers", "hotelId"]);
            }

        }else {
            $this->alert('warning', 'ATENÇÃO', [
                'toast' =>false,
                'position'=>'center',
                'showConfirmButton'=>true,
                'confirmButtonText'=>'OK',
                'timer' => 300000,
                'allowOutsideClick'=>false,
                'html'=>'<span>Não pode fazer mais de uma avaliação para o ,<strong>'.$this->hotelName->companyname. '</strong> tente novamente outro!</span>'
            ]);
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
             'text'=>'Ocorreu o seguinte erro: '.$th->GetMessage()
             ]);
        }
    }


    public function getTestimonials () {
        try {
            if ($this->searcher) {
                return Testimonial::query()->where('user_id', auth()->user()->id)
                ->where("text", 'like', '%'.$this->searcher.'%')
                ->paginate(6);
            }else if ($this->startdate && $this->enddate) {
                return Testimonial::query()->where('user_id', auth()->user()->id)
                ->whereBetween("created_at", [$this->startdate, $this->enddate])
                ->paginate(6);
            }else {
                return Testimonial::query()->where('user_id', auth()->user()->id)
                ->paginate(6);
            }

        } catch (\Throwable $th) {
            $this->alert('warning', 'AVISO', [
                'toast'  => false,
                'position' => 'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'timer'  =>  300000,
                'allowOutsideClick' => false,
                'text'  =>  $th->GetMessage()
                ]);
        }
    }

    public function getAllHotelsInAngola () {
        try {
          return Company::query()->select(['id','companyname'])
          ->get();
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

    public function editTestimonial ($id) {
        try {
            $this->status = true;
           $this->testimonyId = $id;
           $data = Testimonial::find($this->testimonyId);
           $this->testimony = $data->text;
           $this->hotelId = $data->hotel_id;
           $this->starquantity = $data->star_quantity;
        } catch (\Throwable $th) {
        $this->alert('warning', 'AVISO', [
            'toast'  => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' => 'OK',
            'timer'  =>  300000,
            'allowOutsideClick' => false,
            'text'  =>  $th->GetMessage()
            ]);
        }
    }


    public function updateTestimonial () {
        DB::BeginTransaction();
        try {
            Testimonial::find($this->testimonyId)->update([
            'text' => $this->testimony,
            'hotel_id' => $this->hotelId,
            'star_quantity' => $this->starquantity
            ]);
        DB::commit();
        $this->alert('success', 'SUCESSO', [
            'toast'  => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' => 'OK',
            'timer'  =>  300000,
            'allowOutsideClick' => false,
            'text'  =>  "Dados atualizados com sucesso!"
            ]);

        } catch (\Throwable $th) {
        DB::rollBack();
        $this->alert('warning', 'AVISO', [
                'toast'  => false,
                'position' => 'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'timer'  =>  300000,
                'allowOutsideClick' => false,
                'text'  =>  $th->GetMessage()
                ]);
        }
    }

    public function deleteTestimonial ($testimonyId) {
        try {
            $this->testimonyId = $testimonyId;
            $this->alert('warning', 'Confirmar', [
                'icon' => 'warning',
                'position' => 'center',
                'toast' => false,
                'text' => "Deseja exluir este registo?",
                'showConfirmButton' => true,
                'showCancelButton' => true,
                'cancelButtonText' => 'Cancelar',
                'confirmButtonText' => 'Confirmar',
                'confirmButtonColor' => '#3085d6',
                'cancelButtonColor' => '#d33',
                'timer' => '300000',
                'onConfirmed' => 'confirmTestimonialDeletion'
            ]);
        } catch (\Throwable $th) {
        $this->alert('warning', 'AVISO', [
                'toast'  => false,
                'position' => 'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'timer'  =>  300000,
                'allowOutsideClick' => false,
                'text'  =>  $th->GetMessage()
                ]);
        }
    }

    public function confirmTestimonialDeletion () {
        try {
            DB::beginTransaction();
            Testimonial::destroy($this->testimonyId);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        $this->alert('warning', 'AVISO', [
                'toast'  => false,
                'position' => 'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'timer'  =>  300000,
                'allowOutsideClick' => false,
                'text'  =>  $th->GetMessage()
                ]);
        }
    }

      public function closeModal () {
        try {
            $this->status = false;
           $this->reset(['testimonyId','hotelId','starquantity' , 'testimony']);
        } catch (\Throwable $th) {
        $this->alert('warning', 'AVISO', [
                'toast'  => false,
                'position' => 'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'timer'  =>  300000,
                'allowOutsideClick' => false,
                'text'  =>  $th->GetMessage()
            ]);
        }
    }
}
