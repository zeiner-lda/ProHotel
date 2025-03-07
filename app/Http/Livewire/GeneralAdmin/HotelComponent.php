<?php

namespace App\Http\Livewire\GeneralAdmin;
use \App\Models\{Company As Hotel};
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class HotelComponent extends Component
{
    use LivewireAlert , WithFileUploads, WithPagination;
    public $hotelId ,$startdate, $enddate, $photo, $data = [] ,$hotel, $province , $municipality, $searcher , $oldImage, $location , $email , $phone , $companylogo , $companyname , $file, $fileName, $status;
    protected $listeners = ["confirmHotelDeletion" => "confirmHotelDeletion"];

    protected $rules = [
      'companyname' =>'required',
      'location' =>'required',
      'email' =>'required',
       'phone' =>'required',
      'province' =>'required',
       'municipality' =>'required',
       'companylogo' =>'required|image',
     ];

       protected $messages =  [
            'companyname.required' => 'Campo obrigatório.',
            'location.required' => 'Campo obrigatório.',
            'email.required' => 'Campo obrigatório.',
            'phone.required' => 'Campo obrigatório.',
            'province.required' => 'Campo obrigatório.',
            'municipality.required' => 'Campo obrigatório.',
            'companylogo.required' => 'Campo obrigatório.'
        ];

    public function render()
    {
        return view('livewire.g_admin.hotel-component',[
            "companies" =>$this->getCompany()
        ])->layout('layouts.admin.app');
    }

    public function getCompany () {
        try {
        if ($this->searcher) {
            return Hotel::query()->where('companyname', 'like', '%'.$this->searcher.'%')
            ->orWhere('province' , 'like', '%'.$this->searcher.'%')
            ->orWhere('municipality' , 'like', '%'.$this->searcher.'%')
            ->paginate(6);

        }else if($this->startdate && $this->enddate){
            return Hotel::query()->whereBetween('created_at',[$this->startdate,$this->enddate])
            ->paginate(6);

        }else{
            return Hotel::query()->paginate(6);
        }


        }catch(\Throwable $th) {
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

    public function save (Hotel $hotel) {
       DB::beginTransaction();
        try {

            if ($this->photo) {
            $this->fileName = md5($this->photo->getClientOriginalName()).'.'.$this->photo->getClientOriginalExtension();
            $this->file = $this->photo->storeAs("", $this->fileName);
            }
            $hotel->query()->create([
                "companyname" =>$this->companyname,
                "email"=>$this->email ,
                "phone" =>$this->phone ,
                "province" =>$this->province,
                "municipality" =>$this->municipality,
                "country" =>'Angola',
                "company_cover_photo"=> $this->file,
            ]);
           DB::commit();
            $this->alert('success', 'SUCESSO', options: [
                'toast' =>false,
                'position' =>'center',
                'showConfirmButton' =>true,
                'confirmButtonText' =>'OK',
                'allowOutsideClick' => false,
                'text'=> "Registo salvo com sucesso!"
            ]);
            $this->reset(["photo", "companyname" , "province", "municipality" , "email" , "phone"]);
            $this->emit("resetFileInput");
        }catch (\Throwable $th) {
            DB::rollBack();
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

    public function editHotel ($hotelId, Hotel $hotel) {
        try {
         $this->hotelId = $hotelId;
         $this->status = true;
         $this->hotel = $hotel->query()->findorFail($this->hotelId);
         $this->companyname =  $this->hotel->companyname;
         $this->province =  $this->hotel->province;
         $this->municipality =  $this->hotel->municipality;
         $this->email =  $this->hotel->email;
         $this->phone =  $this->hotel->phone;

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

    public function update() {
        try {
        $this->oldImage = Hotel::query()->find($this->hotelId);
        if ($this->photo) {
        $this->fileName = md5($this->photo->getClientOriginalName()).'.'.$this->photo->getClientOriginalExtension();
        $this->file = $this->photo->storeAs($this->fileName);
        }

        DB::BeginTransaction();
        Hotel::find($this->hotelId)
         ->update([
            "companyname" =>$this->companyname,
            "email"=>$this->email ,
            "phone" =>$this->phone ,
            "province" =>$this->province,
            "municipality" =>$this->municipality,
            "country" =>'Angola',
            "company_cover_photo" => $this->file ? $this->file : $this->oldImage->company_cover_photo,
         ]);
         DB::commit();
         $this->alert('success', 'SUCESSO', options: [
            'toast' =>false,
            'position' =>'center',
            'showConfirmButton' =>true,
            'confirmButtonText' =>'OK',
            'timer' => 300000,
            'allowOutsideClick' => false,
            'text'=> "Registo atualizado com sucesso!"
        ]);
        $this->reset(["photo"]);
        $this->emit("resetFileInput");
        } catch (\Throwable $th) {
         DB::rollBack();
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

    public function closeModal () {
        try {
        $this->status = false;
        $this->reset(["hotelId","companyname" ,"email", "phone", "province", "municipality",]);

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

    public function deleteHotel ($hotelId) {
        try {
        $this->hotelId = $hotelId;
        $this->alert('warning', 'Confirmar', [
         'icon' => 'warning',
         'position' => 'center',
         'toast' => false,
         'html' => "<span>Deseja eliminar este registo?</span>",
         'showConfirmButton' => true,
         'showCancelButton' => true,
         'cancelButtonText' => 'Cancelar',
         'confirmButtonText' => 'Confirmar',
         'confirmButtonColor' => '#3085d6',
         'cancelButtonColor' => '#d33',
         'timer' => '300000',
         'onConfirmed' => 'confirmHotelDeletion'
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

    public function confirmHotelDeletion () {
        try {
        DB::BeginTransaction();
        Hotel::destroy($this->hotelId);
        DB::commit();
        } catch (\Throwable $th) {
        DB::rollBack();
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
