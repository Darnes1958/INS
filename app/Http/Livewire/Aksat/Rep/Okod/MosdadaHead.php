<?php

namespace App\Http\Livewire\Aksat\Rep\Okod;

use App\Models\bank\bank;
use App\Models\bank\BankTajmeehy;
use Illuminate\Queue\Listener;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class MosdadaHead extends Component
{

  public $bank_no;

  public $bank_name;
  public $BankGet;

  protected $Listeners = [
      'TakeBank'
  ];

    public function TakeBank($bank_no){

        $this->bank_no=$bank_no;
        $this->bank_name=bank::on(Auth::user()->company)->find($this->bank_no)->bank_name;
        $this->resetPage();

    }
    public function TakeTajNo($tajno){

        $this->TajNo=$tajno;
        $this->bank_name=BankTajmeehy::on(Auth::user()->company)->find($this->TajNo)->TajName;
        $this->resetPage();

    }

    public function render()
    {
        return view('livewire.aksat.rep.okod.mosdada-head');
    }
}
