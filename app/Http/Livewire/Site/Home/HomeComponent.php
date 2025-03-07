<?php

namespace App\Http\Livewire\Site\Home;
use \App\Models\{User};
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class HomeComponent extends Component
{

    public function mount(User $user) {
        try {
            $verifyIfAlreadyExistsGeneralAdmin = $user->query()->where('profile', 'g_admin')->first();
            if (!$verifyIfAlreadyExistsGeneralAdmin) {
                DB::beginTransaction();
                $user->create([
                    'username' => 'Geral Admin',
                    'email' => 'g_admin@gmail.com',
                    'password' => bcrypt("g_admin") ,
                    'company_id' => 0,
                    'profile' => 'g_admin'
                ]);
                DB::commit();
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }


    public function render()
    {
        return view('livewire.site.home.home-component')->layout('layouts.site.app');
    }

}
