<?php

namespace App\Http\Livewire\Admin;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class UserComponent extends Component
{
    use LivewireAlert, WithPagination;
    public $userId, $user, $startdate,$enddate, $profile, $searcher, $status, $username, $email, $password;
    protected $listeners = ['confirmUserDeletion' =>'confirmUserDeletion'];

    protected $rules = [
        'username' =>'required',
        'email' =>'required |email|unique:users',
        'password' =>'required',
        'profile' =>'required'
        ];

    protected $messages = [
         'username.required' => 'Campo obrigatório',
         "email.required" => 'Campo obrigatório',
         "email.unique" => 'Email já cadastrado',
         "password.required" => 'Campo obrigatório',
         "profile.required" => 'Campo obrigatório',

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
                    ->where('profile','<>','guest')
                    ->with('hotel')
                    ->paginate(6);
                }else if ($this->startdate && $this->enddate){
                    return User::query()->where('profile','<>','guest')
                    ->whereBetween('created_at',[$this->startdate, $this->enddate])
                    ->with('hotel')
                    ->paginate(6);
                }else{
                    return User::query()
                    ->where('profile','<>','guest')
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
           fn () =>  DB::commit();
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
            User::query()->findorFail($this->userId)->delete();
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

        public function edit($userId) {
            try {
               $this->status = true;
               $this->userId = $userId;
               $user = User::findorFail($this->userId);
               $this->username = $user->username;
               $this->email = $user->email;
               $this->profile = $user->profile;


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
            $user = User::find($this->userId);
            DB::BeginTransaction();
            User::find($this->userId)->update([
            'username' =>$this->username,
            'email' =>$this->email,
            'profile' =>$this->profile,
            'password' => $this->password ? bcrypt($this->password) : $user->passord
            ]);
            DB::commit();
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
            $this->reset(['userId', 'username' ,'email' ,'profile']);
        }
}
