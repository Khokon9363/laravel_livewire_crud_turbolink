<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Login extends Component
{
    public function mount()
    {
        return redirect('/');
    }
    public function render()
    {
        return view('livewire.login');
    }
}
