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

  public function TakeBankNo($bankno){
info($bankno);
      $this->BankNo = $bankno;

  }

  public function hydrate(){
    $this->emit('bank-change-event');
  }
    public function render()
    {

      $this->BankList=DB::connection(Auth()->user()->company)->table('bank')->get();
      return view('livewire.bank.bank-select',$this->BankList);
    }
}
