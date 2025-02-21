<?php

namespace App\Http\Livewire\Client;

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
}
