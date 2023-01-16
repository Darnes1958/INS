<?php

namespace App\Http\Livewire\Admin;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TajSelect extends Component
{

    public $TajNo;

    public $TajList;


    protected $listeners = [
        'TakeTajNo',
    ];

    public function TakeTajNo($tajno){

        $this->TajNo = $tajno;

    }

    public function hydrate(){
        $this->emit('taj-change-event');
    }
    public function render()
    {
        $this->TajList=DB::connection(Auth()->user()->company)->table('BankTajmeehy')->get();
        return view('livewire.admin.taj-select',$this->TajList);
    }
}
