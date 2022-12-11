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
    'TakeOrderNo',
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
      Config::set('database.connections.other.database', Auth::user()->company);
      $this->OrderList=DB::connection('other')->table('buys_view')
        ->where('order_date','>',Carbon::now()->subYear(1))
        ->orderBy('order_no', 'DESC')->get();

      return view('livewire.buy.buy-select',$this->OrderList);

    }
}
