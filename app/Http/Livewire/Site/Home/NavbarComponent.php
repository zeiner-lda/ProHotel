<?php

namespace App\Http\Livewire\Site\Home;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class NavbarComponent extends Component
{
    use LivewireAlert;
    public  $status = false;
    protected $listeners = ["confirmLogout" => "confirmLogout"];

    public function render()
    {
        return view('livewire.site.home.navbar-component');
    }

    public function logout () {
        try {
            $this->alert('warning', 'Confirmar', [
                'icon' => 'warning',
                'position' => 'center',
                'toast' => false,
                'text' => "Deseja terminar sessão?",
                'showConfirmButton' => true,
                'showCancelButton' => true,
                'cancelButtonText' => 'Cancelar',
                'confirmButtonText' => 'Confirmar',
                'confirmButtonColor' => '#3085d6',
                'cancelButtonColor' => '#d33',
                'timer' => '300000',
                'onConfirmed' => 'confirmLogout'
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

    public function confirmLogout () {
        try {
            auth()->logout();
            return redirect()->to('/');
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


}
