<?php

namespace App\Http\Livewire\Site\Home;

use Livewire\Component;

class HomeComponent extends Component
{
 

    public function render()
    {
        return view('livewire.site.home.home-component')->layout('layouts.site.app');
    }
}
