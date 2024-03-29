<?php

namespace App\Http\Livewire\Aksat;

use App\Models\aksat\main;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class NoSelect extends Component
{
  public $MainNo;
  public $MainName;
  public $MainList;
  public $NoSelectOpen;
  public $bank;
  public $MainOrArc;

  protected $listeners = [
    'nofound','bankfound','banknotfound',
  ];

  public function nofound($res){

      $this->MainNo = $res['no'];
      $this->MainName = $res['name'];

    }


  public function bankfound($wbno,$bname){
    $this->NoSelectOpen=true;
    $this->bank=$wbno;
    $this->render();

  }
  public function banknotfound(){
    $this->NoSelectOpen=false;
    $this->bank=0;
  }

  public function hydrate(){

    $this->emit('main-change-event');
  }
  public function mount($mainorarc='main'){
    $this->MainOrArc=$mainorarc;
    $this->bank=0;
    $this->NoSelectOpen=false;
  }
  public function render()
    {
      $this->MainList=DB::connection(Auth()->user()->company)->table($this->MainOrArc)
        ->where('bank','=',$this->bank)
        ->orderBy('name', 'DESC')->get();

        return view('livewire.aksat.no-select',$this->MainList);
    }
}
