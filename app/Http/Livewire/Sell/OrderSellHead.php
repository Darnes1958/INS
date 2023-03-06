<?php

namespace App\Http\Livewire\Sell;

use App\Models\LarSetting;
use App\Models\sell\sells;
use App\Models\jeha\jeha;
use App\Models\stores\halls_names;
use App\Models\stores\items;
use App\Models\stores\stores;
use App\Models\stores\stores_names;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;




class OrderSellHead extends Component
{

    public $ToSal_L;
    public $ToSal;


    public $order_no;
    public $order_date;
    public $jeha_no;
    public $jeha_type;
    public $stno=1;
    public $storel;
    public $st_name;
    public $jeha_name;

    public $OredrSellRadio;
    public $PlaceLabel='المخزن';

    public $price_type=1;

    public $stores_names;
    public $halls_names;
    public $HeadOpen;
    public $HeadDataOpen;
    public $ThePriceListIsSelected;


    public $search, $isEmpty = '',$ShowSearch=false;




  protected $listeners = [
    'mounthead','jehaadded','Take_Search_JehaNo',
  ];



  public function updatedThePriceListIsSelected(){
    $this->ThePriceListIsSelected=0;
    $this->emitTo('sell.price-select','TakeTypeNo',$this->price_type);
    $this->emit('gotohead','jehano');

  }

 public function ChkToSal_No(){
   if ($this->ToSal_L!=null) {
       $res=halls_names::on(Auth()->user()->company)->find($this->ToSal_L);
       if ($res) {$this->emit('gotohead','head-btn');}
       else {$this->dispatchBrowserEvent('mmsg','هذا الرقم غير مخزون');}
     }

 }
  public function PlaceKeyEnter(){

    if ($this->ChkPlace()=='ok') {
      if ($this->OredrSellRadio=='Makazen' && $this->ToSal && auth()->user()->can('ادخال مخازن')) $this->emit('gotohead','ToSal_No');
      else $this->emit('gotohead','head-btn');}
}
public function ChkPlace(){
    $this->storel='';
    $conn=Auth()->user()->company;
    if ($this->stno!=null) {
        if ($this->OredrSellRadio=='Makazen'){
            $res=stores_names::on($conn)->find($this->stno);
            if ($res) {$this->storel=$res->st_no; $this->st_name=$res->st_name; return('ok');}
            else  {$this->dispatchBrowserEvent('mmsg','هذا الرقم غير مخزون ؟'); return('not');}
        }
        if ($this->OredrSellRadio=='Salat'){
            $res=halls_names::on($conn)->find($this->stno);
            if ($res) {$this->storel=$res->hall_no; $this->st_name=$res->hall_name;return('ok');}
            else {$this->dispatchBrowserEvent('mmsg','هذا الرقم غير مخزون');return('not');}
        }
      }
    else {return ('empty');}
}
 public function updatedOredrSellRadio(){
     $conn=Auth()->user()->company;
     $this->stores_names=DB::connection($conn)->table('stores_names')->get();
     $this->halls_names=DB::connection($conn)->table('halls_names')->get();

 }
  public function ChangePlace(){


    if ($this->OredrSellRadio=='Makazen') {

      $this->PlaceLabel ='المخزن';
    } else
    {

      $this->PlaceLabel ='الصالة';
    }
  }

    public function updatedStorel()
    {
         $this->FillStno();
    }
    public function FillStno(){
        $this->stno=$this->storel;
        $this->emit('gotohead', 'storeno');

    }

  public function Chkjeha(){
      if ($this->jeha_no !=null ) {

          $this->jeha_name = '';
          $this->jeha_type = 0;
          $conn=Auth()->user()->company;
          $res = jeha::on($conn)->find($this->jeha_no);
          if ($res) {
              if ($res->jeha_no==1  && $this->price_type==2) {return('amaa');}
              if ($res->jeha_type==2) {return('supp');}
              $this->jeha_name = $res->jeha_name;
              $this->jeha_type = $res->jeha_type;
              return ('ok');
          } else {
              $this->dispatchBrowserEvent('mmsg', 'هذا الرقم غير مخزون ؟');
              return ('not');
          }
      } else {return ('empty');}
  }
  public function fetchEmployeeDetail($key){
      $this->search='';
      $this->jeha_no=$key;
      $this->emit('gotohead', 'jehano');
      $this->JehaKeyDown();
  }
  public function SearchEnter(){
      if ($this->search && is_numeric($this->search)  ){

          if (jeha::on(Auth::user()->company)->where('jeha_no',$this->search)->exists()){
              $this->jeha_no=$this->search;
              $this->search='';
              $this->ShowSearch=false;
              $this->emit('gotohead', 'jehano');
              $this->JehaKeyDown();

          } else $this->ShowSearch=true;
      }
  }
  public function JehaKeyDown(){
      $res=$this->Chkjeha();
      if ($res =='ok')  {
        $this->emit('gotohead','orderno');
      }
      if ($res =='amaa' ) {
          $this->dispatchBrowserEvent('mmsg', 'لا تجوز المبيعات العامة هنا ؟');
      }
      if ($res =='supp')  {
          $this->dispatchBrowserEvent('mmsg', 'هذا العميل من الموردين وليس الزبائن ؟');
      }
  }

