<?php

namespace App\Http\Livewire\Aksat\Rep;

use App\Models\aksat\main;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class RepMainHead extends Component
{
 public $no;
 public $acc;

 public function ChkNoAndGo(){
    Config::set('database.connections.other.database', Auth::user()->company);
    $this->acc='';
    if ($this->no!=null) {
        $result = main::where('no',$this->no)->first();
        if ($result) {
            $this->acc=$result->acc;
            $this->emit('GotoDetail',$result);
            $this->emit('GotoTrans',$this->no);

        }
    }
 }
    public function render()
    {
        return view('livewire.aksat.rep.rep-main-head');
    }
}
