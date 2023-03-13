<?php

namespace App\Http\Livewire\Salary;

use App\Models\Salary\Salarys;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EmpSelect extends Component
{
  public $SalId;
  public $Name;
  public $SalIdList;

  protected $listeners = [
    'TakeSalId',
  ];


  public function TakeSalId($salid){
    $this->SalId = $salid;
  }
  public function hydrate(){
    $this->emit('salid-change-event');
  }

    public function render()
    {
        $this->SalIdList=Salarys::where('SalCase',1)
          ->when(!Auth::user()->can('مرتب خاص'),function($q){
            $q->where('vip','!=',1);
          })
          ->get();
        return view('livewire.salary.emp-select',$this->SalIdList);
    }
}
