<?php

namespace App\Http\Livewire\Stores;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;
use \App\Http\Livewire\Traits\MyLib;

class StoreDetail extends Component
{
  use MyLib;
  public $StoreDetailOpen=false;
  public $DetailOpen=false;
  public $ItemGeted=false;
  public $Table1;
  public $Table2;
  public $place_no1;
  public $place_no2;
  public $place1_label;
  public $place2_label;
  public $item;
  public $item_name;
  public $quant;
  public $price;
  public $raseed;
  public $place1_raseed;
  public $place2_raseed;
  public $TheItemListIsSelectd;
  public $perdetail=[];

  protected $listeners =['TakeParams'];

  public function TakeParams($place_no1,$place_no2,$table1,$table2,$name1,$name2){
    $this->place1_label='رصيد '.$name1;
    $this->place2_label='رصيد '.$name2;
    $this->Table1=$table1;
    $this->Table2=$table2;
    $this->place_no1=$place_no1;
    $this->place_no2=$place_no2;
    $this->StoreDetailOpen=true;

  }
  public function updatedTheItemListIsSelectd(){
    $this->TheItemListIsSelectd=0;
    $this->ChkItemAndGo();
  }
  public function updatedItem(){
    $this->ItemGeted=false;
  }
  public function ChkItem(){
    Config::set('database.connections.other.database', Auth::user()->company);
    if ($this->item!=null) {
      $result=$this->RetItemData($this->item);
      if ($result) {
        $this->item_name=$result->item_name;
        $this->raseed= $result->raseed;
        $this->price=$result->price_sell;
        $this->price=number_format($this->price, 2, '.', '')  ;
        $this->place1_raseed=$this->RetPlaceRaseed($this->item,$this->Table1,$this->place_no1);
        $this->place2_raseed=$this->RetPlaceRaseed($this->item,$this->Table2,$this->place_no2);
        if ($this->place1_raseed==0) {return 'zero';}
        return ('ok');
      } { return('not');}
    } else { return('empty');}

  }
  public function ChkItemAndGo(){
    $this->quant=0;
    $this->price=0;
    $res=$this->ChkItem();
    if ($res=='ok') {
      $this->ItemGeted=true;
      $this->emitTo('stores.item-select','TakeItemNo',$this->item);
      $this->emit('gotonext','quant');}
    if ($res=='not') { $this->dispatchBrowserEvent('mmsg', 'هذا الرقم غير مخزون ؟');}
    if ($res=='empty') { $this->dispatchBrowserEvent('mmsg', 'لا يجوز');}
    if ($res=='zero') { $this->dispatchBrowserEvent('mmsg', 'رصيد الصنف صفر');}
  }
  public function ClearDetail(){
    $this->item='';
    $this->quant='';
    $this->price='';
    $this->place1_raseed='';
    $this->place2_raseed='';
    $this->raseed='';
  }
  public function ChkQuant(){
    if ($this->quant>$this->place1_raseed)
      {$this->dispatchBrowserEvent('mmsg', 'الرصيد لا يسمح !'); return(false);}
    if ($this->quant<=0) {return false;}
    $this->perdetail=['item_no'=>$this->item,'item_name'=>$this->item_name,
      'quant'=>$this->quant];
    $this->emitTo('stores.store-table','putdata',$this->perdetail);
    $this->ClearDetail();
    $this->emit('gotonext','item');
  }

  public function render()
   {
     return view('livewire.stores.store-detail');
   }
}