  public function Take_Search_JehaNo($jeha_no){
    $this->jeha_no=$jeha_no;
    $this->JehaKeyDown();
    }
    public function OpenJehaSerachModal(){
      $this->dispatchBrowserEvent('OpenSelljehaModal');
    }
    public function CloseJehaSerachModal(){
      $this->dispatchBrowserEvent('CloseSelljehaModal');
    }
    public function jehaadded($wj){
        $this->jeha_no=$wj;
        $this->JehaKeyDown();
    }
    public function OpenModal(){
      $this->emitTo('jeha.add-supp','WithJehaType',1);
        $this->dispatchBrowserEvent('OpenModal');
    }
    public function CloseModal(){
        $this->dispatchBrowserEvent('CloseModal');
    }

    public function mounthead(){
        $this->mount();
        $this->emit('gotohead','jehano');
    }


    protected function rules()
    {
        Config::set('database.connections.other.database', Auth::user()->company);

        return [
            'order_no' => ['required','integer','gt:0', 'unique:other.sells,order_no'],
            'jeha_no' =>['required','integer','gt:0', 'exists:other.jeha,jeha_no'],
            'order_date' => 'required',


        ];
    }
    protected $messages = [
        'exists' => 'هذا الرقم غير مخزون',
        'required' => 'لا يجوز ترك فراغ',
        'unique' => 'هذا الرقم مخزون مسبقا',

        'order_date.required'=>'يجب ادخال تاريخ صحيح',
    ];

    public function mount()
    {
        $this->OredrSellRadio=LarSetting::first()->SellSalOrMak;
        if (Auth::user()->can('ادخال مخازن')) $this->ToSal=(LarSetting::first()->ToSal=='yes');
        else $this->ToSal=false;
        $conn=Auth()->user()->company;
        if (($this->price_type==2 and LarSetting::first()->SellTakInc=='inc') ||
            ($this->price_type==1 and LarSetting::first()->SellNakInc=='inc') )
         $this->order_no=DB::connection($conn)->table('sells')->max('order_no')+1;
        else $this->order_no='';

        $this->order_date=date('Y-m-d');
        $this->jeha_no='';
        $this->jeha_name='';
        $this->jeha_type='1';
        $this->HeadDataOpen=false;
        $this->HeadOpen=True;


    }

    public function BtnHeader()
    {
        $this->validate();
        $this->JehaKeyDown();
        if ($this->ChkPlace()=='empty') {$this->dispatchBrowserEvent('mmsg', 'يجب ادخال نقطة البيع ؟'); return(false);}
        if ($this->OredrSellRadio=='Makazen' && $this->ToSal){
          if ($this->ToSal_L==null || !(halls_names::on(auth()->user()->company)->where('hall_no',$this->ToSal_L)->exists()) ){
            $this->dispatchBrowserEvent('mmsg', 'يجب ادخال رقم صالة صحيح');
            return false;
          }
        }

        $this->HeadOpen=false;
        $this->HeadDataOpen=true;
        $this->emit('HeadBtnClick',$this->order_no,$this->order_date,$this->jeha_no,$this->OredrSellRadio,$this->stno,$this->price_type,$this->ToSal,$this->ToSal_L);
        $this->emit('mountdetail',$this->OredrSellRadio,$this->stno,$this->st_name,$this->price_type);

        $this->emitTo('stores.search-item','TakeItemType',$this->OredrSellRadio,$this->stno);

        return (true);
    }



    public function render()
    {
        if (!is_null($this->search)) {

            $records = jeha::search($this->search,1)
                ->take(5)
                ->get();
            $this->isEmpty = '';

        } else {
            $records = [];
            $this->isEmpty = __('Nothings Found.');
        }


        $this->stores_names=DB::connection(Auth::user()->company)->table('stores_names')->get();
        $this->halls_names=DB::connection(Auth::user()->company)->table('halls_names')->get();
        return view('livewire.sell.order-sell-head',[
            'stores_names'=>$this->stores_names,
            'halls_names'=>$this->halls_names,
            'records'=>$records,
        ]);
    }
}

