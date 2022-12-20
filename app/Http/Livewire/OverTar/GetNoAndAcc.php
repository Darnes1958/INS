<?php

namespace App\Http\Livewire\OverTar;

use App\Models\aksat\kst_trans;
use App\Models\aksat\MainArc;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\bank\bank;
use App\Models\aksat\main;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class GetNoAndAcc extends Component
{
  public $bankno;
  public $bankname;
  public $no;
  public $acc;

  public $name;
  public $BankGet;

  public $TheBankListIsSelected;
  public $TheNoListIsSelectd;

  public $MainOrArc;

  public $ToWhome;
  public function OpenMany(){
    $this->dispatchBrowserEvent('OpenKstManyModal');
  }
  public function CloseMany(){
    $this->dispatchBrowserEvent('CloseKstManyModal');
  }

  public function updatedTheBankListIsSelected(){
    $this->TheBankListIsSelected=0;
    info($this->bankno);
    $this->emitTo('bank.bank-select','TakeBankNo',$this->bankno);
    $this->ChkBankAndGo();
  }
  public function updatedTheNoListIsSelectd(){

    $this->TheNoListIsSelectd=0;
    $this->ChkNoAndGo();
  }
  protected $listeners = [
    'Go','Take_ManyAcc_No'
  ];


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
    $this->emitTo($this->ToWhome,'BankIsUpdating');
  }
  public function ChkBankAndGo(){
    Config::set('database.connections.other.database', Auth::user()->company);
    $this->bankname='';
    if ($this->bankno!=null) {
      $result = bank::where('bank_no',$this->bankno)->first();
      if ($result) {
        $this->emitTo('bank.bank-select','TakeBankNo',$this->bankno);
        $this->bankname=$result->bankname;
        $this->BankGet=true;
        $this->ResetKstHead();
        $this->emitTo('aksat.no-select','bankfound',$this->bankno,$this->bankname);
        $this->emit('goto','no');
      }}

  }
  public function updatedNo()
  {
    $this->acc='';
    $this->resetValidation('acc');
    $this->emitTo($this->ToWhome,'NoIsUpdating');
  }
  public function FillHead(){
    Config::set('database.connections.other.database', Auth::user()->company);
    $this->acc='';
    if ($this->no!=null) {
      if ($this->MainOrArc=='main') $result = main::where('bank',$this->bankno)->where('no',$this->no)->first();
      if ($this->MainOrArc=='mainarc') $result =MainArc::where('bank',$this->bankno)->where('no',$this->no)->first();
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
      if ($this->MainOrArc=='main') $result = main::where('bank',$this->bankno)->where('no',$this->no)->first();
      if ($this->MainOrArc=='mainarc') $result =MainArc::where('bank',$this->bankno)->where('no',$this->no)->first();
      if ($result) {
        $this->emitTo('aksat.no-select','nofound',$result);
        $this->name=$result->name;
        $this->acc=$result->acc;
        $this->emitTo($this->ToWhome,'TakeData',$this->bankno,$this->acc,$this->no,$this->name);
        $this->emit('TakeNo',$this->no);
      }
    }
  }
  public function updatedAcc() {
    $this->resetValidation('acc');
    $this->emit($this->ToWhome,'AccIsUpdating');
  }
  public function ChkAccAndGo(){
    $this->resetValidation('acc');
    Config::set('database.connections.other.database', Auth::user()->company);
    $validatedData = Validator::make(
      ['acc' => $this->acc],
      ['acc' => 'required|string|exists:other.'.$this->MainOrArc.',acc'],
      ['required' => 'لا يجوز','exists' => 'هذا الحساب غير موجود'])->validate();

    if ($this->MainOrArc=='main')
    {
      $result = main::where('bank',$this->bankno)->where('acc',$this->acc)->get();

        if (count($result)!=0) {
          if (count($result) > 1) {
            $this->emit('GotoManyAcc', $this->bankno, $this->acc);
            $this->dispatchBrowserEvent('OpenKstManyModal');
          } else {
            $result = main::where('bank', $this->bankno)->where('acc', $this->acc)->first();
            $this->name = $result->name;
            $this->no = $result->no;

            $this->emit('NoAtUpdate', $result);
            $this->emit('goto', 'no');
          }
        }
    }
    }

  protected function rules()
  {
    Config::set('database.connections.other.database', Auth::user()->company);
    $table='other.'.$this->MainOrArc;
    return [
      'bankno' => ['required','integer','gt:0', 'exists:other.bank,bank_no'],

      'no' => ['required','integer','gt:0',
        Rule::exists($table)->where(function ($query) {
          $query->where('bank', $this->bankno);
        }),
      ],

    ];
  }

  protected $messages = [
    'required' => 'لا يجوز ترك فراغ',

    'exists' => 'هذا الرقم غير مخزون',

  ];

  public function mount($towhome='over-tar.inp-over-tar',$mainorarc='main'){
    $this->MainOrArc=$mainorarc;
    $this->ToWhome=$towhome;
    $this->TheBankListIsSelectd=0;
    $this->BankGet=false;
    $this->ResetKstHead();
  }

  public function render()
  {
    return view('livewire.over-tar.get-no-and-acc');
  }
}



