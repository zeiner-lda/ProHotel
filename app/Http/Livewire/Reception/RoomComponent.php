<?php

namespace App\Http\Livewire\Reception;

use App\Models\Room;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class RoomComponent extends Component
{
    use LivewireAlert ,WithPagination, WithFileUploads;
    public $startdate, $enddate, $status,$roomstatus, $room = [], $bedquantity ,$bathquantity, $description, $dynamicStatus, $roomId, $data = [] ,$roomnumber , $roomtype , $roomcapacity , $price ,  $photo, $file , $searcher;
    protected $listeners = ["roomConfirmDeletion"   =>  "roomConfirmDeletion"];
    public function render()
    {
        return view('livewire.reception.room-component',[
            "rooms"   => $this->getRooms(),
        ])->layout('layouts.admin.app');
    }


    public function getRooms () {
        try {
            if ($this->searcher) {
            return Room::query()->where('hotel_id', auth()->user()->company_id)
            ->when($this->searcher,
            fn ($query)   =>  $query->where("room_number",$this->searcher))
            ->paginate(6);
            }else if ($this->startdate && $this->enddate) {
            return Room::query()->where('hotel_id', auth()->user()->company_id)
            ->whereBetween('created_at',[$this->startdate,$this->enddate])
            ->paginate(6);
            }else{
            return Room::query()->where('hotel_id', auth()->user()->company_id)
            ->paginate(6); ;
            }

        } catch (\Throwable $exception) {
            $this->getAlertError($exception);
        }
    }

    public function save () {
        //$this->validate();
       DB::BeginTransaction();
       try {

        $file = '';
        if ($this->photo) {
        $fileName = md5($this->photo->getClientOriginalName()).'.'.$this->photo->getClientOriginalExtension();
        $file = $this->photo->storeAs("", $fileName);
        }
        Room::query()->create([
         "room_number"   => $this->roomnumber,
         "room_type"   => $this->roomtype,
         "capacity"   => $this->roomcapacity,
         "price_pernight"   => $this->price,
         'bed_quantity'  => $this->bedquantity,
         'bath_quantity'  => $this->bathquantity,
         "description"   => $this->description,
         "status"   => 'available',
         "hotel_id"   => auth()->user()->company_id,
         "photo"  =>  $file
         ]);
        DB::commit();
        $this->getAlertSuccess();
        $this->reset(["bedquantity" ,"bathquantity" ,"description", "roomnumber", "roomtype", "roomcapacity", "price", "photo" , "file"]);
        } catch (\Throwable $exception) {
        DB::rollBack();
        $this->getAlertError($exception);
        }
    }
    public function rules () {
        return [
            "roomnumber"   => "required",
            "roomtype"   => "required",
            "roomcapacity"   => "required",
            "price"   => "required",
            "status"   => "required",
            "bedquantity"   => "required",
            "bathquantity"   => "required",
            "description"   => "required",
            "photo"   => "required",
        ];
    }

    public function messages () {
        return [
            "roomnumber.required"   => "Campo obrigatório",
            "roomtype.required"   => "Campo obrigatório",
            "roomcapacity.required"   => "Campo obrigatório",
            "price.required"   => "Campo obrigatório",
            "status.required"   => "Campo obrigatório",
            "bedquantity"   => "Campo obrigatório",
            "bathquantity"   => "Campo obrigatório",
            "description.required"   => "Campo obrigatório",
            "photo.required"   => "Campo obrigatório"
        ];
    }

  public function getAlertSuccess () {
    try {

        return  $this->alert('success', 'SUCESSO', options: [
         'toast'   => false,
         'position'   => 'center',
         'showConfirmButton'   => true,
         'confirmButtonText'   => 'OK',
         'timer'   => 300000,
         'allowOutsideClick'   => false,
         'text'  =>  "Operação realizada com sucesso!"
         ]);

    } catch (\Throwable $th) {
        $this->alert('error', 'ERRO', [
            'toast'   => false,
            'position'  => 'center',
            'showConfirmButton'  => true,
            'confirmButtonText'  => 'OK',
            'timer'   =>  300000,
            'allowOutsideClick'  => false,
            'text'  => 'Ocorreu o seguinte erro: '.$th->getMessage()
            ]);
        }
    }

    public function getAlertError ($exception) {
        try {

        return  $this->alert('error', 'ERRO', [
                'toast'   => false,
                'position'  => 'center',
                'showConfirmButton'  => true,
                'confirmButtonText'  => 'OK',
                'timer'   =>  300000,
                'allowOutsideClick'  => false,
                'text'  => 'Ocorreu o seguinte erro: '.$exception->getMessage()
            ]);

        }catch(\Throwable $th) {
        $this->alert('error', 'ERRO', [
                'toast'   => false,
                'position'  => 'center',
                'showConfirmButton'  => true,
                'confirmButtonText'  => 'OK',
                'timer'   =>  300000,
                'allowOutsideClick'  => false,
                'text'  => 'Ocorreu o seguinte erro: '.$th->getMessage()
            ]);
        }
    }

    public function edit ($roomId) {
        try {
            $this->roomId = $roomId;
           $this->status = true;
           $roomInfo = Room::query()->find($this->roomId);
           $this->roomnumber = $roomInfo->room_number;
           $this->roomtype = $roomInfo->room_type;
           $this->roomcapacity = $roomInfo->capacity;
           $this->status = $roomInfo->status;
           $this->bedquantity = $roomInfo->bed_quantity;
           $this->bathquantity = $roomInfo->bath_quantity;
           $this->price = $roomInfo->price_pernight;
           $this->roomstatus = $roomInfo->status;
           $this->description = $roomInfo->description;
        } catch (\Throwable $th) {
        $this->alert('error', 'ERRO', [
                'toast'   => false,
                'position'  => 'center',
                'showConfirmButton'  => true,
                'confirmButtonText'  => 'OK',
                'timer'   =>  300000,
                'allowOutsideClick'  => false,
                'text'  => 'Ocorreu o seguinte erro: '.$th->getMessage()
            ]);
        }
    }

    public function update (Room $room) {
        DB::BeginTransaction();
            try {
                $oldImage = $room->find($this->roomId);
                $file = '';
                if ($this->photo) {
                $fileName = md5($this->photo->getClientOriginalName()).'.'.$this->photo->getClientOriginalExtension();
                $file = $this->photo->storeAs("", $fileName);
                }
                $room->query()->find($this->roomId)->update([
                 "room_number"   => $this->roomnumber,
                 "room_type"   => $this->roomtype,
                 "status"   => $this->status,
                 "capacity"   => $this->roomcapacity,
                 "price_pernight"   => $this->price,
                 "bed_quantity"   => $this->bedquantity,
                 "bath_quantity"   => $this->bathquantity,
                 "description"   => $this->description,
                 "status" => $this->roomstatus,
                 "hotel_id"   => auth()->user()->company_id,
                 "photo"    => $file != '' ? $file : $oldImage->photo
                  ]);
                DB::commit();
                $this->alert('success', 'SUCESSO', options: [
                    'toast'   => false,
                    'position'   => 'center',
                    'showConfirmButton'   => true,
                    'confirmButtonText'   => 'OK',
                    'timer'   => 300000,
                    'allowOutsideClick'   => false,
                    'text'  =>  "Operação realizada com sucesso!"
                 ]);
                 $this->reset(["photo"]);
                 $this->emit("resetFileInput");

            } catch (\Throwable $th) {
            DB::rollBack();
            $this->alert('error', 'ERRO', [
                    'toast'   => false,
                    'position'  => 'center',
                    'showConfirmButton'  => true,
                    'confirmButtonText'  => 'OK',
                    'timer'   =>  300000,
                    'allowOutsideClick'  => false,
                    'text'  => 'Ocorreu o seguinte erro: '.$th->getMessage()
                ]);
            }
           }

        public function delete ($roomId) {
            try {
                $this->roomId = $roomId;
                $this->alert('warning', 'Confirmar', [
                    'icon'   =>  'warning',
                    'position'   =>  'center',
                    'toast'   =>  false,
                    'text'   =>  "Deseja realmente eliminar este registo?",
                    'showConfirmButton'   =>  true,
                    'showCancelButton'   =>  true,
                    'cancelButtonText'   =>  'Cancelar',
                    'confirmButtonText'   =>  'Confirmar',
                    'confirmButtonColor'   =>  '#3085d6',
                    'cancelButtonColor'   =>  '#d33',
                    'timer'   =>  '300000',
                    'onConfirmed'   =>  'roomConfirmDeletion'
                ]);
            } catch (\Throwable $th) {
                $this->alert('error', 'ERRO', [
                    'toast'   => false,
                    'position'  => 'center',
                    'showConfirmButton'  => true,
                    'confirmButtonText'  => 'OK',
                    'timer'   =>  300000,
                    'allowOutsideClick'  => false,
                    'text'  => 'Ocorreu o seguinte erro: '.$th->getMessage()
                ]);
            }
           }

           public function roomConfirmDeletion (Room $roomInfo) {
            try {
            fn ()  =>  DB::BeginTransaction();
            return $roomInfo::destroy([$this->roomId]);
            fn () =>  DB::commit();
            } catch (\Throwable $th) {
            fn () =>  DB::rollBack();
            $this->alert('error', 'ERRO', [
                    'toast'   => false,
                    'position'  => 'center',
                    'showConfirmButton'  => true,
                    'confirmButtonText'  => 'OK',
                    'timer'   =>  300000,
                    'allowOutsideClick'  => false,
                    'text'  => 'Ocorreu o seguinte erro: '.$th->getMessage()
                ]);
            }
           }

    public function closeModal () {
        try {
            $this->status = false;
            $this->reset(["bathquantity", "bedquantity", "roomnumber", "roomtype", "roomcapacity", "price", "photo" , "file"]);
        } catch (\Throwable $th) {
            $this->alert('error', 'ERRO', [
                'toast'   => false,
                'position'  => 'center',
                'showConfirmButton'  => true,
                'confirmButtonText'  => 'OK',
                'timer'   =>  300000,
                'allowOutsideClick'  => false,
                'text'  => 'Ocorreu o seguinte erro: '.$th->getMessage()
            ]);
        }
    }

}
