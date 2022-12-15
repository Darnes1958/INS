<?php

namespace App\Http\Livewire\Bank;

use App\Models\bank\bank;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class BankSelect extends Component
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
      $this->BankList=DB::connection('other')->table('bank')->get();
      return view('livewire.bank.bank-select',$this->BankList);
    }
}
