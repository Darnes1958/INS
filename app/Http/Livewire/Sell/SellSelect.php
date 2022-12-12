<?php

namespace App\Http\Livewire\Sell;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Carbon\Carbon;

class SellSelect extends Component
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
    $this->emit('sell-change-event');
  }
    public function render()
    {
      Config::set('database.connections.other.database', Auth::user()->company);
      $this->OrderList=DB::connection('other')->table('sells_view')
        ->where('order_date','>',Carbon::now()->subYear(1))
        ->orderBy('order_no', 'DESC')->get();

      return view('livewire.sell.sell-select',$this->OrderList);

    }
}
