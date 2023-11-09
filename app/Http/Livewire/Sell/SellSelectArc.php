<?php

namespace App\Http\Livewire\Sell;

use App\Models\Arc\Arc_Sells;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Carbon\Carbon;

class SellSelectArc extends Component
{
  public $OrderNo;

  public $OrderList;


  protected $listeners = [
    'TakeOrderNo','refreshComponent' => '$refresh'
  ];

  public function TakeOrderNo($wo){

    if(!is_null($wo)) {
      $this->OrderNo = $wo;


    }
  }

  public function hydrate(){
    $this->emit('sell-arc-change-event');
  }
    public function render()
    {

      $this->OrderList=Arc_Sells::
         join('Arc_Jeha','Arc_Sells.jeha','=','Arc_Jeha.jeha_no')
        ->selectRaw('jeha_name,order_no,order_date,tot')

        ->orderBy('order_no', 'DESC')->get();

      return view('livewire.sell.sell-select-arc',$this->OrderList);

    }
}
