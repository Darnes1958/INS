<?php

namespace App\Http\Livewire\Salary;

use App\Models\Salary\Salarys;
use App\Models\Salary\SalaryView;
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
          'TableList'=>SalaryView::paginate(15),
        ]);
    }
}
