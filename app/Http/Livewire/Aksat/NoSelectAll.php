<?php

namespace App\Http\Livewire\Aksat;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class NoSelectAll extends Component
{
    public $Main_No;

    protected $listeners = [
        'SelectMainAllnofound',
    ];
    public function SelectMainAllnofound($res){

        $this->MainNo = $res['no'];


    }
    public function hydrate(){

        $this->emit('main-change-event');
    }
    public function render()
    {
        Config::set('database.connections.other.database', Auth::user()->company);
        $this->MainList=DB::connection('other')->table('main')
        ->select('no','name')
        ->orderBy('name', 'ASC')->get();
        return view('livewire.aksat.no-select-all');
    }
}
