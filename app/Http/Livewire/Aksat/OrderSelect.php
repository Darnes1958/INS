<?php

namespace App\Http\Livewire\Aksat;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class OrderSelect extends Component
{
  public $OrderNo;
  public $JehaName;
  public $OrderList;


  protected $listeners = [
    'TakeOrderNo','refreshComponent' => '$refresh'
  ];

  public function TakeOrderNo($wj,$wn){

    if(!is_null($wj)) {
      $this->OrderNo = $wj;
      $this->JehaName = $wn;

    }
  }

  public function hydrate(){
    $this->emit('order-change-event');
  }

    public function render()
    {
      Config::set('database.connections.other.database', Auth::user()->company);
      $this->OrderList=DB::connection('other')->table('sells_view')
      ->where('price_type',2)

        ->whereNotIn('order_no', function($q){
          $q->select('order_no')->from('main');
        })
        ->whereNotIn('order_no', function($q){
          $q->select('order_no')->from('MainArc');
        })
        ->whereNotIn('order_no', function($q){
          $q->select('order_no')->from('MainRes');
        })
      ->get();
        return view('livewire.aksat.order-select',$this->OrderList);
    }
}
