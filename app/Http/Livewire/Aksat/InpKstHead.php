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
  public $orderno;
  public $name;
  public $BankGet;

  protected $listeners = [
    'Go',
  ];

  public function updated($propertyName)
  {
    $this->validateOnly($propertyName);
  }
public function Go(){
  $this->FillHead();
  $this->emit('gotonext','no');
}
  public function ResetKstHead(){
    $this->no='';
    $this->acc='';
    $this->orderno='';
  }

  public function updatedBankno()
  {
    $this->emit('GoResetKstDetail');
    Config::set('database.connections.other.database', Auth::user()->company);
    $this->bankname='';
    if ($this->bankno!=null) {
      $result = bank::where('bank_no',$this->bankno)->first();

      if ($result) {  $this->bankname=$result->bankname;

                      $this->BankGet=true;
                      $this->ResetKstHead();
                      $this->emit('bankfound',$this->bankno,$this->bankname);

      }}
  }
  public function updatedNo()
  {
    $this->emit('GoResetKstDetail');
    $this->resetValidation('acc');
    $this->emit('mainfound',$this->no,$this->name);
  }
  public function FillHead(){
    Config::set('database.connections.other.database', Auth::user()->company);
    $this->acc='';
    $this->orderno='';
    if ($this->no!=null) {
      $result = main::where('bank',$this->bankno)->where('no',$this->no)->first();
      if ($result) {
        $this->name=$result->name;
        $this->acc=$result->acc;
        $this->orderno=$result->order_no;
        $this->emit('NoAtUpdate',$result);
      }
    }
  }
  public function ChkNoAndGo(){
    Config::set('database.connections.other.database', Auth::user()->company);
    $this->validate();
    $this->acc='';
    $this->orderno='';
    if ($this->no!=null) {
      $result = main::where('bank',$this->bankno)->where('no',$this->no)->first();
      if ($result) {
        $this->name=$result->name;
        $this->acc=$result->acc;
        $this->orderno=$result->order_no;
        $this->emit('nofound',$result);
        $this->emit('GotoKstDetail');
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
      ['required' => 'لا يجوز','exists' => 'هذا الحساب غير موجود'],

    )->validate();


    if ($this->acc!=null) {
      $result = main::where('bank',$this->bankno)->where('acc',$this->acc)->first();
      if ($result) {
        $this->name=$result->name;
        $this->no=$result->no;
        $this->orderno=$result->order_no;
        $this->emit('NoAtUpdate',$result);
        $this->emit('gotonext','no');

      } }
  }

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


      'orderno' => ['required','integer', 'exists:other.main,order_no'],
    ];
  }
  protected $messages = [
    'required' => 'لا يجوز ترك فراغ',

    'exists' => 'هذا الرقم غير مخزون',

  ];

  public function mount(){

    $this->BankGet=false;
    $this->ResetKstHead();
}

    public function render()
    {
        return view('livewire.aksat.inp-kst-head');
    }
}
