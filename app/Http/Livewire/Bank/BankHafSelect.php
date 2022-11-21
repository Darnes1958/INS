<?php

namespace App\Http\Livewire\Bank;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class BankHafSelect extends Component
{
  public $BankNo;
  public $BankName;
  public $BankList;

  protected $listeners = [
    'TakeBankNo',
  ];

  public function TakeBankNo($wj,$wn){
    if(!is_null($wj)) {
      $this->BankNo = $wj;
      $this->BankName = $wn;
    }
  }

  public function hydrate(){
    $this->emit('bank-change-event');
  }
  public function render()
  {
    Config::set('database.connections.other.database', Auth::user()->company);
    $this->BankList=DB::connection('other')->
    table('hafitha_view')->where('hafitha_state','=',0)
    ->get();
    return view('livewire.bank.bank-haf-select',$this->BankList);
  }
}

