<?php

namespace App\Http\Livewire\Admin;


use App\Models\sell\price_type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EmpnoSelect extends Component
{
    public $Comp='Daibany';
    protected $listeners = ['comp'];

    public function comp($comp){
        $this->Comp=$comp;
    }
    public function hydrate(){
        $this->emit('empno-change-event');
    }
    public function render()
    {
        Config::set('database.connections.other.database',$this->Comp );
        $this->ItemList=DB::connection('other')->table('pass')->get();

        return view('livewire.admin.empno-select',$this->ItemList);

    }

}
