<?php

namespace App\Http\Livewire\Salary;

use App\Models\Salary\SalaryTrans;
use App\Models\Salary\SalaryView;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RepSalaries extends Component
{
  public $Y,$M;

  public function mount(){
    $this->Y=SalaryTrans::max('Y');
    if ($this->Y) $this->M=SalaryTrans::where('Y',$this->Y)->max('M');
  }
    public function render()
    {
        return view('livewire.salary.rep-salaries',[
          'TableList'=>SalaryView::
          when(!Auth::user()->can('مرتب خاص'),function($q){
            $q->where('vip','!=',1);
          })
         ->join('SalaryTrans','SalaryView.id','=','SalaryTrans.SalaryId')
            ->where('Y',$this->Y)
            ->where('M',$this->M)
         ->select('SalaryView.*','SalaryTrans.*')
         ->paginate(15)
        ,'Years'=>SalaryTrans::select('Y')->distinct()->get()
        ,'Months'=>SalaryTrans::select('M')->where('Y',$this->Y)->distinct()->get()]);
    }
}
