<?php

namespace App\Http\Livewire\GeneralAdmin;

use App\Models\{Guest, User, Company As Hotel};
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class AdminUserComponent extends Component
{
    use WithPagination, LivewireAlert ;
    public $user,$users,$password,$hotelname,$hotels,$profile,$status,$username,$firstname,$lastname ,$telephone,$searcher, $startdate,$endate, $userId, $email;
    protected $rules = [
        'username' =>'required',
        'email' =>'required |email|unique:users',
        'password' =>  'required',
        'profile' =>'required',     
        'hotelname' => 'required'   
        ];

    protected $messages = [
         'username.required' => 'Campo obrigatório',
         "email.required" => 'Campo obrigatório',
         "email.unique" => 'Email já cadastrado',
         "password.required" => 'Campo obrigatório',
         "profile.required" => 'Campo obrigatório',  
         "hotelname.required" => 'Campo obrigatório',       
     ];

    public function mount () {
        try {           
            $this->users = new User();
            $this->hotels = new Hotel();
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
        return view('livewire.g_admin.admin-user-component',[
            'data' =>$this->getAdminUsersOfProHotel($this->users),
            'allHotels' => $this->getHotelsInProHotel($this->hotels)
        ])->layout('layouts.admin.app');
    }

    public function save (User $user) {
        $this->validate();
        try {
        $this->user = $user;
        DB::BeginTransaction();
        $user->create([
            'username' =>$this->username,
            'email' =>$this->email,
            'password' =>bcrypt($this->password),
            'company_id' => $this->hotelname,
            'profile' =>$this->profile
        ]);
        DB::commit();
        $this->alert('success', 'SUCESSO', [
            'toast' =>false,
            'position'=>'center',
            'showConfirmButton'=>true,
            'confirmButtonText'=>'OK',
            'timer' => 300000,
            'allowOutsideClick'=>false,
            'text'=>'Usuário cadastrado com sucesso!'
        ]);
        $this->reset([
        'username',
        'email',
        'password',
        'profile'
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

    public function getHotelsInProHotel(Hotel $availableHotels) {
        try{
            return $availableHotels->get();
        }catch(\Exception $ex){
            $this->alert('error', 'ERRO', [
                'toast' =>false,
                'position'=>'center',
                'showConfirmButton'=>true,
                'confirmButtonText'=>'OK',
                'timer' => 300000,
                'allowOutsideClick'=>false,
                'text'=>'Ocorreu o seguinte erro: '.$ex->getMessage()
                ]);
        }
    }

    public function getAdminUsersOfProHotel (User $adminUsers) {
        try{
            if ($this->searcher) {
                return $adminUsers->query()->where('username','like','%'.$this->searcher.'%')
                ->orWhere('email', $this->searcher)
                ->where('profile','admin')
                ->with('hotel')                  
                ->paginate(6);
            }else if ($this->startdate && $this->enddate){
            return $adminUsers->query()->where('profile','admin')
                ->whereBetween('created_at',[$this->startdate, $this->enddate])
                ->with('hotel')                               
                ->paginate(6);
            }else{
                return $adminUsers->query()->where('profile','admin')
                ->with('hotel')  
                ->paginate(6);
            }
        }catch(\Exception $ex){
            $this->alert('error', 'ERRO', [
                'toast' =>false,
                'position'=>'center',
                'showConfirmButton'=>true,
                'confirmButtonText'=>'OK',
                'timer' => 300000,
                'allowOutsideClick'=>false,
                'text'=>'Ocorreu o seguinte erro: '.$ex->getMessage()
                ]);
        }
    }


    public function edit($userId, Guest $guest) {
        try {
           $this->status = true;
           $this->userId = $userId;
           $user = User::where('id',$this->userId)->with("personaldata")->first();
           !is_null($user->username) ? $this->username = $user->username : '';
           !is_null($user->email) ? $this->email = $user->email : '';
           !is_null($user->profile) ? $this->profile = $user->profile : '';
           !is_null($user->guest_id) ? $this->firstname = $user->personaldata->firstname : '';
           !is_null($user->guest_id) ? $this->lastname = $user->personaldata->lastname : '';
           !is_null($user->guest_id) ? $this->telephone = $user->personaldata->phone : '';

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

    public function update () {         
   
        try {
        $oldUser = User::find($this->userId);
        if ($oldUser) {
            DB::BeginTransaction();
            User::find($this->userId)->update([
            'username' =>$this->username,
            'profile' => $this->profile,
            'password' => $this->password ? bcrypt($this->password) : $oldUser->password
            ]);    
             
        DB::commit();      
        if ($this->email != $oldUser->email) {
            User::find($this->userId)->update(['email' => $this->email]);
        }
        }
         
        $this->alert('success', 'SUCESSO', [
            'toast' =>false,
            'position'=>'center',
            'showConfirmButton'=>true,
            'confirmButtonText'=>'OK',
            'timer' => 300000,
            'allowOutsideClick'=>false,
            'text'=>'Usuário atualizado com sucesso!'
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

    public function delete ($userId) {
        try {
            $this->userId = $userId;
            $this->alert('warning', 'Confirmar', [
                'icon' => 'warning',
                'position' => 'center',
                'toast' => false,
                'text' => "Deseja eliminar este usuário?",
                'showConfirmButton' => true,
                'showCancelButton' => true,
                'cancelButtonText' => 'Cancelar',
                'confirmButtonText' => 'Confirmar',
                'confirmButtonColor' => '#3085d6',
                'cancelButtonColor' => '#d33',
                'timer' => '300000',
                'onConfirmed' => 'confirmUserDeletion'
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


    public function  closeModal () {
        $this->status = false;
        $this->reset(['userId','firstname', 'lastname', 'telephone','userId', 'username' ,'email' ,'profile']);
        $this->resetValidation();
    }
}
