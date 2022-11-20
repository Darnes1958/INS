<?php

namespace App\Http\Livewire\Sell;

use App\Models\stores\items;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class OrderSellDetail extends Component
{
    public $item;
    public $item_name;
    public $st_raseed;
    public $raseed;
    public $quant;
    public $price;
    public $orderdetail=[];
    public $st_label;
    public $price_buy;
    public $DetailOpen;
    public $OrderDetailOpen;

  public $OredrPlacetype='Makazen';
  public $OrderPlaceId=1;

  public $TheItemListIsSelectd;

  public function updatedTheItemListIsSelectd(){
    $this->TheItemListIsSelectd=0;
    $this->ItemKeyDown();
  }

  public function ChkQuant(){
    if ($this->quant>$this->st_raseed)
    {$this->dispatchBrowserEvent('mmsg', 'الرصيد لا يسمح !'); return(false);}
    if ($this->quant<=0) {return false;}
    $this->emit('gotonext','price');
  }


    protected $listeners = [
        'itemchange','edititem','YesIsFound','ClearData','mountdetail','dismountdetail','TakeNewItem'
    ];

    public function mountdetail($wpt,$wpn,$wpname){
        $this->OrderDetailOpen=true;
        $this->DetailOpen=true;
        $this->OredrPlacetype=$wpt;
        $this->OrderPlaceId=$wpn;
        $this->st_label='رصيد '.$wpname;

        $this->emit('B_RefreshSelectItem',$wpt,$wpn);


        $this->ClearData();

        $this->emit('gotonext', 'item_no');
    }
    public function dismountdetail(){
        $this->ClearData();
        $this->DetailOpen=False;

    }

    public function mount()
    {
        Config::set('database.connections.other.database', Auth::user()->company);
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
           if ($this->OredrPlacetype=='Makazen') {
               $result=items::with(array('iteminstore' => function ($query){
                   $query->where('st_no', $this->OrderPlaceId);
               }))->
               where('item_no', $this->item)->first();
           }

           if ($this->OredrPlacetype=='Salat') {
               $result=items::with(array('iteminhall' => function ($query){
                   $query->where('hall_no', $this->OrderPlaceId);
               }))->
               where('item_no', $this->item)->first();

           }

           if ($result) {
               $this->item_name=$result->item_name;
               $this->price=number_format($result->price_sell, 2, '.', '')  ;
             $pr=DB::connection('other')->table('item_price_sell')
               ->where('price_type', '=', 2)
               ->where('item_no','=',$this->item)
               ->pluck('price');

             if ($pr)  {$this->price=number_format($result->price_sell, 2, '.', '')  ;}
             else {$this->price=number_format((float)$pr[0], 2, '.', '')  ;}

             $this->raseed= $result->raseed;
               $this->price_buy=$result->price_buy;

               if ($this->OredrPlacetype=='Makazen') {
                   info($result->iteminstore->count());
                 info($result->iteminstore);

                   if ($result->iteminstore->count()!=0) {$this->st_raseed=$result->iteminstore[0]->raseed;}
                   else {$this->st_raseed = 0; }
                   if ($this->st_raseed==0) {return 'zero';}
                   return ('ok');
               }
               if ($this->OredrPlacetype=='Salat') {
                   if ($result->iteminhall->count()!=0) {$this->st_raseed=$result->iteminhall[0]->raseed;}
                   else {$this->st_raseed=0; }
                   if ($this->st_raseed==0) {return 'zero';}
                   return ('ok');
               }

           } { return('not');}
       } else { return('empty');}

   }
    public function ItemKeyDown(){
        $this->item_name='';
        $this->quant=0;
        $this->price=0;
        $res=$this->ChkItem();
        if ($res=='ok') {$this->emit('ChkIfDataExist',$this->item);
                         $this->emit('gotonext','quant');}
        if ($res=='not') { $this->dispatchBrowserEvent('mmsg', 'هذا الرقم غير مخزون ؟');}
        if ($res=='empty') { $this->dispatchBrowserEvent('mmsg', 'لا يجوز');}
        if ($res=='zero') { $this->dispatchBrowserEvent('mmsg', 'رصيد الصنف صفر');}
    }
    public function updatedItem()
    {
        $this->item_name='';
        $this->quant=0;
        $this->price=0;

    }

    protected function rules()
    {
        Config::set('database.connections.other.database', Auth::user()->company);
        return [
            'item' => ['required','integer','gt:0', 'exists:other.items,item_no'],
            'quant' =>   ['required','integer','gt:0'],
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
      if ($this->quant>$this->st_raseed)
         {$this->dispatchBrowserEvent('mmsg', 'الرصيد لا يسمح !'); return(false);}

        $subtot=number_format($this->price * $this->quant, 2, '.', '');
        $rebh=$subtot-number_format($this->price_buy * $this->quant, 2, '.', '');

        $this->orderdetail=['item_no'=>$this->item,'item_name'=>$this->item_name,
            'quant'=>$this->quant,'price'=>$this->price,'subtot'=>$this->price,'rebh'=>$rebh];
        $this->emit('putdata',$this->orderdetail);
        return (true);
    }



    public function render()
    {
        return view('livewire.sell.order-sell-detail');
    }
}

