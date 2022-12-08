<?php

namespace App\Http\Livewire\Buy;


use App\Models\stores\stores;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;
use App\Models\stores\items;


class OrderBuyDetailEdit extends Component
{
    public $item;
    public $item_name;
    public $st_raseed;
    public $raseed;
    public $quant;
    public $price;
    public $orderdetail=[];

    public $DetailOpen;
    public $OrderDetailOpen;

    public function OpenFirst(){
        $this->dispatchBrowserEvent('OpenFirst');
    }
    public function CloseFirst(){
        $this->dispatchBrowserEvent('CloseFirst');
    }
    public function CloseSecond(){
        $this->dispatchBrowserEvent('CloseSecond');
        $this->dispatchBrowserEvent('OpenFirst');
        $this->emit('gotoaddonetype');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    protected $listeners = [
        'itemchange','edititem','YesIsFound','ClearData','mountdetail','dismountdetail'
    ];
    public function mountdetail(){
        $this->OrderDetailOpen=true;
        $this->DetailOpen=true;


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
    public function updatedItem()

    {
        $this->item_name='';
        Config::set('database.connections.other.database', Auth::user()->company);
        if ($this->item!=null) {
          $result=items::with('iteminstore')->
           where('item_no', $this->item)->first();

            if ($result) {
                $this->item_name=$result->item_name;
                $this->price=number_format($result->price_buy, 2, '.', '')  ;
                $this->raseed= $result->raseed;

               if ($result->iteminstore->count()!=0) {$this->st_raseed=$result->iteminstore[0]->raseed;}
               else {$this->st_raseed=0;}

                $this->emit('ChkIfDataExist',$this->item);

            }}
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

    public function ChkItem()
    {
        $this->validate();
        $this->orderdetail=['item_no'=>$this->item,'item_name'=>$this->item_name,
            'quant'=>$this->quant,'price'=>$this->price,'subtot'=>$this->price];
        $this->emit('putdata',$this->orderdetail);
    }



    public function render()
    {
        return view('livewire.buy.order-buy-detail');
    }
}
