<?php

namespace App\Http\Livewire\Jeha;

use App\Models\jeha\jeha;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CustSelect extends Component
{
  public $CustNo;
  public $CustName;
  public $CustList;

  protected $listeners = [
    'jehafound'
  ];

  public function jehafound($wj,$wn){

    if(!is_null($wj)) {
      $this->CustNo = $wj;
      $this->CustName = $wn;
    }
  }


  public function hydrate(){

    $this->emit('data-change-event');
  }
  public function render()
  {
    $this->CustList = DB::connection(Auth()->user()->company)->table('jeha')
      ->select('jeha_no','jeha_name')->where('jeha_type',1)->where('available',1)->get();


    return view('livewire.jeha.cust-select',$this->CustList);
  }
}
