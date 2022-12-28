<?php

namespace App\Http\Livewire\Buy;



use App\Models\stores\stores;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;
use App\Models\stores\items;
use App\Http\Livewire\Traits\MyLib;

class OrderBuyDetailEdit extends Component
{
    use MyLib;
    public $stno=1;
    public $item;
    public $order_no;
    public $item_name;
    public $st_raseed;
    public $raseed;
    public $quant;
    public $price;
    public $orderdetail=[];

    public $DetailOpen;
    public $OrderDetailOpen;
    public $ItemGeted=false;

    public $TheItemListSelected;

    public function updatedTheItemListSelected(){
        $this->TheItemListSelected=0;

        $this->ChkItemAndGo();
    }

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


    protected $listeners = [
        'itemchange','edititem','YesIsFound','ClearData','mountdetail','dismountdetail','TakeParam'
    ];
    public function TakeParam($order_no,$stno){
        $this->order_no=$order_no;
        $this->stno=$stno;
    }
    public function ChkItemAndGo(){
        $this->item_name='';

        if ($this->item!=null) {
            $result=items::on(Auth()->user()->company)->with('iteminstore')
            ->where('item_no', $this->item)->first();
            if ($result) {
                $this->IfBuyItemExists($this->order_no,$this->item,$this->stno);
                $this->item_name=$result->item_name;
                $this->price=number_format($result->price_buy, 2, '.', '')  ;

                $this->raseed= $result->raseed;
                $this->st_raseed=0;

                for ($i=0;$i<count($result->iteminstore);$i++)
                 { if($result->iteminstore[$i]->st_no==$this->stno){$this->st_raseed=$result->iteminstore[$i]->raseed;}}
                $this->emit('ChkIfDataExist',$this->item);
                $this->ItemGeted=true;
                $this->emit('gotonext','quant');
            }}
    }
    public function updatedItem()
    {
      $this->ItemGeted=false;
    }
    public function ChkQuantAndGo(){
     if ($this->quant){
         if ($this->ItemExistsInOrder){
             if (($this->st_raseed-$this->OldItemQuant+$this->quant)<0){
                 $this->dispatchBrowserEvent('mmsg', 'لا تجوز هذه الكمية .. سيصبح رصيد المخزن أقل من صفر');
                 $this->emit('gotonext','quant');
                 return (false);
             }
         }

         $this->emit('gotonext','price');
       return true;
     }

    }

    public function mountdetail(){
        $this->OrderDetailOpen=true;
        $this->DetailOpen=true;
        $this->ClearData();
        $this->emit('gotonext', 'itemno');
    }
    public function dismountdetail(){

        $this->ClearData();
        $this->DetailOpen=false;
        $this->OrderDetailOpen=false;
    }

    public function mount()
    {

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
        $this->emit('gotonext', 'quant');
    }
    public function itemchange($value)
    {
        if(!is_null($value))
            $this->item = $value;
        $this->emit('gotonext', 'item_no');
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

    public function ChkPriceAndGo()
    {
        $this->validate();
        if (!$this->ChkQuantAndGo()) return false;

        $this->orderdetail=['item_no'=>$this->item,'item_name'=>$this->item_name,
            'quant'=>$this->quant,'price'=>$this->price,'subtot'=>$this->price];
        $this->emit('putdata',$this->orderdetail);
        $this->mountdetail();
        $this->emit('gotonext','itemno');
        return true;
    }



    public function render()
    {
        return view('livewire.buy.order-buy-detail-edit');
    }
}
