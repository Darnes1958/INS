<?php

namespace App\Http\Livewire\Aksat;

use App\Models\aksat\kst_trans;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\bank\bank;
use App\Models\aksat\main;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class InpKstHead extends Component
{
  public $bankno;
  public $bankname;
  public $no;
  public $acc;

  public $name;
  public $BankGet;

  public $TheBankListIsSelectd;
  public $TheNoListIsSelectd;

  public $The_ser;

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
  public function updatedTheNoListIsSelectd(){

    $this->TheNoListIsSelectd=0;
    $this->ChkNoAndGo();
  }
  protected $listeners = [
    'Go','Take_ManyAcc_No','Ksthead_goto','DeleteTheKst','GetTheId'
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
    $this->emit('ksthead_goto','no');

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
  public function ChkBankAndGo(){


    $this->bankname='';
    if ($this->bankno!=null) {
      $result = bank::on(Auth()->user()->company)->where('bank_no',$this->bankno)->first();

      if ($result) {  $this->bankname=$result->bankname;
        $this->BankGet=true;
        $this->ResetKstHead();
        $this->emit('TakeHafBankNo',$this->bankno,$this->bankname);
        $this->emit('bankfound',$this->bankno,$this->bankname);
        $this->emit('ksthead_goto','no');
      }}

  }
  public function updatedNo()
  {
    $this->acc='';
    $this->resetValidation('acc');

    $this->emit('GoResetKstDetail');
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
      $result = main::on(Auth()->user()->company)->where('bank',$this->bankno)->where('no',$this->no)->first();
      if ($result) {
        $this->name=$result->name;
        $this->acc=$result->acc;
        $orderno=$result->order_no;
        $this->emit('nofound',$result);

        $this->emit('GetTheMainNo',$this->no);
        $this->emit('GotoKstDetail',$this->no,$orderno);
      }
    }
  }
  public function updatedAcc() {

    $this->resetValidation('acc');
    $this->emit('GoResetKstDetail');
  }
  public function ChkAccAndGo(){
    $this->resetValidation('acc');
    Config::set('database.connections.other.database', Auth::user()->company);
    $validatedData = Validator::make(
      ['acc' => $this->acc],
      ['acc' => 'required|string|exists:other.main,acc'],
      ['required' => 'لا يجوز','exists' => 'هذا الحساب غير موجود'])->validate();

    $result = main::on(Auth()->user()->company)->where('bank',$this->bankno)->where('acc',$this->acc)->get();
    if (count($result)!=0) {
        if (count($result)>1){
          $this->emit('GotoManyAcc',$this->bankno,$this->acc);
          $this->dispatchBrowserEvent('OpenKstManyModal');}
        else {
          $result = main::on(Auth()->user()->company)->where('bank',$this->bankno)->where('acc',$this->acc)->first();
          $this->name=$result->name;
          $this->no=$result->no;

          $this->emit('NoAtUpdate',$result);
          $this->emit('ksthead_goto','no');
        }
      } }

  protected function rules()
  {
    Config::set('database.connections.other.database', Auth::user()->company);
    return [
      'bankno' => ['required','integer','gt:0', 'exists:other.bank,bank_no'],

      'no' => ['required','integer','gt:0',
        Rule::exists('other.main')->where(function ($query) {
          $query->where('bank', $this->bankno);
        }),
      ],

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
        return view('livewire.aksat.inp-kst-head');
    }
}
