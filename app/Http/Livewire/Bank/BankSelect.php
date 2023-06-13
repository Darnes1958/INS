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
  public $Taj;


  protected $listeners = [
    'TakeBankNo','TakeTaj'
  ];

  public function TakeBankNo($bankno){

      $this->BankNo = $bankno;

  }
  public function TakeTaj($tajno){

    $this->Taj = $tajno;

  }

  public function mount($taj=null){

    $this->Taj=$taj;
  }
  public function hydrate(){
    $this->emit('bank-change-event');
  }
    public function render()
    {

      $this->BankList=DB::connection(Auth()->user()->company)->table('bank')->
      when($this->Taj,function($q){
        return $q->where('bank_tajmeeh', '=', $this->Taj);})
        ->get();
      return view('livewire.bank.bank-select',$this->BankList);
    }
}
