<?php

namespace App\Http\Livewire\Site\Home;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class NavbarComponent extends Component
{
    use LivewireAlert;
    public  $status = false;
    public function render()
    {
        return view('livewire.site.home.navbar-component');
    }

}
