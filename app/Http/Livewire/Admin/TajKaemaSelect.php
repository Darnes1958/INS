<?php

namespace App\Http\Livewire\Admin;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TajKaemaSelect extends Component
{

    public $TajNoKaema;

    public $TajListKaema;


    protected $listeners = [
        'TakeTajNoKaema',
    ];

    public function TakeTajNokaema($tajno){

        $this->TajNoKaema = $tajno;

    }

    public function hydrate(){
        $this->emit('taj-kaema-change-event');
    }
    public function render()
    {
        $this->TajListKaema=DB::connection(Auth()->user()->company)->table('BankTajmeehy')->get();
        return view('livewire.admin.taj-kaema-select',$this->TajListKaema);
    }
}
