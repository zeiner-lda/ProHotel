<?php

namespace App\Http\Livewire\Reception;
use App\Models\Checkin;
use App\Models\Checkout;
use App\Models\Room;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class CheckinComponent extends Component
{
    use LivewireAlert, WithPagination;
    public $startdate, $enddate, $searcher, $checkinId;
    protected $listeners = ['confirmCheckout' => 'confirmCheckout', 'confirmCheckinDeletion' => 'confirmCheckinDeletion'];
    public function render()
    {
        return view('livewire.reception.checkin-component',[
            "data" => $this->getCheckins(),
        ])->layout('layouts.admin.app');
    }

    public function getCheckins () {
        try {
            if ($this->searcher) {
                return Checkin::query()->join('reservations', 'checkins.reservation_id', 'reservations.id')
                ->join('guests', 'reservations.guest_id', 'guests.id')
                ->join('rooms', 'reservations.room_id', 'rooms.id')
                ->where('guests.firstname', 'like', '%' .$this->searcher.'%')
                ->orWhere('guests.binumber',$this->searcher)
                ->orWhere('guests.phone',$this->searcher)
                ->where('checkins.hotel_id', auth()->user()->company_id)
                ->orderBy('checkins.id', 'DESC')
                ->select(['checkins.*', 'rooms.*', 'checkins.created_at As checkinDate','checkins.id As checkinId', 'guests.*', 'reservations.*'])
                ->paginate(6);

            }else if ($this->startdate and $this->enddate) {
                return Checkin::query()->join('reservations', 'checkins.reservation_id', 'reservations.id')
                ->join('guests', 'reservations.guest_id', 'guests.id')
                ->join('rooms', 'reservations.room_id', 'rooms.id')
                ->where('checkins.hotel_id', auth()->user()->company_id)
                ->whereBetween('checkins.created_at',[$this->startdate,$this->enddate])
                ->orderBy('checkins.id', 'DESC')
                ->select(['checkins.*', 'rooms.*', 'checkins.created_at As checkinDate','checkins.id As checkinId', 'guests.*', 'reservations.*'])
                ->paginate(6);

            }else{

                return Checkin::query()->join('reservations', 'checkins.reservation_id', 'reservations.id')
                ->join('guests', 'reservations.guest_id', 'guests.id')
                ->join('rooms', 'reservations.room_id', 'rooms.id')
                ->where('checkins.hotel_id', auth()->user()->company_id)
                ->orderBy('checkins.id', 'DESC')
                ->select(['checkins.*', 'rooms.*', 'checkins.created_at As checkinDate','checkins.id As checkinId', 'guests.*', 'reservations.*'])
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

    public function makeCheckout ($id) {
        try {
            $this->checkinId = $id;
            $this->alert('warning', 'Confirmar', [
                'icon' => 'warning',
                'position' => 'center',
                'toast' => false,
                'text' => "Deseja confirmar o  checkout?",
                'showConfirmButton' => true,
                'showCancelButton' => true,
                'cancelButtonText' => 'Cancelar',
                'confirmButtonText' => 'Confirmar',
                'confirmButtonColor' => '#3085d6',
                'cancelButtonColor' => '#d33',
                'timer' => '300000',
                'allowOutsideClick'=>false,
                'onConfirmed' => 'confirmCheckout'
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

    public function confirmCheckout (Checkin $checkin, Checkout $checkout, Room $room) {
        try {
            $checkinDetails = Checkin::find($this->checkinId)
            ->join('reservations', 'checkins.reservation_id', 'reservations.id')
            ->where('checkins.hotel_id' , auth()->user()->company_id)
            ->first();

            DB::BeginTransaction();
            //Tornar o quarto disponível
            $room->query()->find($checkinDetails->room_id)
            ->update([
             'status' => 'available',
            ]);

            //Alterar o status do checkin para false
            $checkin->query()->find($this->checkinId)->update([
                'status' => false,
            ]);

            $checkout->query()->create([
                'hotel_id' => auth()->user()->company_id,
                'reservation_id' => $checkinDetails->reservation_id,
            ]);
            DB::commit();
            $this->alert('success', 'SUCESSO', [
                'toast' =>false,
                'position'=>'center',
                'showConfirmButton'=>true,
                'confirmButtonText'=>'OK',
                'timer' => 300000,
                'allowOutsideClick'=>false,
                'text'=>'Checkout realizado com sucesso!'
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

    public function deleteCheckin ($checkinId) {
        try {
            $this->checkinId = $checkinId;
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
                'onConfirmed' => 'confirmCheckinDeletion'
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

        public function confirmCheckinDeletion () {
            try {
            DB::beginTransaction();
            return Checkin::destroy($this->checkinId);
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

