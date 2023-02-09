<?php

namespace App\Http\Livewire\Buy;


use App\Models\buy\charge_by;
use App\Models\buy\charge_type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class ChargeBuy extends Component
{
  public $showcharge=false;
  public $ChargeDetail=[];
  public $charge_by,$charge_type,$val;
  public $TotCharge=0;
  public $ToHead='buy.order-buy-head';
  public $ToTable='buy.order-buy-table';


    public function open($open){
        $this->showcharge=$open;
    }

    protected $listeners = [
        'open','TakeChargeEdit'
    ];
  public function TakeChargeEdit($chargedet){
    $this->ChargeDetail=$chargedet;
  }
  public function Close(){
    $this->showcharge=false;
    $this->emitTo($this->ToTable,'TakeCharge',$this->ChargeDetail);
    $this->emitTo($this->ToTable,'open',true);
  }
  public function mount($head,$table){
    $this->ToHead=$head;
    $this->ToTable=$table;
    $this->ChargeDetail=[
      ['no'=>'0','name'=>'',
        'type_no'=>'0','type_name'=>'','val'=>'0', ]
    ];
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

  public function removeitem($value)    {
    unset($this->ChargeDetail[$value]);
    array_values($this->ChargeDetail);
    $this->TotCharge = number_format(array_sum(array_column($this->ChargeDetail, 'val')),
      2, '.', '');
    $this->emitTo($this->ToHead,'TakeCharge',$this->TotCharge);
  }
  public function edititem($value)
  {
    $this->charge_by=$this->ChargeDetail[$value]['no'] ;
    $this->charge_type=$this->ChargeDetail[$value]['type_no'] ;
    $this->val=$this->ChargeDetail[$value]['val'] ;
  }

  public function Do(){
   $this->validate();
    $One= array_column($this->ChargeDetail, 'type_no');
    $index = array_search( $this->charge_type, $One);
    if  ($index) {
      $this->ChargeDetail[$index]['no']=$this->charge_by;
      $this->ChargeDetail[$index]['name']=charge_by::on(Auth::user()->company)->find($this->charge_by)->name;
      $this->ChargeDetail[$index]['type_no']=$this->charge_type;
      $this->ChargeDetail[$index]['type_name']=charge_type::on(Auth::user()->company)->find($this->charge_type)->type_name;
      $this->ChargeDetail[$index]['val']=$this->val;
    }
    else {
      $this->ChargeDetail[] =
        ['no' => $this->charge_by,
         'name' => charge_by::on(Auth::user()->company)->find($this->charge_by)->name,
         'type_no'=>$this->charge_type,
         'type_name'=>charge_type::on(Auth::user()->company)->find($this->charge_type)->type_name,
         'val'=>$this->val,
          ];
    }
    $this->TotCharge = number_format(array_sum(array_column($this->ChargeDetail, 'val')),
      2, '.', '');
    $this->emitTo($this->ToHead,'TakeCharge',$this->TotCharge);

    $this->charge_type='';
    $this->charge_by='';
    $this->val='';
  }
    public function render()
    {
        return view('livewire.buy.charge-buy',[
          'charge_by_table'=>charge_by::on(Auth::user()->company)->get(),
          'charge_type_table'=>charge_type::on(Auth::user()->company)->get(),
        ]);
    }
}
