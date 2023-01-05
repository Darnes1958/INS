<?php

namespace App\Http\Livewire\Stores;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PerSelect extends Component
{
  public $PerNo;

  public $PerList;


  protected $listeners = [
    'TakePerNo','refreshComponent' => '$refresh'
  ];

  public function TakePerNo($wo){

    if(!is_null($wo)) {
      $this->PerNo = $wo;


    }
  }

  public function hydrate(){
    $this->emit('per-change-event');
  }

  public function render()
    {
      $this->PerList=DB::connection(Auth::user()->company)->table('store_exp_view')
        ->selectRaw('distinct st_no,per_no,exp_date,st_name')
        ->where('exp_date','>',Carbon::now()->subYear(1))
        ->orderBy('per_no', 'DESC')->get();
        return view('livewire.stores.per-select',$this->PerList);
    }
}
