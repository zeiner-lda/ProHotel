<?php

namespace App\Http\Livewire\Authentication;

use App\Models\{Guest, User};
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class AuthenticationComponent extends Component
{
    use LivewireAlert;
    public $email , $password , $credentials = [], $firstname ,$lastname, $birthday, $phone, $bi, $location;

    public function render()
    {
        return view('livewire.authentication.authentication-component')->layout('layouts.site.app');
    }

    public function rules() {
        return [
            "email" => "required",
            "password" => "required"
        ];
    }

    public function messages () {
        return [
            "email.required" => "Campo obrigatório",
            "password.required" => "Campo obrigatório",
        ];
    }

    public function authenticate ()   {
        $this->validate();
        try{
            $this->credentials = ["email" => $this->email , "password" => $this->password];
            if (auth()->attempt($this->credentials)) {

            if (auth()->user()->profile == 'g_admin'){
            return redirect()->route('g_admin.home');
            }else if (auth()->user()->profile == 'admin') {
             return redirect()->route('admin.home');
            }else if (auth()->user()->profile == 'stockroom_manager'){
                return redirect()->route('stock.management.index');
            }else if(auth()->user()->profile == 'kitchen_manager'){
              return redirect()->route('kitchen.index');
            } else if (auth()->user()->profile == 'reception'){
                 return redirect()->route('dashboard.reception.index');
            }else if (auth()->user()->profile == 'guest') {
                return redirect()->to('/');
            }
            }else{
            $this->alert('warning', 'Falhou', [
                'toast' =>false,
                'position' =>'center',
                'showConfirmButton' =>true,
                'confirmButtonText' =>'OK',
                'timer' => 300000,
                'allowOutsideClick' => true,
                'text'=> "Credenciais inválidas, tente novamente!"
            ]);
            }


        }catch(\Throwable $th){
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

    public function createAccountByClient () {

        try {
           DB::beginTransaction();
              $guest = Guest::create([
                "firstname" =>$this->firstname,
                "lastname" =>$this->lastname,
                "birthday" =>$this->birthday,
                "phone" =>$this->phone,
                "binumber" =>$this->bi,
                "address" =>$this->location
              ]);

              User::create([
                'email' =>$this->email,
                'password' =>$this->password,
                'profile' =>'client',
                'client_id' =>$guest->id
              ]);
              DB::commit();
              return redirect()->to('/login')->with('success', "A sua conta foi criada com sucesso, faça o login!");


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
