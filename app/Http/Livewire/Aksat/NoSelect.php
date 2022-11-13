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

  protected $listeners = [
    'nofound','bankfound',
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
  public function hydrate(){

    $this->emit('main-change-event');
  }
  public function mount(){
    $this->bank=0;
    $this->NoSelectOpen=false;
  }
  public function render()
    {
      Config::set('database.connections.other.database', Auth::user()->company);
      $this->MainList=DB::connection('other')->table('main')
        ->where('bank','=',$this->bank)
        ->orderBy('name', 'DESC')->get();

        return view('livewire.aksat.no-select',$this->MainList);
    }
}
