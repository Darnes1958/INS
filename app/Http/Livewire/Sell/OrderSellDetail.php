<?php

namespace App\Http\Livewire\Sell;

use App\Models\sell\price_type;
use App\Models\stores\items;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use \App\Http\Livewire\Traits\MyLib;

class OrderSellDetail extends Component
{
    use MyLib;
    public $item;
    public $item_name;
    public $st_raseed;
    public $raseed;
    public $Quant;
    public $price;
    public $price_Type;
    public $orderdetail=[];
    public $st_label;
    public $price_buy;
    public $DetailOpen;
    public $OrderDetailOpen;

  public $OrderPlacetype='Makazen';
  public $OrderPlaceId=1;

  public $ShowBring=false;

  public $TheItemListIsSelectd;

    public $search, $isEmpty = '',$ShowSearch=false;

  public function OpenBringModal(){
    $this->emitTo('sell.bring-item','TakeParam',$this->OrderPlacetype,$this->OrderPlaceId,$this->item);
    $this->dispatchBrowserEvent('OpenBringModal');
  }
  public function CloseBringModal(){
    $this->dispatchBrowserEvent('CloseBringModal');
    $this->ShowBring=false;
      $this->ItemKeyDown();
  }
  public function updatedTheItemListIsSelectd(){
    $this->TheItemListIsSelectd=0;
    $this->ItemKeyDown();
  }

  public function ChkQuant(){
    if ($this->Quant>$this->st_raseed)
    {$this->dispatchBrowserEvent('mmsg', 'الرصيد لا يسمح !'); return(false);}
    if ($this->Quant<=0) {return false;}
    $this->emit('gotonext','price');
  }
   protected $listeners = [
        'itemchange','edititem','YesIsFound','ClearData','mountdetail','dismountdetail','TakeNewItem','CloseBringModal',
      'TakeTheItemNo',
    ];
    public function TakeTheItemNo($item){
      $this->item=$item;
      $this->ItemKeyDown();
     }
    public function mountdetail($wpt,$wpn,$wpname,$price_type){
        $this->OrderDetailOpen=true;
        $this->DetailOpen=true;
        $this->OrderPlacetype=$wpt;
        $this->OrderPlaceId=$wpn;
        $this->price_Type=$price_type;
        $this->st_label='رصيد '.$wpname;
        $this->emit('B_RefreshSelectItem',$wpt,$wpn);
        $this->ClearData();
        $this->emitTo('stores.search-item','take_goto', 'search_box');
    }
    public function dismountdetail(){
        $this->ClearData();
        $this->DetailOpen=False;
    }

    public function mount()
    {
        $this->ClearData();
        $this->DetailOpen=false;
        $this->OrderDetailOpen=true;
    }
    public function TakeNewItem(){
       $this->ClearData();
       $this->emit('gotonext','search');
      }
    public function ClearData () {
        $this->raseed=0;
        $this->st_raseed=0;
        $this->item=0;
        $this->item_name='';
        $this->Quant=1;
        $this->price=number_format(0, 2, '.', '');
        $this->ShowBring=false;
    }
    public function YesIsFound($q,$p){
        $this->Quant=$q;
        $this->price=$p ;
      $this->emit('gotonext','Quant');
    }
    public function edititem($value)
    {
        $this->item=$value['item_no'];
        $this->item_name=$value['item_name'];
        $this->Quant=$value['quant'];
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

   public function ChkItem()
   {

     if ($this->item != null) {

       $result = $this->RetItemData($this->item);
       if ($result) {
         $this->item_name = $result->item_name;
         $this->raseed = $result->raseed;
         $this->price_buy = $result->price_buy;
         $this->price = $this->RetItemPrice($this->item, $this->price_Type);
         if ($this->price == 0) {
           $this->price = $result->price_sell;
         }
         $this->price = number_format($this->price, 2, '.', '');
         $this->st_raseed = $this->RetPlaceRaseed($this->item, $this->OrderPlacetype, $this->OrderPlaceId);
         if ($this->st_raseed <= 0) {
           return 'zero';
         }
         return ('ok');
       }
       {
         return ('not');
       }
     } else {
       return ('empty');
      }
   }

    public function fetchEmployeeDetail($key){
        $this->search='';
        $this->item=$key;
        $this->emit('gotonext', 'itemno');
        $this->ItemKeyDown();
    }
    public function SearchEnter(){
        if ($this->search && is_numeric($this->search)  ){

            if (items::on(Auth::user()->company)->where('item_no',$this->search)->exists()){
                $this->item=$this->search;
                $this->search='';
                $this->ShowSearch=false;
                $this->emit('gotonext', 'itemno');
                $this->ItemKeyDown();

            } else $this->ShowSearch=true;
        }
    }
    public function ItemKeyDown(){
        $this->item_name='';
        $this->Quant=1;
        $this->price=0;
        $res=$this->ChkItem();
        if ($res=='ok') {$this->emit('ChkIfDataExist',$this->item);
                         $this->emit('gotonext','Quant');}
        if ($res=='not') { $this->dispatchBrowserEvent('mmsg', 'هذا الرقم غير مخزون ؟');}
        if ($res=='empty') { $this->dispatchBrowserEvent('mmsg', 'لا يجوز');}
        if ($res=='zero') { $this->dispatchBrowserEvent('mmsg', 'رصيد الصنف صفر .. ويمكنك اضافة رصيد بالنقر علي الايقونة بجانب الاسم');
                          $this->ShowBring=true;}
    }
    public function updatedItem()
    {
        $this->item_name='';
        $this->Quant=1;
        $this->price=0;
        $this->ShowBring=false;
    }

    protected function rules()
    {
        Config::set('database.connections.other.database', Auth::user()->company);
        return [
            'item' => ['required','integer','gt:0', 'exists:other.items,item_no'],
            'Quant' =>   ['required','integer','gt:0'],
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
      if ($this->Quant>$this->st_raseed)
         {$this->dispatchBrowserEvent('mmsg', 'الرصيد لا يسمح !'); return(false);}
        $subtot=number_format($this->price * $this->Quant, 2, '.', '');
        $rebh=$subtot-number_format($this->price_buy * $this->Quant, 2, '.', '');

        $this->orderdetail=['item_no'=>$this->item,'item_name'=>$this->item_name,
            'quant'=>$this->Quant,'price'=>$this->price,'subtot'=>$this->price,'rebh'=>$rebh];
        $this->emit('putdata',$this->orderdetail);
        $this->ShowBring=false;
        return (true);
    }

    public function render()
    {
        if (!is_null($this->search)) {

            $records = items::search($this->search,$this->OrderPlacetype,$this->OrderPlaceId)
                ->take(5)
                ->get();
            $this->isEmpty = '';

        } else {
            $records = [];
            $this->isEmpty = __('Nothings Found.');
        }
        return view('livewire.sell.order-sell-detail',[

            'records'=>$records,
        ]);
    }
}

