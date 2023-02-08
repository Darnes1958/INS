<?php

namespace App\Http\Livewire\Admin;


use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class RepUsers extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $Show=false;

    protected $listeners = ['show'];

    public function show($show){

        $this->Show=$show;
    }

    public function render()
    {

        return view('livewire.admin.rep-users',[
            'Tabledata'=>User::all()
        ]);
    }
}

