<?php

namespace App\Http\Livewire\Aksat;

use App\Models\aksat\kst_trans;
use App\Models\Operations;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\bank\bank;
use App\Models\aksat\main;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class InpKstHead2 extends Component
{
  public $bankno;
  public $bankname;
  public $no;
  public $acc;
  public $Ksm_type=2;

  public $name;
  public $BankGet;

  public $TheBankListIsSelectd;
  public $TheNoListIsSelectd;
  public $TheAccListIsSelectd;

  public $The_ser;

  public function ChangeKsm(){
    $this->emitTo('aksat.inp-kst-detail','TakeKsmType',$this->Ksm_type);
  }

  public function OpenMany(){
    $this->dispatchBrowserEvent('OpenKstManyModal');
  }
  public function CloseMany(){
        $this->dispatchBrowserEvent('CloseKstManyModal');
    }

  public function updatedTheBankListIsSelectd(){
    $this->TheBankListIsSelectd=0;
    $this->ChkBankAndGo();
  }
  public function updatedTheAccListIsSelectd(){
    $this->TheAccListIsSelectd=0;
    $this->ChkAccAndGo();
  }
  public function updatedTheNoListIsSelectd(){

    $this->TheNoListIsSelectd=0;
    $this->ChkNoAndGo();
  }
  protected $listeners = [
    'Go','Take_ManyAcc_No','Ksthead_goto','DeleteTheKst','GetTheId','refreshComponent' => '$refresh',
  ];

  public function GetTheId($id){
    $this->The_ser=$id;
  }
  public function DeleteTheKst(){

    DB::connection(Auth()->user()->company)->beginTransaction();
    try {
    DB::connection(Auth()->user()->company)->table('kst_trans')->where('no',$this->no)->where('ser',$this->The_ser)->update([
      'ksm'=>0,
      'ksm_date'=>null,
      'kst_notes'=>null,
      'emp'=>auth::user()->empno,
    ]);
    $sul_pay=kst_trans::on(Auth()->user()->company)->where('no',$this->no)->where('ksm','!=',null)->sum('ksm');
    $sul=main::on(Auth()->user()->company)->where('no',$this->no)->first();
    $raseed=$sul->sul-$sul_pay;
    main::on(Auth()->user()->company)->where('no',$this->no)->update(['sul_pay'=>$sul_pay,'raseed'=>$raseed]);

    Operations::insert(['Proce'=>'قسط','Oper'=>'الغاء','no'=>$this->no,'created_at'=>Carbon::now(),'emp'=>auth::user()->empno,]);

    DB::connection(Auth()->user()->company)->commit();
    $this->ChkNoAndGo();
    $this->emitTo('tools.my-table','refreshComponent');
    } catch (\Exception $e) {
      DB::connection(Auth()->user()->company)->rollback();

      $this->dispatchBrowserEvent('mmsg', 'حدث خطأ');
    }

  }
public function Ksthead_goto($wid){

  $this->emit('ksthead_goto',$wid);
}
public function Take_ManyAcc_No($The_no){
   $this->no=$The_no;
   $this->ChkNoAndGo();

}
public function Go(){
  $this->FillHead();

}
  public function ResetKstHead(){
    $this->no='';
    $this->acc='';
  }

  public function updatedBankno()
  {
    $this->emit('GoResetKstDetail');
  }

  public function updatedNo()
  {
    $this->acc='';
    $this->resetValidation('acc');

    $this->emit('GoResetKstDetail');
    $this->emit('GotoKstDetail',0,0);
  }
  public function FillHead(){

    $this->acc='';
    if ($this->no!=null) {
      $result = main::on(Auth()->user()->company)->where('bank',$this->bankno)->where('no',$this->no)->first();
      if ($result) {
        $this->name=$result->name;
        $this->acc=$result->acc;
        $this->emit('NoAtUpdate',$result);
      }
    }
  }
  public function ChkNoAndGo(){
    $this->resetValidation('acc');
    $this->validate();

    $this->acc='';
    if ($this->no!=null) {
      $result = main::where('no',$this->no)->first();
      if ($result) {
        $this->name=$result->name;
        $this->bankno=$result->bank;
        $this->bankname=bank::find($this->bankno)->bank_name;
        $this->acc=$result->acc;
        $orderno=$result->order_no;
        $this->emit('nofound',$result,$this->Ksm_type);

        $this->emit('SelectMainAllnofound',$result);
        $this->emit('GetTheMainNo',$this->no);
        $this->emit('GotoKstDetail',$this->no,$orderno);
        $this->emitTo('aksat.inp-kst-detail','kstdetail_goto','ksm_date');
      }
    }
  }
  public function updatedAcc() {

    $this->resetValidation('acc');
    $this->emit('GoResetKstDetail');
    $this->emit('GotoKstDetail',0,0);
  }
  public function ChkAccAndGo(){
    $this->resetValidation('acc');
    Config::set('database.connections.other.database', Auth::user()->company);
    $validatedData = Validator::make(
      ['acc' => $this->acc],
      ['acc' => 'required|string|exists:other.main,acc'],
      ['required' => 'لا يجوز','exists' => 'هذا الحساب غير موجود'])->validate();

    $result = main::where('acc',$this->acc)->get();
    if (count($result)!=0) {

        if (count($result)>1){
          $this->emit('GotoManyAcc',$this->acc);
          $this->dispatchBrowserEvent('OpenKstManyModal');}
        else {

          $result = main::where('acc',$this->acc)->first();
          $this->bankno=$result->bank;
          $this->bankname=bank::find($this->bankno)->bank_name;
          $this->name=$result->name;
          $this->no=$result->no;
          $orderno=$result->order_no;

          $this->emit('NoAtUpdate',$result);
          $this->emit('nofound',$result,$this->Ksm_type);
          $this->emit('GotoKstDetail',$this->no,$orderno);
          $this->emitTo('aksat.inp-kst-detail','kstdetail_goto','ksm_date');
        }
      } }

  protected function rules()
  {
    Config::set('database.connections.other.database', Auth::user()->company);
    return [


      'no' => ['required','integer','gt:0','exists:other.main,no'],



    ];
  }

  protected $messages = [
    'required' => 'لا يجوز ترك فراغ',

    'exists' => 'هذا الرقم غير مخزون',

  ];

  public function mount(){
    $this->TheBankListIsSelectd=0;
    $this->BankGet=false;
    $this->ResetKstHead();
}

    public function render()
    {
        return view('livewire.aksat.inp-kst-head2');
    }
}
