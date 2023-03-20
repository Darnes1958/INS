<?php

namespace App\Http\Livewire\Buy;


use App\Models\buy\charge_by;
use App\Models\buy\charge_type;
use App\Models\buy\charges_buy_work;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class ChargeBuy2 extends Component
{
  public $showcharge=false;

  public $charge_by,$charge_type,$val;
  public $TotCharge=0;

  public $order_no;



    public function OpenByAdd(){

        $this->dispatchBrowserEvent('OpenByAdd');
    }
    public function CloseByAdd(){

        $this->dispatchBrowserEvent('CloseByAdd');
    }
    public function OpenTypeAdd(){

        $this->dispatchBrowserEvent('OpenTypeAdd');
    }
    public function CloseTypeAdd(){

        $this->dispatchBrowserEvent('CloseTypeAdd');
    }
    public function open($open,$order_no){
        $this->showcharge=$open;
        $this->order_no=$order_no;

    }

    protected $listeners = [
        'open','TakeChargeEdit','chargetypeadded','chargebyadded'
    ];

    public function chargetypeadded($no){
      $this->charge_type=$no;
    }
    public function chargebyadded($no){
        $this->charge_by=$no;
    }

  public function Close(){
    $this->showcharge=false;


    $this->emitTo('buy.order-buy','openTable',true);
  }
  protected function rules()
  {
    Config::set('database.connections.other.database', Auth::user()->company);
    return [
      'charge_by' => ['required','integer','gt:0', 'exists:other.charge_by,no'],
      'charge_type' => ['required','integer','gt:0', 'exists:other.charge_type,type_no'],
      'val' => ['required','numeric','gt:0'],
    ];
  }
  protected $messages = [
    'required' => 'لا يجوز ترك فراغ',
    'exists' => 'هذا الرقم غير مخزون مسبقا',
  ];

  public function removeitem($rec_no)    {
    charges_buy_work::where('rec_no',$rec_no)->delete();

    $this->TotCharge = number_format(charges_buy_work::where('emp',Auth::user()->empno)->where('order_no',$this->order_no)->sum('val'),2, '.', '');
    $this->emitTo('order-buy','TakeCharge',$this->TotCharge);
    $this->render();

  }
  public function edititem($rec_no)
  {
    $res=charges_buy_work::where('rec_no',$rec_no)->first();
    $this->charge_by=$res->charge_by ;
    $this->charge_type=$res->charge_type ;
    $this->val=$res->val ;
  }

  public function Do(){
   $this->validate();
    $res=charges_buy_work::where('emp',Auth::user()->empno)
      ->where('charge_by',$this->charge_by)
      ->where('charge_type',$this->charge_type)->first();
    if (!$res) charges_buy_work::insert([
      'charge_by'=>$this->charge_by,
      'charge_type'=>$this->charge_type,
      'val'=>$this->val,
      'emp'=>Auth::user()->empno,
      'order_no'=>$this->order_no,
    ]);
    else
      charges_buy_work::where('emp',Auth::user()->empno)
        ->where('order_no',$this->order_no)
        ->where('charge_by',$this->charge_by)
        ->where('charge_type',$this->charge_type)->update([
        'val'=>$this->val,
      ]);
      $this->TotCharge = number_format(charges_buy_work::where('emp',Auth::user()->empno)->where('order_no',$this->order_no)->sum('val'),2, '.', '');
      $this->emitTo('order-buy','TakeCharge',$this->TotCharge);
    $this->charge_type='';
    $this->charge_by='';
    $this->val='';
  }
    public function render()
    {
      $this->TotCharge = number_format(charges_buy_work::where('emp',Auth::user()->empno)->where('order_no',$this->order_no)->sum('val'),2, '.', '');
        return view('livewire.buy.charge-buy2',[
          'ChargeDetail'=>charges_buy_work::
          join('charge_by','charges_buy_work.charge_by','=','charge_by.no')
          ->join('charge_type','charges_buy_work.charge_type','=','charge_type.type_no')
          ->select('charges_buy_work.*','name','type_name')
            ->where('emp',Auth::user()->empno)->where('order_no',$this->order_no)->get(),
          'charge_by_table'=>charge_by::on(Auth::user()->company)->get(),
          'charge_type_table'=>charge_type::on(Auth::user()->company)->get(),
        ]);
    }
}
