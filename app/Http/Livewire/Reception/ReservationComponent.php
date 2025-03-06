<?php

namespace App\Http\Livewire\Reception;

use App\Models\Checkin;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class ReservationComponent extends Component
{
    use LivewireAlert, WithPagination;
    public $reservationId, $startdate, $enddate, $checkinReportData = [], $searcher , $price , $quantityOfDays ,$payment_method, $notes;
    protected $listeners = ['confirmCancelReservation' => 'confirmCancelReservation'];
    public function render()
    {
        return view('livewire.reception.reservation-component',[
            "data" => $this->getReservations(),
            "availableRooms" => $this->getAvailableRooms(),
        ])->layout('layouts.admin.app');
    }

    public function getReservations () {
        try {
            if ($this->searcher) {
            return Reservation::query()->with("room")->with("guest")
            ->whereHas('guest', function ($query) {
            $query->where('firstname', 'like', '%'.$this->searcher.'%');
            })->orderBy('id', "DESC")
            ->paginate(6);

            }else if ($this->startdate and $this->enddate) {
                 return Reservation::query()->with("room")->with("guest")
                ->whereBetween('created_at', [$this->startdate,$this->enddate])
                ->orderBy('id', "DESC")
                ->paginate(6);
            }else {
                return Reservation::query()->with("room")->with("guest")
                ->orderBy('id', "DESC")
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

    public function getAvailableRooms () {
        try {
            return Room::query()->where('status', 'available')->get();
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

    public function makeCheckin ($reservationId) {
        try {
          $this->reservationId = $reservationId;
          $checkin = Reservation::query()->where('id',$this->reservationId)
          ->with('room')
          ->get();

          foreach($checkin as $data){
              $this->price = isset($data->room->price_pernight) ? $data->room->price_pernight : 0 ;
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

    public function chooseQuantityOfDays () {
        try {

          if ($this->quantityOfDays) {
          $this->price = $this->price * $this->quantityOfDays;
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

    public function finishCheckin (Reservation $reservation, Checkin $checkin)  {
        try {
            $currentDFullDateAndTime = Carbon::now();
            if ($this->quantityOfDays == 0) {
                $this->alert('warning', 'AVISO', [
                    'toast' =>false,
                    'position'=>'center',
                    'showConfirmButton'=>true,
                    'confirmButtonText'=>'OK',
                    'timer' => 300000,
                    'allowOutsideClick'=>false,
                    'text'=>"Especifique a quantidade de dias que o hóspede ficará hospedado!"
                 ]);
            }else{
              DB::BeginTransaction();
               //Atualizar dados da reserva do quarto
               $reservation->query()->find($this->reservationId)->update([
                'reservation_status' =>'confirmed',
               ]);

               //Registrar checkin
              $data = $checkin->query()->create([
                'quantity_days' =>$this->quantityOfDays,
                'reservation_id' =>$this->reservationId,
                'payment_method' =>$this->payment_method,
                'total_amount' =>$this->price,
                'hotel_id' => auth()->user()->company_id,
                'notes' =>$this->notes
               ]);

               $checkinReportData = Checkin::find($data->id);
              $this->alert('success', 'SUCESSO', [
                'toast' =>false,
                'position'=>'center',
                'showConfirmButton'=>true,
                'confirmButtonText'=>'OK',
                'timer' => 300000,
                'allowOutsideClick'=>false,
                'text'=>'Checkin realizado com sucesso!'
            ]);
           }

           $dompdf = new Pdf();
           $dompdf = Pdf::loadView('pdfs.checkin-report',[
               'data' => $checkinReportData ,
           ])->setPaper('a4', 'portrait')->output();
           return response()->streamDownload(
               fn () => print($dompdf),
               "relatório-de-checkin_".md5(\Carbon\Carbon::now()->format('d-m-y')).".pdf"
           );
           DB::commit();
           $this->reset(["payment_method", "price", "quantityOfDays", "notes"]);
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

    public function cancelReservation ($id) {
        try {

            $this->reservationId = $id;
            $this->alert('warning', 'Confirmar', [
                'icon' => 'warning',
                'position' => 'center',
                'toast' => false,
                'text' => "Deseja cancelar esta reserva?",
                'showConfirmButton' => true,
                'showCancelButton' => true,
                'cancelButtonText' => 'Cancelar',
                'confirmButtonText' => 'Confirmar',
                'confirmButtonColor' => '#3085d6',
                'cancelButtonColor' => '#d33',
                'timer' => '300000',
                'allowOutsideClick'=>false,
                'onConfirmed' => "confirmCancelReservation"
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



    public function confirmCancelReservation () {
    try {

       DB::beginTransaction();
       $reservationInfo = DB::table("reservations")->find($this->reservationId);
       DB::table("rooms")->where("id", $reservationInfo->room_id)
       ->update([
            "status" => "available"
        ]);
        Reservation::destroy([$this->reservationId]);
       DB::commit();
        } catch (\Throwable $th) {
       DB::commit();
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
