<?php

namespace App\Http\Livewire\Admin;

use App\Models\Notification;
use App\Models\OrderClient;
use App\Models\OrderNotification;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class TopBarComponent extends Component
{
    use LivewireAlert;
    protected $listeners = ['confirm' => 'confirm'];
    
    public function render()
    {
        return view('livewire.admin.top-bar-component',[
            'allreservedNotifications' =>$this->getReservationNotifications(),
            'notificationsCounter' =>$this->getReservedNotificationsCounter(),
            'orderNotificationCounter' => $this->getOrderClientCounter(),
            'allOrderClientNotifications' => $this->getAllOrderClientNotifications()
        ]);
    }

    public function getReservedNotificationsCounter () {
        try {
        return Notification::query()
        ->where('hotel_id',auth()->user()->company_id)
        ->where('status',false)
        ->count();
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

    public function getOrderClientCounter () {
        try {
        return OrderNotification::query()
        ->where('status',false)
        ->where('hotel_id',auth()->user()->company_id) 
        ->count();
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

    public function changeStatusAboutSeenNotifications (){
        try {
         fn () => DB::beginTransaction();
         Notification::query()->where('hotel_id', auth()->user()->company_id)->update([
            'status' => true
         ]);
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

    public function changeStatusAboutSeenNotificationsOfOrders (){
        try {
        fn () => DB::beginTransaction();
         OrderNotification::query()->where('hotel_id', auth()->user()->company_id)->update([
            'status' => true
         ]);
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
    

    public function getReservationNotifications () {
        try {
           return Notification::query()
           ->where('hotel_id',auth()->user()->company_id)
           ->where('status',true) 
           ->orderBy('id', 'DESC')
           ->limit(10)
           ->get();

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

   public function logout () {
        try{
              $this->alert('warning', 'Confirmar', [
                'icon' => 'warning',
                'position' => 'center',
                'toast' => false,
                'text' => "Deseja terminar sessão?",
                'showConfirmButton' => true,
                'showCancelButton' => true,
                'cancelButtonText' => 'Cancelar',
                'confirmButtonText' => 'Confirmar',
                'confirmButtonColor' => '#3085d6',
                'cancelButtonColor' => '#d33',
                'timer' => '300000',              
                'onConfirmed' => 'confirm'
            ]);

        }catch(\Exception $th){
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

    public function confirm () {
        try {
            auth()->logout();
            return redirect()->route('login');
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

    public function getAllOrderClientNotifications () {
        try {
          return OrderNotification::where("hotel_id",auth()->user()->company_id)
          ->where("status", true)
          ->get();
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


}
