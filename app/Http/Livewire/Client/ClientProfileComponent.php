<?php

namespace App\Http\Livewire\Client;

use App\Models\Guest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ClientProfileComponent extends Component
{
    use LivewireAlert;
    public $userId, $client, $user, $firstname, $lastname, $address, $email, $password, $phone;
    protected $listeners = ['confirm' => 'confirm'];

    public function mount () {
        try {
            $this->firstname = auth()->user()->personaldata->firstname;
            $this->lastname = auth()->user()->personaldata->lastname;
            $this->address = auth()->user()->personaldata->address;
            $this->address = auth()->user()->personaldata->address;
            $this->phone = auth()->user()->personaldata->phone;
            $this->email = auth()->user()->email;

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

    public function render()
    {
        return view('livewire.client.client-profile-component')->layout("layouts.client-dashboard.app");
    }

    public function update () {
        try {
            $this->userId = auth()->user()->id;
            $this->alert('warning', 'Confirmar', [
                'icon' => 'warning',
                'position' => 'center',
                'toast' => false,
                'text' => "Confirmar atualização dos dados?",
                'showConfirmButton' => true,
                'showCancelButton' => true,
                'cancelButtonText' => 'Cancelar',
                'confirmButtonText' => 'Confirmar',
                'confirmButtonColor' => '#3085d6',
                'cancelButtonColor' => '#d33',
                'timer' => '300000',
                'onConfirmed' => 'confirm'
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

    public function confirm () {
        try {
            $user = User::find($this->userId);
            DB::BeginTransaction();
            $this->user = User::find($this->userId)->update([
             'email' => $this->email,
             'password' => $this->password ? bcrypt($this->password) : $user->password,
            ]);
            $this->client = Guest::query()->where('id', $user->guest_id)
            ->update([
                'firstname' => $this->firstname,
                'lastname'  =>  $this->lastname,
                'address' => $this->address,
                'phone' => $this->phone,
            ]);
            DB::commit();
            $this->alert('success', 'SUCESSO', [
                'toast'  => false,
                'position' => 'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'timer'  =>  300000,
                'allowOutsideClick' => false,
                'text'  =>  "Dados atualizados com sucesso!"
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
