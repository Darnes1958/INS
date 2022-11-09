<?php

namespace App\Http\Livewire\Aksat;

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


  public function ResetKstHead(){
    $this->no='';
    $this->acc='';
    $this->orderno='';
  }

  public function updatedBankno()
  {
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
    Config::set('database.connections.other.database', Auth::user()->company);
    $this->acc='';
    $this->orderno='';

    if ($this->no!=null) {
      $result = main::where('bank',$this->bankno)->where('no',$this->no)->first();

      if ($result) {
                    $this->name=$result->name;
                    $this->acc=$result->acc;
                    $this->orderno=$result->order_no;
        $this->emit('nofound',$result);
      }}
  }

  protected function rules()
  {
    Config::set('database.connections.other.database', Auth::user()->company);
    return [
      'bankno' => ['required','integer','gt:0', 'exists:other.bank,bank_no'],
      'no' => ['required','integer','gt:0', 'exists:other.main,no'],
      'acc' => ['required','string', 'exists:other.main,acc'],
      'orderno' => ['required','integer', 'exists:other.main,order_no'],
    ];
  }

  public function mount(){

    $this->BankGet=false;
    $this->ResetKstHead();
}

    public function render()
    {
        return view('livewire.aksat.inp-kst-head');
    }
}
