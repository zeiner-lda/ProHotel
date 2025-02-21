<?php

namespace App\Http\Livewire\Kitchen;

use Livewire\Component;

class KitchenComponent extends Component
{
    public function render()
    {
        return view('livewire.kitchen.kitchen-component')->layout('layouts.admin.app');
    }
}
