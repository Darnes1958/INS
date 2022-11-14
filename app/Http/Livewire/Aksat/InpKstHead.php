<?php

namespace App\Http\Livewire\Aksat;

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
    'Go','Take_ManyAcc_No',
  ];

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

    Config::set('database.connections.other.database', Auth::user()->company);
    $this->bankname='';
    if ($this->bankno!=null) {
      $result = bank::where('bank_no',$this->bankno)->first();

      if ($result) {  $this->bankname=$result->bankname;
        $this->BankGet=true;
        $this->ResetKstHead();
        $this->emit('TakeBankNo',$this->bankno,$this->bankname);
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
    Config::set('database.connections.other.database', Auth::user()->company);
    $this->acc='';
    if ($this->no!=null) {
      $result = main::where('bank',$this->bankno)->where('no',$this->no)->first();
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
    Config::set('database.connections.other.database', Auth::user()->company);


    $this->acc='';
    if ($this->no!=null) {
      $result = main::where('bank',$this->bankno)->where('no',$this->no)->first();
      if ($result) {
        $this->name=$result->name;
        $this->acc=$result->acc;
        $orderno=$result->order_no;
        $this->emit('nofound',$result);
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

    $result = main::where('bank',$this->bankno)->where('acc',$this->acc)->get();
    if ($result) {
        if (count($result)>1){
          $this->emit('GotoManyAcc',$this->bankno,$this->acc);
          $this->dispatchBrowserEvent('OpenKstManyModal');}
        else {
          $result = main::where('bank',$this->bankno)->where('acc',$this->acc)->first();
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
