<?php

namespace App\Http\Livewire\Salary;

use App\Models\salary\SalaryKsmIdafa_view;
use App\Models\Salary\Salarys;
use App\Models\Salary\SalaryTrans;
use App\Models\Salary\SalaryView;
use Livewire\Component;
use Livewire\WithPagination;

class TransTable extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';
  public $SalId;
  public $Y,$M;

  protected $listeners = [
    'refreshTable'=>'$refresh','TakeYearMonth'
  ];

  public function TakeYearMonth($y,$m){
    $this->Y=$y;
    $this->M=$m;
  }
  public function selectItem($salid,$sal,$name){
   $this->SalId=$salid;
   $this->emit('TakeSalId',$this->SalId,$sal,$name);
  }

  public function mount(){
    $this->Y=SalaryTrans::max('Y');
    $this->M=SalaryTrans::where('Y',$this->Y)->max('M');
  }
    public function render()
    {
        return view('livewire.salary.trans-table',[
          'TableList'=>SalaryKsmIdafa_view::where('Y',$this->Y)->where('M',$this->M)->paginate(15),
        ]);
    }
}
