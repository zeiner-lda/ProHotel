<?php

namespace App\Http\Livewire\Site\AvailableHotelsInAngola;

use App\Models\{Company, Reservation, Testimonial};
use Carbon\Carbon;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class HotelComponent extends Component
{
    use LivewireAlert;
    public $searcher,$currentYear, $filterButtonAllHotels = true, $filterButtonMostRequestHotels, $filterButtonMostClassifiedHotels;

    public function render () {
    return view('livewire.site.available-hotels-in-angola.hotel-component',[
    'availablehotels' => $this->getAvailableHotelsInAngola()
     ]);
    }


    public function getAllHotels () {
        try {
           $this->filterButtonAllHotels = true;
           $this->filterButtonMostRequestHotels = false;
           $this->filterButtonMostClassifiedHotels = false;
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

    public function getAvailableHotelsInAngola () {
        try {
            $this->currentYear = Carbon::now()->format('Y');
            if ($this->searcher) {
            return Company::query()->where('companyname','like', '%'.$this->searcher.'%')->paginate(10);

            }else if ($this->filterButtonAllHotels){
            return Company::query()->paginate(10);

            }else if ($this->filterButtonMostRequestHotels) {
            return Reservation::query()->where('reservation_status', 'confirmed')
            ->join('companies', 'reservations.hotel_id', '=', 'companies.id')
            ->select([
                'companies.id',
                'companies.country',
                'companies.province',
                'companies.company_cover_photo',
                'companies.companyname',
                'reservations.hotel_id'
            ])
            ->havingRaw("COUNT(reservations.hotel_id) >= 3")
            ->groupBy([
                'companies.id',
                'companies.country',
                'companies.province',
                'companies.company_cover_photo',
                'companies.companyname',
                'reservations.hotel_id',
            ])
            ->whereYear('reservations.created_at', $this->currentYear)
            ->paginate(10);

            }else if ($this->filterButtonMostClassifiedHotels) {
                return Testimonial::query() ->where('star_quantity', '>=',3)
                ->where('visibility', 'public')
                ->with('hotel')
                ->orderBy('star_quantity', 'DESC')
                ->paginate(10);
            }
        } catch (\Throwable $th) {
        $this->alert('error', 'ERRO', [
                'toast' => false,
                'position' => 'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'timer' => 300000,
                'allowOutsideClick' => false,
                'text'=>'Ocorreu o seguinte erro: '.$th->getMessage()
            ]);
        }
    }

    public function getMostRequestedHotels () {
        try {
            $this->filterButtonMostRequestHotels = true;
            $this->filterButtonAllHotels = false;
            $this->filterButtonMostClassifiedHotels = false;
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

    public function getMostClassifiedHotels () {
        try {
            $this->filterButtonMostClassifiedHotels = true;
            $this->filterButtonMostRequestHotels = false;
            $this->filterButtonAllHotels = false;

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
