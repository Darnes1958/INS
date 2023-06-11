<?php

namespace App\Http\Livewire\Admin;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TajMahjozaSelect extends Component
{

    public $TajNoMahjoza;

    public $TajListMahjoza;


    protected $listeners = [
        'TakeTajNoMahjoza',
    ];

    public function TakeTajNoMahjoza($tajno){

        $this->TajNoMahjoza = $tajno;

    }

    public function hydrate(){
        $this->emit('taj-mahjoza-change-event');
    }
    public function render()
    {
        $this->TajListMahjoza=DB::connection(Auth()->user()->company)->table('BankTajmeehy')->get();
        return view('livewire.admin.taj-mahjoza-select',$this->TajListMahjoza);
    }
}
