<?php

namespace App\Http\Livewire\Reception;
use Livewire\WithPagination;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class NotificationComponent extends Component
{
    use LivewireAlert, WithPagination;
    protected $listeners = ["confirmNotificationDeletion" => "confirmNotificationDeletion"];
    public $notificationId,$startdate , $enddate, $searcher;
    public function render()
    {
        return view('livewire.reception.notification-component',[
            "notifications" =>$this->getReservationNotifications()
        ])->layout('layouts.admin.app');
    }

    public function getReservationNotifications () {
        try {
            if ($this->searcher) {
                return Notification::query()
                ->where('hotel_id',auth()->user()->company_id)
                ->where('notification_title', 'like', '%'.$this->searcher.'%')
                ->orWhere('notification', 'like', '%'.$this->searcher.'%')
                ->where('status',true) 
                ->orderBy('id', 'DESC')
                ->paginate(6);         
            }else if($this->startdate && $this->enddate){
                return Notification::query()
                ->where('hotel_id',auth()->user()->company_id)
                ->where('created_at',[$this->startdate,$this->enddate])                
                ->where('status',true) 
                ->orderBy('id', 'DESC')
                ->paginate(6);         

            }else{
                return Notification::query()
                ->where('hotel_id',auth()->user()->company_id)
                ->where('status',true) 
                ->orderBy('id', 'DESC')
                ->paginate(6);          
            }

        } catch (\Throwable $th) {
            $this->alert('error', 'ERRO', [
                'toast' =>false,
                'position' =>'center',
                'showConfirmButton' =>true,
                'confirmButtonText' =>'OK',
                'timer' => 300000,
                'allowOutsideClick' => false,
                'text'=> 'Ocorreu o seguinte erro: '.$th->getMessage()
            ]);
        }
    }

    public function delete($notificationId){
        try {
            $this->notificationId = $notificationId;
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
                'onConfirmed' => 'confirmNotificationDeletion'
            ]);
        } catch (\Throwable $th) {
        $this->alert('error', 'ERRO', [
                'toast' =>false,
                'position' =>'center',
                'showConfirmButton' =>true,
                'confirmButtonText' =>'OK',
                'timer' => 300000,
                'allowOutsideClick' => false,
                'text'=> 'Ocorreu o seguinte erro: '.$th->getMessage()
            ]);
        }
    }

    public function confirmNotificationDeletion() {
        try {
        fn () => DB::BeginTransaction();
        return  Notification::destroy($this->notificationId);
        fn () => DB::commit();
        } catch (\Throwable $th) {
        fn () => DB::rollBack();
        $this->alert('error', 'ERRO', [
                'toast' =>false,
                'position' =>'center',
                'showConfirmButton' =>true,
                'confirmButtonText' =>'OK',
                'timer' => 300000,
                'allowOutsideClick' => false,
                'text'=> 'Ocorreu o seguinte erro: '.$th->getMessage()
            ]);
        }
    }
}
