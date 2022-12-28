<?php

namespace App\Http\Livewire\Bank;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class BankHafSelect extends Component
{
  public $BankHafNo;
  public $BankHafName;
  public $BankHafList;

  protected $listeners = [
    'TakeHafBankNo','refreshBankHafSelect' => '$refresh',
  ];

  public function TakeHafBankNo($wj,$wn){
    if(!is_null($wj)) {
      $this->BankHafNo = $wj;
      $this->BankHafName = $wn;
    }
  }

  public function hydrate(){
    $this->emit('bank-haf-change-event');
  }
  public function render()
  {

    $this->BankHafList=DB::connection(Auth()->user()->company)->
    table('hafitha_view')->where('hafitha_state','=',0)
    ->get();
    return view('livewire.bank.bank-haf-select',$this->BankHafList);
  }
}

