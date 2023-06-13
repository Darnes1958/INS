<?php

namespace App\Http\Livewire\Aksat\Rep;

use App\Models\bank\bank;
use App\Models\bank\BankTajmeehy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class TajComp extends Component
{
  public $TajNo;
  public $TajName;
  public $Sender;

  public $TheTajListIsSelectd;

  public function updatedTheTajListIsSelectd(){
    $this->TheTajListIsSelectd=0;
    $this->emit('goto','TajNo');


    $this->ChkTajAndGo();
  }
  public function mount($sender=null){
    $this->Sender=$sender;
    }
  public function ChkTajAndGo(){


    $this->TajName='';
    if ($this->TajNo!=null) {
      $result = BankTajmeehy::on(Auth()->user()->company)->where('TajNo',$this->TajNo)->first();
      if ($result) {

        $this->TajName=$result->TajName;
        $this->emitTo($this->Sender,'TakeTajNo',$this->TajNo);

        $this->emitTo('admin.taj-kaema-select','TakeTajNo',$this->TajNo);
        $this->emitTo('bank.bank-select','TakeTaj',$this->TajNo);
      } else {$this->dispatchBrowserEvent('mmsg', 'هذا الرقم غير مخزون');}
    }

  }
    public function render()
    {
        return view('livewire.aksat.rep.taj-comp');
    }
}
