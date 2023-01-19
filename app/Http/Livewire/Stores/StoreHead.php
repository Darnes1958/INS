<?php

namespace App\Http\Livewire\Stores;


use App\Models\stores\halls_names;
use App\Models\stores\store_exp;
use App\Models\stores\stores_names;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;
use Symfony\Component\Console\Helper\Table;

class StoreHead extends Component
{
  public $FromTo;
  public $From;
  public $To;
  public $Table1;
  public $Table2;
  public $place_no1;
  public $place_no2;
  public $place_name1;
  public $place_name2;

  public $themax;

  public $Place1Geted=false;
  public $Place2Geted=false;
  public $PlaceGeted=false;
  public $HeadOpen=true;


  public $ThePlace1ListIsSelected;
  public $ThePlace2ListIsSelected;

  public $listeners=['mounthead'];

  public function mounthead(){
    $this->Place1Geted=false;
    $this->Place2Geted=false;
    $this->PlaceGeted=false;
    $this->HeadOpen=true;
    $this->place_no1='';
    $this->place_no2='';
    $this->emit('goto','place_no1');
  }

  public function updatedThePlace1ListIsSelected(){
    $this->ThePlace1ListIsSelected=0;
    $this->ChkPlace1AndGo();
  }
  public function updatedThePlace2ListIsSelected(){
    $this->ThePlace2ListIsSelected=0;
    $this->ChkPlace2AndGo();
  }

  public function ChkPlace1AndGo(){


    if ($this->place_no1!=null) {
      if ($this->FromTo==11 || $this->FromTo==12)
       $result =stores_names::on(Auth()->user()->company)->where('st_no',$this->place_no1)->first();
      if ($this->FromTo==21 || $this->FromTo==22)
        $result =halls_names::on(Auth()->user()->company)->where('hall_no',$this->place_no1)->first();
      if ($result) {
        $this->Place1Geted=true;
        if ($this->FromTo==11 || $this->FromTo==12)
          $this->place_name1=$result->st_name;
        if ($this->FromTo==21 || $this->FromTo==22)
          $this->place_name1=$result->hall_name;

        $this->emit('goto','place_no2');
        $this->emitTo('stores.store-select1','TakePlaceNo1',$this->place_no1);
       } else $this->dispatchBrowserEvent('mmsg','هذا الرقم غير مخزون');
    }
  }
  public function ChkPlace2AndGo(){


    if ($this->place_no2!=null) {
      if ($this->FromTo==11 || $this->FromTo==21)
        $result =stores_names::on(Auth()->user()->company)->where('st_no',$this->place_no2)->first();
      if ($this->FromTo==12 || $this->FromTo==22)
        $result =halls_names::on(Auth()->user()->company)->where('hall_no',$this->place_no2)->first();
      if ($result) {
        if (($this->FromTo==11 || $this->FromTo==22) && $this->place_no1==$this->place_no2)
        {$this->dispatchBrowserEvent('mmsg','لا يجوز النقل لنفس المكان');return(false);}
        $this->Place2Geted=true;
        if ($this->FromTo==11 || $this->FromTo==21)
          $this->place_name2=$result->st_name;
        if ($this->FromTo==12 || $this->FromTo==22)
          $this->place_name2=$result->hall_name;
        $this->emitTo('stores.store-select2','TakePlaceNo2',$this->place_no2);
        if ($this->Place2Geted) {
          $this->PlaceGeted=true;
          $this->emit('goto', 'head-btn');
        }

      } else $this->dispatchBrowserEvent('mmsg','هذا الرقم غير مخزون');
    }
  }
  public function BtnHeader(){
    $this->HeadOpen=False;
    $this->emitTo('stores.store-detail','TakeParams',$this->place_no1,$this->place_no2,$this->Table1,$this->Table2,$this->place_name1,$this->place_name2);
    $this->emitTo('stores.store-table','TakeParams',$this->place_no1,$this->place_no2,$this->FromTo,$this->Table1);
  }

  public function render()
    {
      $this->themax=store_exp::on(Auth()->user()->company)->max('per_no')+1;
      if ($this->FromTo==11) {
        $this->From='من مخزن';
        $this->To='إلي مخزن';
        $this->Table1='Makazen';
        $this->Table2='Makazen';
      }
      if ($this->FromTo==12) {
        $this->From='من مخزن';
        $this->To='إلي صالة';
        $this->Table1='Makazen';
        $this->Table2='Salat';
      }
      if ($this->FromTo==21) {
        $this->From='من صالة';
        $this->To='إلي مخزن';
        $this->Table1='Salat';
        $this->Table2='Makazen';
      }
      if ($this->FromTo==22) {
        $this->From='من صالة';
        $this->To='إلي صالة';
        $this->Table1='Salat';
        $this->Table2='Salat';
      }

        return view('livewire.stores.store-head');
    }
}
