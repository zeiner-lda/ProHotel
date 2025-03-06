<?php

namespace App\Http\Livewire\Reception;

use App\Models\Testimonial;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class TestimonialComponent extends Component
{
    use LivewireAlert, WithPagination;
    public $testimonialId,$testimonial, $startdate,  $enddate, $searcher;
    protected $listeners = ['confirmChangeVisibilityOfTestimonial' => 'confirmChangeVisibilityOfTestimonial', 'confirmTestimonialDeletion' => 'confirmTestimonialDeletion'];


    public function render()
    {
        return view('livewire.reception.testimonial-component',[
            'data' =>$this->getTestimonials()
        ])->layout('layouts.admin.app');
    }

    public function getTestimonials () {
        try {
            if ($this->searcher) {
                return Testimonial::query()->where('text', 'like', '%'.$this->searcher.'%')
                ->where('hotel_id', auth()->user()->company_id)
                ->with('user')
                ->with('hotel')
                ->select(['testimonials.*', 'testimonials.id As testimonialId', 'users.*', 'companies.*'])
                ->paginate(6);
            }else{
                return Testimonial::query()
                ->join('users', 'testimonials.user_id', 'users.id')
                ->join('companies', 'testimonials.hotel_id', 'companies.id')
                ->where('hotel_id', auth()->user()->company_id)
                ->select(['testimonials.*', 'testimonials.id As testimonialId', 'users.*', 'companies.*'])
                ->paginate(6);
            }

        } catch (\Throwable $th) {
        $this->alert('success', 'SUCESSO', [
                'toast' =>false,
                'position'=>'center',
                'showConfirmButton'=>true,
                'confirmButtonText'=>'OK',
                'timer' => 300000,
                'allowOutsideClick'=>false,
                'text'=>'Item adicionado com sucesso!'
            ]);
        }
    }

    public function changeVisibilityOfStatus ($testimonialId) {
        try {
            $this->testimonialId = $testimonialId;
            $this->alert('warning', 'Confirmar', [
                'icon' => 'warning',
                'position' => 'center',
                'toast' => false,
                'text' => "Deseja alterar visibilidade do depoimento?",
                'showConfirmButton' => true,
                'showCancelButton' => true,
                'cancelButtonText' => 'Cancelar',
                'confirmButtonText' => 'Confirmar',
                'confirmButtonColor' => '#3085d6',
                'cancelButtonColor' => '#d33',
                'timer' => '300000',
                'onConfirmed' => 'confirmChangeVisibilityOfTestimonial'
            ]);
        } catch (\Throwable $th) {
        $this->alert('success', 'SUCESSO', [
                'toast' =>false,
                'position'=>'center',
                'showConfirmButton'=>true,
                'confirmButtonText'=>'OK',
                'timer' => 300000,
                'allowOutsideClick'=>false,
                'text'=>'Item adicionado com sucesso!'
            ]);
        }
    }

    public function confirmChangeVisibilityOfTestimonial () {
        DB::BeginTransaction();
        try {
            $this->testimonial = Testimonial::find($this->testimonialId);
            Testimonial::find($this->testimonialId)->update([
                'visibility' =>  $this->testimonial->visibility == 'private' ? 'public' : 'private',
            ]);
        DB::commit();
        } catch (\Throwable $th) {
        DB::rollBack();
        $this->alert('success', 'SUCESSO', [
                'toast' =>false,
                'position'=>'center',
                'showConfirmButton'=>true,
                'confirmButtonText'=>'OK',
                'timer' => 300000,
                'allowOutsideClick'=>false,
                'text'=>'Item adicionado com sucesso!'
            ]);
        }
    }

    public function delete ($testimonialId) {
        try {
           $this->testimonialId = $testimonialId;
           $this->alert('warning', 'Confirmar', [
            'icon' => 'warning',
            'position' => 'center',
            'toast' => false,
            'text' => "Deseja excluir este registo?",
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
        $this->alert('success', 'SUCESSO', [
                'toast' =>false,
                'position'=>'center',
                'showConfirmButton'=>true,
                'confirmButtonText'=>'OK',
                'timer' => 300000,
                'allowOutsideClick'=>false,
                'text'=>'Item adicionado com sucesso!'
            ]);
        }
    }

    public function confirmTestimonialDeletion () {
        DB::BeginTransaction();
        try {
            Testimonial::destroy($this->testimonialId);
        DB::commit();
        } catch (\Throwable $th) {
        DB::rollBack();
            $this->alert('success', 'SUCESSO', [
                'toast' =>false,
                'position'=>'center',
                'showConfirmButton'=>true,
                'confirmButtonText'=>'OK',
                'timer' => 300000,
                'allowOutsideClick'=>false,
                'text'=>'Item adicionado com sucesso!'
            ]);
        }
    }
}
