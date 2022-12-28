<?php

namespace App\Http\Livewire\Buy;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Carbon\Carbon;

class BuySelect extends Component
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
    $this->emit('buy-change-event');
  }
    public function render()
    {
      $this->OrderList=DB::connection(Auth()->user()->company)->table('buys_view')
        ->where('order_date','>',Carbon::now()->subYear(1))
        ->orderBy('order_no', 'DESC')->get();

      return view('livewire.buy.buy-select',$this->OrderList);

    }
}
