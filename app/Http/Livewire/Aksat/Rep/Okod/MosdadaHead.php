<?php

namespace App\Http\Livewire\Aksat\Rep\Okod;

use App\Models\bank\bank;
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
    'TakeBank'];

  public function TakeBank(){

  }
  public function render()
    {
        return view('livewire.aksat.rep.okod.mosdada-head');
    }
}
