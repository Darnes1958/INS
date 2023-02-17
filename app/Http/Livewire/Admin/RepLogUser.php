<?php

namespace App\Http\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class RepLogUser extends Component
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

        return view('livewire.admin.rep-log-user',[

            'users'=>  DB::table('users')
                ->orderBy('last_seen','desc')
                ->paginate(8),

        ]);
    }
}
