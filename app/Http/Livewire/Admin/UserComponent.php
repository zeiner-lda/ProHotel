<?php

namespace App\Http\Livewire\Admin;
use App\Models\Company;
use App\Models\Guest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class UserComponent extends Component
{
    use LivewireAlert, WithPagination;
    public $userId, $user, $startdate,$enddate, $profile, $searcher, $status, $username, $email, $password,
    $guest,$firstname, $lastname, $telephone;
    protected $listeners = ['confirmUserDeletion' =>'confirmUserDeletion'];

    protected $rules = [
        'username' =>'required',
        'email' =>'required |email|unique:users',
        'password' =>  'required',
        'profile' =>'required',
        'firstname' =>'required',
        'lastname' =>'required',
        'telephone' =>'required',
        ];

    protected $messages = [
         'username.required' => 'Campo obrigatório',
         "email.required" => 'Campo obrigatório',
         "email.unique" => 'Email já cadastrado',
         "password.required" => 'Campo obrigatório',
         "profile.required" => 'Campo obrigatório',
         "firstname.required" => 'Campo obrigatório',
         "lastname.required" => 'Campo obrigatório',
         "telephone.required" => 'Campo obrigatório',
        ];

    public function render()
    {
        return view('livewire.admin.user-component',[
            'data' => $this->getUsers(),
        ])->layout('layouts.admin.app');
    }


     public function getUsers () {
            try{
                if ($this->searcher) {
                    return User::query()->where('username','like','%'.$this->searcher.'%')
                    ->where('profile','<>','g_admin')
                    ->where('profile', '<>', 'guest')
                    ->where('company_id', auth()->user()->company_id)
                    ->with('hotel')
                      
                    ->paginate(6);
                }else if ($this->startdate && $this->enddate){
                    return User::query()  ->where('profile','<>','g_admin')
                    ->where('profile', '<>', 'guest')
                    ->whereBetween('created_at',[$this->startdate, $this->enddate])
                    ->with('hotel')  
                    ->where('company_id', auth()->user()->company_id)                
                    ->paginate(6);
                }else{
                    return User::query()->where('profile','<>','g_admin')
                    ->with('hotel')     
                    ->where('profile', '<>', 'guest')
                    ->where('company_id', auth()->user()->company_id)
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

        public function save (User $user) {
            $this->validate();
            try {
            $this->user = $user;
            DB::BeginTransaction();
            $user->create([
                'username' =>$this->username,
                'email' =>$this->email,
                'password' =>bcrypt($this->password),
                'company_id' => auth()->user()->company_id,
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

        public function confirmUserDeletion (User $user) {
            try {
            DB::BeginTransaction();
            User::query()->find($this->userId)->delete();
            DB::commit();
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
            if ($oldUser->profile != "guest") {
                DB::BeginTransaction();
                User::find($this->userId)->update([
                'username' =>$this->username,
                'profile' => $this->profile,
                'password' => $this->password ? bcrypt($this->password) : $oldUser->password
                ]);    
                 
                 DB::commit();
            }else if ($oldUser->profile === "guest"){               
                $guest = Guest::query()->where('id',$oldUser->guest_id)->first();             
                if ($guest) {
                   DB::beginTransaction();
                   Guest::query()->where('id',$oldUser->guest_id)->update([
                    'firstname' =>  $this->firstname ,
                    'lastname' => $this->lastname ,
                    'phone' =>  $this->telephone 
                    ]);
                    DB::commit();
                }
            }

            if ($this->email != $oldUser->email) {
                User::find($this->userId)->update(['email' => $this->email]);
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

        public function  closeModal () {
            $this->status = false;
            $this->reset(['userId','firstname', 'lastname', 'telephone','userId', 'username' ,'email' ,'profile']);
            $this->resetValidation();
        }
}
