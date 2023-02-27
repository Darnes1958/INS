<?php

namespace App\Http\Livewire\Trans;

use App\Models\bank\bank;
use App\Models\jeha\jeha;
use App\Models\others\price_type;
use App\Models\trans\trans;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Rule;
use Livewire\Component;

class TransHead extends Component
{
  public $JehaRadio='Cust';
  public $ImpExpRadio=1;
  public $jeha_type=1;
  public $TranNo;
  public $jeha;
  public $tran_date;
  public $tran_type=1;
  public $val;
  public $notes;
  public $impexp=1;
  public $IsSave=false;

  public $ThePayNoListIsSelectd;

  protected $listeners = [
    'Take_Search_JehaNo',
  ];
  public function updatedImpexp(){

    $this->ChkJehaAndGo();
  }
  public function updatedJeha(){
    $this->emitTo('trans.trans-table','TakeJehaAndType',0,$this->impexp);
  }
  public function Take_Search_JehaNo($jeha){
    $this->jeha=$jeha;
    $this->ChkJehaAndGo();
  }
  public function ChangeJeha(){
    if ($this->JehaRadio=='Cust') {$this->jeha_type=1;}
    if ($this->JehaRadio=='Supp') {$this->jeha_type=2;}
    if ($this->JehaRadio=='Others') {$this->jeha_type=3;}
    $this->jeha=null;
    $this->emitTo('trans.trans-table','TakeJehaAndType',$this->jeha,$this->impexp);
  }
  public function ChkJeha(){
    if ($this->jeha !=null ) {

      $this->jeha_name = '';
      $this->jeha_type = 0;
      $res = jeha::on(Auth()->user()->company)->find($this->jeha);
      if ($res) {
        $this->jeha_name = $res->jeha_name;
        $this->jeha_type = $res->jeha_type;
        if ($res->jeha_type==1) {return('Cust');}
        if ($res->jeha_type==2) {return('Supp');}
        if ($res->jeha_type!=1 && $res->jeha_type!=2) {return('Others');}

      } else {
        $this->dispatchBrowserEvent('mmsg', 'هذا الرقم غير مخزون ؟');
        return ('not');
      }
    } else {return ('empty');}

  }
  public function ChkJehaAndGo(){
    $res=$this->ChkJeha();

    if ($res!='not' && $res!='empty'){
      if ($res!=$this->JehaRadio) {
        if ($this->JehaRadio=='Cust') {$this->dispatchBrowserEvent('mmsg', 'هذا العميل ليس من الزبائن');return (false);}
        if ($this->JehaRadio=='Supp') {$this->dispatchBrowserEvent('mmsg', 'هذا العميل ليس من الموردين');return (false);}
        if ($this->JehaRadio=='Others') {$this->dispatchBrowserEvent('mmsg', 'هذا العميل ليس من الأخرون');return (false);}
        if ($this->jeha==1 || $this->jeha==2) {$this->dispatchBrowserEvent('mmsg', 'لا يجوز استعمال المبيعات والمشنريات العامة');return (false);}

      }
      $this->emit('gotonext','tran_date');
      $this->emitTo('trans.trans-table','TakeJehaAndType',$this->jeha,$this->impexp);
      return (true);

    } else return (false);

  }
  public function updatedThePayNoListIsSelectd(){
    $this->ThePayNoListIsSelectd=0;
    $this->ChkTypeAndGo();
  }
  public function ChkTypeAndGo(){
    Config::set('database.connections.other.database', Auth::user()->company);
    if ($this->tran_type){
      $res=price_type::on(Auth()->user()->company)->find($this->tran_type);
      if (!$res ){$this->dispatchBrowserEvent('mmsg', 'هذا الرقم غير مخزون ');$this->emit('goto','tran_type');return(false);}
      else {$this->emit('gotonext','jeha');$this->emit('TakePayNo',$res->type_no,$res->type_name);return(true);}
  } else return (false);
  }

  protected function rules()
  {
    Config::set('database.connections.other.database', Auth::user()->company);

    return [
      'tran_date' => ['required','date'],
      'val' => ['required','numeric','gt:0'],
    ];
  }
  protected $messages = [
    'required' => 'لا يجوز ترك فراغ',
    'tran_date.required'=>'يجب ادخال تاريخ صحيح',
  ];
  public function DoSave(){
    if ($this->IsSave)
    {$this->IsSave=false; return false;}

    $this->validate();
    if (!$this->ChkTypeAndGo()) $this->emit('gotonext','tran_type');
    if (!$this->ChkJehaAndGo()) $this->emit('gotonext','jeha');

    $this->TranNo=trans::on(Auth()->user()->company)->max('tran_no')+1;
    trans::on(Auth()->user()->company)->insert([
      'tran_no'=>$this->TranNo,
      'jeha'=>$this->jeha,
      'val'=>$this->val,
      'tran_date'=>$this->tran_date,
      'tran_type'=>$this->tran_type,
      'imp_exp'=>$this->impexp,
      'tran_who'=>1,
      'chk_no'=>0,
      'notes'=>$this->notes,
      'kyde'=>0,
      'emp'=>auth()->user()->empno,
      'order_no'=>0,
      'bank'=>0,
      'inp_date'=>date('Y-m-d'),
      'available'=>1,
    ]);
    $this->IsSave=true;
    $this->jeha=null;
    $this->val=null;
    $this->notes=null;
    $this->emit('gotonext','jeha');
    $this->emitTo('trans.trans-table','TakeJehaAndType',0,$this->impexp);
  }

  public function OpenJehaSerachModal(){

    $this->emitTo('jeha.cust-search','refreshComponent');
    $this->emitTo('jeha.cust-search','WithJehaType',$this->jeha_type);
    $this->dispatchBrowserEvent('OpenTransjehaModal');
  }
  public function CloseJehaSerachModal(){
    $this->dispatchBrowserEvent('CloseTransjehaModal');
  }
  public function OpenModal(){
    $this->emitTo('jeha.add-supp','WithJehaType',$this->jeha_type);
    $this->dispatchBrowserEvent('OpenModal');
  }
  public function CloseModal(){
    $this->dispatchBrowserEvent('CloseModal');
  }
public function mount(){
    $this->tran_date=date('Y-m-d');
}
  public function render()
   {


      $this->TranNo=trans::on(Auth()->user()->company)->max('tran_no')+1;
      return view('livewire.trans.trans-head');
   }
}
