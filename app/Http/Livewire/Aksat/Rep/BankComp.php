<?php

namespace App\Http\Livewire\Aksat\Rep;

use App\Models\bank\bank;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class BankComp extends Component
{
  public $bank_no;
  public $bank_name;
  public $Sender;
  public $Taj;

  public $TheBankListIsSelectd;

  public function updatedTheBankListIsSelectd(){
    $this->TheBankListIsSelectd=0;
    $this->emit('goto','bank_no');


    $this->ChkBankAndGo();
  }
  public function mount($sender=null,$taj=null){
    $this->Sender=$sender;
    $this->Taj=$taj;
    }
  public function ChkBankAndGo(){


    $this->bank_name='';
    if ($this->bank_no!=null) {
      $result = bank::on(Auth()->user()->company)->where('bank_no',$this->bank_no)->first();
      if ($result) {

        $this->bank_name=$result->bank_name;
        $this->emitTo($this->Sender,'TakeBank',$this->bank_no);

        $this->emitTo('bank.bank-select','TakeBankNo',$this->bank_no);
      } else {$this->dispatchBrowserEvent('mmsg', 'هذا الرقم غير مخزون');}
    }

  }
    public function render()
    {
        return view('livewire.aksat.rep.bank-comp');
    }
}
