<?php

namespace App\Http\Livewire\Client;
use App\Models\{Guest As Client, User};
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CreateAccountClientComponent extends Component
{
    use LivewireAlert;
    public $client,$inputValuesForUserCredentials, $inputValuesForPersonalDataOfClient = [] , $firstname , $lastname , $birthday, $bi, $email, $password, $phone, $location, $passwordconfirmation;
    protected $rules =  ["firstname" => "required", "lastname" => "required" , "birthday" => "required", "email" => "required", "bi" => "required", "password" => "required", "phone" => "required", "location" => "required", "passwordconfirmation" => "required |same:password"];
    protected $messages = ["firstname.required" => "Campo obrigatório*", "lastname.required" => "Campo obrigatório*" , "birthday.required" => "Campo obrigatório*", "email.required" => "Campo obrigatório*", "bi.required" => "Campo obrigatório*", "password.required" => "Campo obrigatório*", "phone.required" => "Campo obrigatório*", "location.required" => "Campo obrigatório*", "passwordconfirmation.required" => "Campo obrigatório*", "passwordconfirmation.same" =>"Os campos senha e confirmar senha devem corresponder"];


    public function render()
    {
        return view('livewire.client.create-account-client-component')->layout('layouts.site.app');
    }

    public function storeAccount (User $user, Client $client) {
        $this->validate();
        try {

          $this->inputValuesForPersonalDataOfClient = ["firstname" =>$this->firstname , "lastname" =>$this->lastname , "birthday" =>$this->birthday, "binumber" =>$this->bi,  "phone" =>$this->phone, "address" =>$this->location];
          DB::BeginTransaction();
          $this->client = $client->create($this->inputValuesForPersonalDataOfClient);
          $user->create(["profile" =>"guest", "guest_id" =>$this->client->id,"email" =>$this-> email, "password" =>bcrypt($this->password)]);
          DB::commit();
          return redirect()->route("login")->with(["success" => "A sua conta foi criada com sucesso , faça o login!"],201);
        } catch (\Exception $ex) {
         DB::rollBack();
        $this->alert('error', 'ERRO', [
                'toast'  => false,
                'position' => 'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'timer'  =>  300000,
                'allowOutsideClick' => false,
                'text' => $ex->GetMessage(),
            ]);
        }
    }
}
