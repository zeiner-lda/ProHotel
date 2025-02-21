<?php

namespace App\Http\Livewire\Site\HotelDetails;

use App\Models\{Notification, Reservation, Room};
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class RoomComponent extends Component
{
    use LivewireAlert;

    public  $roomId, $room, $hotelId ,$searcher, $reservedRoom, $reservation, $currentDate, $roomNumber , $roomPrice, $roomType, $roomInfo, $dateOfReservation;
    protected $listeners = ['confirmReservationByClient' => 'confirmReservationByClient'];
    protected $rules = ['dateOfReservation' => 'required'];
    protected $messages = ['dateOfReservation.required' => 'Preencha a data de reserva'];

    public function mount($hotelId){
        try {
            $this->hotelId = $hotelId;
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

    public function render()
    {
        return view('livewire.site.hotel-details.room-component',[
            'allrooms' => $this->getAllRooms()
        ]);
    }

    public function getAllRooms () {
        try {

            if (!$this->searcher) {
                return Room::query()->where('hotel_id',$this->hotelId)
                ->paginate(6);
            }else {
                return Room::query()->where('hotel_id',$this->hotelId)
                ->where('room_type', $this->searcher)
                ->paginate(6);
            }

        } catch (\Throwable $th) {
            $this->getAlertError($th);
        }
    }

    public function getAlertError ($exception) {
        try {
        return $this->alert('error', 'ERRO', [
                'toast' =>false,
                'position'=>'center',
                'showConfirmButton'=>true,
                'confirmButtonText'=>'OK',
                'timer' => 300000,
                'allowOutsideClick'=>false,
                'text'=>'Ocorreu o seguinte erro: '.$exception->getMessage()
            ]);

        }catch(\Throwable $th) {
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

    public function bookingRoom ($id) {
        try {
            $this->roomInfo = Room::query()->find($id);
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

    public function signIn () {
        try {
        return redirect()->route("login");
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

    public function storeReservationByClient () {
        $this->validate();
        try {
            $this->alert('warning', 'Confirmar', [
                'icon' => 'warning',
                'position' => 'center',
                'toast' => false,
                'html' => "<p>Deseja realmente reservar este quarto para o dia <strong>".\Carbon\Carbon::parse($this->dateOfReservation)->format('d-m-Y')."?</strong></p>",
                'showConfirmButton' => true,
                'showCancelButton' => true,
                "showCloseButton" => true,
                'cancelButtonText' => 'Cancelar',
                'confirmButtonText' => 'Confirmar',
                'confirmButtonColor' => '#3085d6',
                'cancelButtonColor' => '#d33',
                'timer' => '300000',
                'width' => '580px',
                'allowOutsideClick'=>false,
                'onConfirmed' => 'confirmReservationByClient'
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

    public function confirmReservationByClient () {
        try {
            $this->reservation = new Reservation();
            $this->reservedRoom = new Room;
           //Verificacao se o hospede ja havia reservado o quarto
           $guesAlreadyReserved = Reservation::query()->where('reservation_status', 'pending')
           ->where('guest_id', auth()->user()->guest_id)
           ->where('hotel_id', $this->hotelId)
           ->first();

           if (auth()->user()->profile != 'guest') {
            $this->alert('warning', 'AVISO', [
                'toast' =>false,
                'position'=>'center',
                'showConfirmButton'=>true,
                'confirmButtonText'=>'OK',
                'timer' => 300000,
                'allowOutsideClick'=>false,
                'text'=>'As reservas são apenas para utilizadores clientes. Crie a sua conta para poder reservar!'
            ]);

           }else if($guesAlreadyReserved) {
            $this->alert('warning', 'AVISO', [
                'toast' =>false,
                'position'=>'center',
                'showConfirmButton'=>true,
                'confirmButtonText'=>'OK',
                'timer' => 300000,
                'allowOutsideClick'=>false,
                'text'=>'Já reservou um quarto neste hotel, não pode reservar mais de um quarto!'
            ]);
           }else if (!$guesAlreadyReserved) {
            $currenthour =  Carbon::now()->format('H:i:s');
            $this->currentDate =  Carbon::now()->format("Y-m-d");

            if ($this->dateOfReservation == $this->currentDate) {
                DB::BeginTransaction();
                //Atualizar a informacao do quarto reservado
                $this->reservedRoom->find($this->roomInfo->id)->update(['status' => 'occupied']);
                $reservation = $this->reservation->query()->create([
                'guest_id' => auth()->user()->guest_id,
                'room_id' => $this->roomInfo->id,
                'reservation_status' => 'pending',
                'reservation_date' => $this->dateOfReservation,
                'reservation_hour' =>$currenthour,
                 'hotel_id' =>$this->hotelId
                ]);

                Notification::create([
                'notification_title' => 'Reserva de quarto',
                'notification' => 'Registada uma nova reserva para o quarto '.$this->roomInfo->room_number ,
                'status' => false,
                'reservation_id' =>  $reservation->id,
                'hotel_id' =>$this->hotelId
                 ]);
                DB::commit();
                $this->alert('success', 'SUCESSO', [
                    'toast' =>false,
                    'position'=>'center',
                    'showConfirmButton'=>true,
                    'confirmButtonText'=>'OK',
                    'timer' => 300000,
                    'allowOutsideClick'=>false,
                    'text'=>'A sua reserva foi feita com sucesso!'
                ]);

            }else {

               DB::BeginTransaction();
                //Atualizar a informacao do quarto reservado
                $reservation = $this->reservation->query()->create([
                    'guest_id' => auth()->user()->guest_id,
                    'room_id' => $this->roomInfo->id,
                    'reservation_status' => 'pending',
                    'antecipated_reservation_date' => $this->dateOfReservation,
                    'reservation_hour' => $currenthour
                ]);

                Notification::create([
                'notification' => 'Registada uma nova reserva' ,
                'reservation_id' =>  $reservation->id,
                'status' => false
                ]);

                DB::commit();
                $this->alert('success', 'SUCESSO', [
                    'toast' =>false,
                    'position'=>'center',
                    'showConfirmButton'=>true,
                    'confirmButtonText'=>'OK',
                    'timer' => 300000,
                    'allowOutsideClick'=>false,
                    'text'=>'A sua reserva foi antecipada com sucesso!'
                ]);
            }
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
                'text'=>'[Méthod: confirmReservationByClient] Ocorreu o seguinte erro: '.$th->getMessage()
            ]);
        }
    }

}
