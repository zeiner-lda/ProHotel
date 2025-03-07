<?php

namespace App\Http\Livewire\GeneralAdmin;

use Livewire\Component;

class MyProfileComponent extends Component
{
    public function render()
    {
        return view('livewire.g_admin.my-profile-component')->layout('layouts.admin.app');
    }
}
