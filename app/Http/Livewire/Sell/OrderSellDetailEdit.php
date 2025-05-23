<?php

namespace App\Http\Livewire\Sell;

use \App\Http\Livewire\Traits\MyLib;
use App\Models\LarSetting;
use App\Models\stores\items;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class OrderSellDetailEdit extends Component
{
    use MyLib;
    public $canChangePrice =true;
    public $MyConn;
    public $order_no;
    public $stno;
    public $item;
    public $item_name;
    public $st_raseed;
    public $raseed;
    public $quant;
    public $price;
    public $orderdetail=[];
    public $st_label;
    public $price_cost;
    public $DetailOpen;
    public $OrderDetailOpen;
    public $ItemGeted=false;

  public $OrderPlacetype='Makazen';
  public $OrderPlaceId=1;

  public $TheItemListIsSelectd;

  public function updatedTheItemListIsSelectd(){
    $this->TheItemListIsSelectd=0;
    $this->ChkItemAndGo();
  }

  public function ChkQuant(){
    if ($this->ItemExistsInOrder){
      if ($this->quant>$this->st_raseed+$this->OldItemQuant)
      {$this->dispatchBrowserEvent('mmsg', 'الرصيد لا يسمح !'); return(false);}
    }
    else {
      if ($this->quant>$this->st_raseed)
      {$this->dispatchBrowserEvent('mmsg', 'الرصيد لا يسمح !'); return(false);}
    }

    if ($this->quant<=0) {return false;}

      if ($this->canChangePrice)
          $this->emit('gotonext','price');
      else $this->ChkRec();


  }


    protected $listeners = [
        'itemchange','edititem','YesIsFound','ClearData','mountdetail','dismountdetail','TakeNewItem','TakeParam',
    ];
  public function TakeParam($order_no,$stno){
    $this->order_no=$order_no;
    $this->stno=$stno;
  }
    public function mountdetail($wpt,$wpn,$wpname){
        $this->OrderDetailOpen=true;
        $this->DetailOpen=true;
        $this->OrderPlacetype=$wpt;
        $this->OrderPlaceId=$wpn;
        $this->st_label='رصيد '.$wpname;

        $this->emit('B_RefreshSelectItem',$wpt,$wpn);


        $this->ClearData();

        $this->emit('gotonext', 'item_no');
    }
    public function dismountdetail(){
        $this->ClearData();
        $this->DetailOpen=False;
        $this->OrderDetailOpen=False;

    }

    public function mount()
    {
        $this->canChangePrice=LarSetting::query()->first()->canChangePrice;
        $this->ClearData();
        $this->DetailOpen=false;
        $this->OrderDetailOpen=true;

    }
    public function TakeNewItem(){
       $this->ClearData();
       $this->emit('gotonext','item_no');
      }
    public function ClearData () {
        $this->raseed=0;
        $this->st_raseed=0;
        $this->item=0;
        $this->item_name='';
        $this->quant=1;
        $this->price=number_format(0, 2, '.', '');
    }
    public function YesIsFound($q,$p){
        $this->quant=$q;
        $this->price=$p ;
      $this->emit('gotonext','quant');
    }
    public function edititem($value)
    {
        $this->item=$value['item_no'];
        $this->item_name=$value['item_name'];
        $this->quant=$value['quant'];
        $this->price=$value['price'] ;
        $this->emit('gotonext', 'item_no');
    }
    public function itemchange($value)
    {
        if(!is_null($value))
            $this->item = $value;
        $this->updatedItem();
        $this->emit('gotonext', 'item_no');
    }

   public function ChkItem(){
       Config::set('database.connections.other.database', Auth::user()->company);
       if ($this->item!=null) {
           $this->IfSellItemExists($this->order_no,$this->item,$this->OrderPlacetype,$this->stno);
           $result=$this->RetItemData($this->item);
           if ($result) {
             $this->item_name=$result->item_name;
             $this->raseed= $result->raseed;
             $this->price_cost=$result->price_cost;
             $this->price=$this->RetItemPrice($this->item,2);
             if ($this->price==0) $this->price=$result->price_sell;
             $this->price=number_format($this->price, 2, '.', '')  ;
             $this->st_raseed=$this->RetPlaceRaseed($this->item,$this->OrderPlacetype,$this->stno);

             return ('ok');
           } { return('not');}
       } else { return('empty');}

   }
    public function ChkItemAndGo(){
        $this->item_name='';
        $this->quant=0;
        $this->price=0;
        $res=$this->ChkItem();
        if ($res=='ok') {$this->emit('ChkIfDataExist',$this->item);
                         $this->ItemGeted=true;
                         $this->emit('gotonext','quant');}
        if ($res=='not') { $this->dispatchBrowserEvent('mmsg', 'هذا الرقم غير مخزون ؟');}
        if ($res=='empty') { $this->dispatchBrowserEvent('mmsg', 'لا يجوز');}

    }
    public function updatedItem()
    {   $this->ItemGeted=false;
        $this->item_name='';
        $this->quant=0;
        $this->price=0;
        $this->st_raseed=0;
    }

    protected function rules()
    {

        return [

            'quant' =>   ['required','numeric','gt:0'],
            'price' =>   ['required','numeric'  ,'gt:0'],
        ];
    }
    protected $messages = [
        'required' => 'لا يجوز ترك فراغ',
        'unique' => 'هذا الرقم مخزون مسبقا',
    ];

    public function ChkRec()
    {

        $this->validate();
        if ($this->ItemExistsInOrder){
          if ($this->quant>$this->st_raseed+$this->OldItemQuant)
          {$this->dispatchBrowserEvent('mmsg', 'الرصيد لا يسمح !'); return(false);}
        }
        else {
          if ($this->quant>$this->st_raseed)
          {$this->dispatchBrowserEvent('mmsg', 'الرصيد لا يسمح !'); return(false);}
        }

        $subtot=number_format($this->price * $this->quant, 2, '.', '');
        $rebh=$subtot-number_format($this->price_cost * $this->quant, 2, '.', '');

        $this->orderdetail=['item_no'=>$this->item,'item_name'=>$this->item_name,
            'quant'=>$this->quant,'price'=>$this->price,'subtot'=>$this->price,'rebh'=>$rebh];
        $this->emit('putdata',$this->orderdetail);

        return (true);
    }

    public function render()
    {
        $this->MyConn=auth()->user()->company;
        return view('livewire.sell.order-sell-detail-edit');
    }
}

