<?php

namespace App\Http\Livewire\Salary;

use App\Models\Salary\Salarys;
use App\Models\Salary\SalaryView;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class IdrajTable extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';
  public $SalId;

  public function ChangeCase($salid,$case){
    $this->SalId=$salid;
    Salarys::find($this->SalId)->update(['SalCase'=>$case]);


  }
    public function render()
    {
        return view('livewire.salary.idraj-table',[
          'TableList'=>SalaryView::
          when(!Auth::user()->can('مرتب خاص'),function($q){
            $q->where('vip','!=',1);
          })
            ->paginate(15),
        ]);
    }
}
