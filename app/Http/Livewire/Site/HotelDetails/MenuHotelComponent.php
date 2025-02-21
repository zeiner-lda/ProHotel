<?php

namespace App\Http\Livewire\Site\HotelDetails;

use App\Models\Item;
use App\Models\OrderClient;
use App\Models\OrderNotification;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class MenuHotelComponent extends Component
{
    use LivewireAlert;
    public $itemId, $order,$drink, $dish,$hotelId, $item, $menuHotelDishesAndDrinksStatus, $menuHotelDishesStatus, $menuHotelDrinksStatus;
    protected $listeners = ["confirmOrderItemDeletion" => "confirmOrderItemDeletion" , "finishOrderItems" => "finishOrderItems"];

    public function mount($hotelId) {
        try {
        $this->hotelId = $hotelId;
        $this->menuHotelDishesAndDrinksStatus = true;
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
        return view('livewire.site.hotel-details.menu-hotel-component',[
            'orderedItems' => $this->getClientOrderedItems(),
            'drinksAndDishes' =>$this->getItemsInMenuOfHotel()
        ]);
    }

    public function login() {
        try {
           return redirect()->route('login');
        } catch (\Throwable $th) {
        $this->alert('error', 'ERRO', [
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

    public function buttonGetAllDrinksAndDishesFromCurrentHotel () {
        try {
            $this->menuHotelDishesAndDrinksStatus = true;
            $this->menuHotelDrinksStatus = false;
            $this->menuHotelDishesStatus = false;
        } catch (\Throwable $th) {
        $this->alert('error', 'ERRO', [
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

    public function buttonGetDrinksFromHotel () {
        try {
            $this->menuHotelDrinksStatus = true;
            $this->menuHotelDishesAndDrinksStatus = false;
            $this->menuHotelDishesStatus = false;
        } catch (\Throwable $th) {
        $this->alert('error', 'ERRO', [
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

    public function buttonGetDishesFromHotel () {
        try {
            $this->menuHotelDishesStatus = true;
            $this->menuHotelDishesAndDrinksStatus = false;
            $this->menuHotelDrinksStatus = false;
        } catch (\Throwable $th) {
        $this->alert('error', 'ERRO', [
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

    public function getItemsInMenuOfHotel () {
        try {
            if ($this->menuHotelDishesAndDrinksStatus) {
            return Item::query()->where('hotel_id',$this->hotelId)->get();
            }else if ($this->menuHotelDrinksStatus) {
               return Item::query()->where('hotel_id',$this->hotelId)
               ->where('category','drink')
                ->get();
            }else if ($this->menuHotelDishesStatus) {
                return Item::query()->where('hotel_id',$this->hotelId)
                ->where('category','dish')
                ->get();
            }

        } catch (\Throwable $th) {
        $this->alert('error', 'ERRO', [
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

    public function orderItem($orderItemId) {
    try {
        $this->item = Item::find($orderItemId);
        $order = OrderClient::query()->where("item_id",$this->item->id)
        ->where("hotel_id", $this->hotelId)
        ->where("user_id", auth()->user()->id)
        ->where("status", false)
        ->first();

         $userAlreadyReservedRoom = Reservation::query()
         ->where('guest_id', auth()->user()->guest_id)
         ->with("room")
         ->where('hotel_id',  $this->hotelId)
        ->where('reservation_status', 'confirmed')
         ->first();


        if (!$userAlreadyReservedRoom) {
            $this->alert('warning', 'AVISO', [
                'toast'  => false,
                'position' => 'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'Fechar',
                'confirmButtonColor' => '#000',
                'timer'  =>  300000,
                'text'  =>  "Ainda não reservou um quarto neste hotel!"
            ]);
        }else if ($userAlreadyReservedRoom->reservation_status == "pending") {
            $this->alert('warning', 'AVISO', [
                'toast'  => false,
                'position' => 'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'Fechar',
                'confirmButtonColor' => '#000',
                'timer'  =>  300000,
                'text'  =>  "Ainda não efectuou o checking conclua o processo para efectuar pedidos!"
            ]);

        }else {


            if ($order){
                DB::beginTransaction();
                OrderClient::query()->where("item_id",$this->item->id)->update([
                    "order_name" => $this->item->name,
                    "order_price" =>  $this->item->price += $this->item->price,
                    "order_room" => $userAlreadyReservedRoom->room->room_number,
                    "item_id" =>  $this->item->id,
                    "order_quantity" => $order->order_quantity += 1,
                    "status" => false,
                    "hotel_id" => $this->hotelId
                ]);
                DB::commit();
                $this->alert('success', 'SUCESSO', [
                    'toast'  => false,
                    'position' => 'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'Fechar',
                    'confirmButtonColor' => '#000',
                    'timer'  =>  300000,
                    'width' => '30rem',
                    'allowOutsideClick' => true,
                    'html'  =>  "<strong class='text-uppercase'>".$this->item->name."</strong>". "<span>, adicionado ao seu pedido!</span>"
                ]);

            }else{
                DB::beginTransaction();
                OrderClient::create([
                    "order_name" => $this->item->name,
                    "order_price" =>  $this->item->price,
                    "order_room" => $userAlreadyReservedRoom->room->room_number,
                    "order_photo" =>  $this->item->photo,
                    "item_id" =>  $this->item->id,
                    "order_quantity" =>  1,
                    "order_status" => "pending",
                    "user_id" => auth()->user()->id,
                    "status" => false,
                    "hotel_id" => $this->hotelId
                ]);
                DB::commit();
                $this->alert('success', 'SUCESSO', [
                    'toast'  => false,
                    'position' => 'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'Fechar',
                    'confirmButtonColor' => '#000',
                    'timer'  =>  300000,
                    'width' => '30rem',
                    'allowOutsideClick' => true,
                    'html'  =>  "<strong class='text-uppercase'>".$this->item->name."</strong>". "<span>, adicionado ao seu pedido!</span>"
                ]);
            }

        }

    } catch (\Throwable $th) {
        DB::rollBack();
        $this->alert('error', 'ERRO', [
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

    public function getClientOrderedItems () {
        try {
           return OrderClient::query()->where("user_id", auth()->user()->id)
           ->where("hotel_id", $this->hotelId)
           ->where("status", false)
           ->get();

        } catch (\Throwable $th) {
            $this->alert('error', 'ERRO', [
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

    public function deleteItem($itemId) {
        try {
             $this->itemId = $itemId;
            $this->alert('warning', 'Confirmar', [
                'icon' => 'warning',
                'position' => 'center',
                'toast' => false,
                'showConfirmButton' => true,
                'showCancelButton' => true,
                'cancelButtonText' => 'Cancelar',
                'confirmButtonText' => 'Confirmar',
                'confirmButtonColor' => '#3085d6',
                'cancelButtonColor' => '#d33',
                'text' => "Deseja remover este item da sua lista de pedidos?",
                'timer' => '300000',
                'onConfirmed' => 'confirmOrderItemDeletion'
            ]);
        } catch (\Throwable $th) {
            $this->alert('error', 'ERRO', [
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

    public function confirmOrderItemDeletion () {
        try {
           return OrderClient::destroy($this->itemId);
        } catch (\Throwable $th) {
            $this->alert('error', 'ERRO', [
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

    public function finishOrder() {
        try {
            $this->alert('warning', 'Confirmar', [
                'icon' => 'warning',
                'position' => 'center',
                'toast' => false,
                'showConfirmButton' => true,
                'showCancelButton' => true,
                'cancelButtonText' => 'Cancelar',
                'confirmButtonText' => 'Confirmar',
                'confirmButtonColor' => '#3085d6',
                'cancelButtonColor' => '#d33',
                'text' => "Deseja finalizar os seus pedidos?",
                'timer' => '300000',
                'onConfirmed' => 'finishOrderItems'
            ]);

        } catch (\Throwable $th) {
        $this->alert('error', 'ERRO', [
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

    public function finishOrderItems () {
        try {
         $orderRoom = OrderClient::select("order_room")->where("user_id",auth()->user()->id)
        ->where("hotel_id",$this->hotelId)
        ->where("status", false)
        ->first();

         DB::BeginTransaction();
         OrderClient::query()->where("hotel_id", $this->hotelId)
         ->where("user_id",auth()->user()->id)
         ->where("status",false)->update([
         "status" => true
         ]);

         OrderNotification::create([
            'notification_title' => "Pedido de itens para o quarto ".$orderRoom->order_room,
            'notification' => "Consulte a lista de pedidos para confirmar!",
            "guest_id" => auth()->user()->guest_id,
            'hotel_id' => $this->hotelId,
         ]);
         DB::commit();

         $this->alert('success', 'SUCESSO', [
            'toast'  => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' => 'OK',
            'timer'  =>  300000,
            'allowOutsideClick' => false,
            'text'  =>  "O seu pedido foi reservado com sucesso"
        ]);
        } catch (\Throwable $th) {
        DB::rollBack();
        $this->alert('error', 'ERRO', [
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
