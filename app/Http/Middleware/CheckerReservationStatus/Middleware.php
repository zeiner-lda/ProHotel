<?php

namespace App\Http\Middleware\CheckerReservationStatus;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Middleware
{
    public $referenceHourSubtracting12hours, $dataToUpdateBeacauseTheyWasExpired, $data, $avaliableRooms, $currentDate, $currentHour ,$rervedRooms;

    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() || !auth()->check()) {
            $this->checkAllReservationtatusAndMakeUpdates();
            $this->checkAllAntecipatedReservesAndMakeUpdates();
            return $next($request);
        }
    }

    public function checkAllReservationtatusAndMakeUpdates () {
        try {
            $this->currentHour = \Carbon\Carbon::now();
            $this->rervedRooms = \App\Models\Reservation::query()->where("reservation_status","pending")->where('antecipated_reservation_date',null)->get();

            if (isset($this->rervedRooms)) {
                $referenceHourSubtracting12hours = $this->currentHour->subHours(12)->format('H:i:s');  // Hora atual menos 12 horas

                // Realiza a atualização
                    $this->dataToUpdateBeacauseTheyWasExpired = DB::table('reservations')
                    ->whereTime("reservation_hour", '>=', $this->referenceHourSubtracting12hours)
                    ->where("reservation_status" , "pending")
                    ->get();

                     foreach ($this->dataToUpdateBeacauseTheyWasExpired as $reservation) {
                         DB::BeginTransaction();
                         \App\Models\Reservation::whereTime("reservation_hour", '>=', $this->referenceHourSubtracting12hours)
                         ->update([
                           "reservation_status" => 'expired'
                          ]);

                          //Desocupar o quarto automaticamente em caso de reserva expirada
                          \App\Models\Room::query()->where("id", $reservation->room_id)
                          ->update([
                            "status" => "available"
                          ]);
                        DB::commit();
                     }

            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error' , $th->GetMessage());
        }
    }

    public function checkAllAntecipatedReservesAndMakeUpdates () {
        try {
            $this->currentDate = \Carbon\Carbon::now()->format('Y-m-d');
            $this->data = \App\Models\Reservation::query()->where('antecipated_reservation_date', '!=',null)->get();
            $this->avaliableRooms = \App\Models\Room::query()->get();

            foreach ($this->data as $antecipatedReservation) {
                if ($this->currentDate == $antecipatedReservation->antecipated_reservation_date) {
                    foreach ($this->avaliableRooms as $room) {
                        //Atualização dos quartos que foram antecipados para reservados
                        DB::BeginTransaction();
                        \App\Models\Room::query()->where('id',$antecipatedReservation->room_id)
                        ->update([
                            'status' => 'occupied'
                        ]);
                        DB::commit();
                    }
                }
            }

        } catch (\Throwable $th) {
        DB::rollBack();
        return redirect()->back()->with('error' , $th->GetMessage());

        }
    }
}
