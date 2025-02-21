<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class AdminComponent extends Component
{
    public function render()
    {
        return view('livewire.admin.admin-component')->layout('layouts.admin.app');
    }
}
