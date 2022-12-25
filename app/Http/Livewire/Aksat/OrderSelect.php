<?php

namespace App\Http\Livewire\Aksat;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Carbon\Carbon;

class OrderSelect extends Component
{
  public $OrderNo;
  public $JehaName;
  public $OrderList;
  public $MainTwo=false;


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
  public function mount($maintwo=false){
     $this->MainTwo=$maintwo;
  }
    public function render()
    {
      Config::set('database.connections.other.database', Auth::user()->company);
      if (!$this->MainTwo) {
      $this->OrderList=DB::connection('other')->table('sells_view')
      ->where('price_type',2)
      ->where('order_date','>',Carbon::now()->subMonth(1))

        ->whereNotIn('order_no', function($q){
          $q->select('order_no')->from('main');
        })
        ->whereNotIn('order_no', function($q){
          $q->select('order_no')->from('MainArc');
        })
        ->whereNotIn('order_no', function($q){
          $q->select('order_no')->from('MainRes');
        })
      ->get();}
        if ($this->MainTwo) {
            $this->OrderList=DB::connection('other')->table('sells_view')
                ->where('price_type',2)
                ->where('order_date','>',Carbon::now()->subYear(1))
                ->whereNotIn('order_no', function($q){
                    $q->select('order_no')->from('main');
                })
                ->whereNotIn('order_no', function($q){
                    $q->select('order_no')->from('MainArc');
                })
                ->whereNotIn('order_no', function($q){
                    $q->select('order_no')->from('MainRes');
                })
                ->whereIn('jeha', function($q){
                    $q->select('jeha')->from('main');
                })
                ->get();}

        return view('livewire.aksat.order-select',$this->OrderList);
    }
}
