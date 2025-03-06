<?php

namespace App\Http\Livewire\Reception;

use App\Models\Checkout;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class CheckoutComponent extends Component
{
    use LivewireAlert, WithPagination;
    protected $listeners = ['confirmCheckoutDeletion' => 'confirmCheckoutDeletion'];
    public $checkoutId, $searcher , $startdate, $enddate;

    public function render()
    {
        return view('livewire.reception.checkout-component',[
            'data' => $this->getCheckouts(),
        ])->layout('layouts.admin.app');
    }

    public function getCheckouts () {
        try {

            if ($this->searcher) {
                return Checkout::query()->join('reservations', 'checkouts.reservation_id', '=', 'reservations.id')
                ->join('guests', 'reservations.guest_id', '=', 'guests.id')
                ->where('guests.firstname', 'like', '%' .$this->searcher.'%')
                ->orWhere('guests.binumber',$this->searcher)
                ->orWhere('guests.phone',$this->searcher)
                ->where('checkins.hotel_id', auth()->user()->company_id)
                ->select(['reservations.*', 'guests.*', 'checkouts.*', 'checkouts.id As checkoutId' , 'checkouts.created_at As checkoutDate'])
                ->orderBy('checkouts.id', 'DESC')
                ->paginate(6);

            }else if ($this->startdate and $this->enddate) {

                return Checkout::query()
                ->join('reservations', 'checkouts.reservation_id', '=', 'reservations.id')
                ->join('guests', 'reservations.guest_id', '=', 'guests.id')
                ->where('checkouts.hotel_id', auth()->user()->company_id)
                ->whereBetween('checkouts.created_at',[$this->startdate,$this->enddate])
                ->select(['reservations.*', 'guests.*', 'checkouts.*', 'checkouts.id As checkoutId' , 'checkouts.created_at As checkoutDate'])
                ->orderBy('checkouts.id', 'DESC')
                ->paginate(6);
            }else{
                return Checkout::query()->join('reservations', 'checkouts.reservation_id', '=', 'reservations.id')
                ->join('guests', 'reservations.guest_id', '=', 'guests.id')
                ->where('checkouts.hotel_id', auth()->user()->company_id)
                ->select(['reservations.*', 'guests.*', 'checkouts.*', 'checkouts.id As checkoutId' , 'checkouts.created_at As checkoutDate'])
                ->orderBy('checkouts.id', 'DESC')
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

    public function deleteCheckout ($checkoutId) {
        try {
            $this->checkoutId = $checkoutId;
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
                'onConfirmed' => 'confirmCheckoutDeletion'
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

    public function confirmCheckoutDeletion () {
        try {
            DB::BeginTransaction();
           Checkout::destroy($this->checkoutId);
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
}
