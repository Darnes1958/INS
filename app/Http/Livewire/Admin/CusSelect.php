<?php

namespace App\Http\Livewire\Admin;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CusSelect extends Component
{
    public $CusNo;

    public $CusList;


    protected $listeners = [
        'TakeCusNo',
    ];

    public function TakeCusNo($cusno){

        $this->CusNo = $cusno;

    }

    public function hydrate(){
        $this->emit('cus-change-event');
    }
    public function render()
    {
        $this->CusList=DB::table('Customers')->get();
        return view('livewire.admin.cus-select',$this->CusList);
    }

}
