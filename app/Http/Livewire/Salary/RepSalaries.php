<?php

namespace App\Http\Livewire\Salary;

use App\Models\masr\MasCenters;
use App\Models\Salary\Sal_All_View;
use App\Models\Salary\SalaryTrans;
use App\Models\Salary\SalaryView;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class RepSalaries extends Component
{
    use WithPagination;
  protected $paginationTheme = 'bootstrap';
  public $Y,$M;
  public $CenterNo=0;
  public $PlaceChk=false;
  public  $SalaryId=0;
  public $TranType=0;

    public $TheCenterListIsSelected;
    public function updatedTheCenterListIsSelected(){
        $this->TheCenterListIsSelected=0;

    }
  public function selectItem($id,$type){
     $this->SalaryId=$id;
     $this->TranType=$type;
  }
  public function mount(){
    $this->Y=SalaryTrans::max('Y');
    if ($this->Y) $this->M=SalaryTrans::where('Y',$this->Y)->max('M');
  }
    public function render()
    {
        return view('livewire.salary.rep-salaries',[
          'TableList'=>Sal_All_View::
          when(!Auth::user()->can('مرتب خاص'),function($q){
            $q->where('vip','!=',1);
          })
         ->when($this->PlaceChk,function($q){
           $q->where('MasCenter','=',$this->CenterNo);
          })

         ->where('Y',$this->Y)
         ->where('M',$this->M)
         ->where('TranType',1)

         ->paginate(15)
         ,'TableDetail'=>SalaryTrans::where('SalaryId',$this->SalaryId)
                ->where('TranType',$this->TranType)
                ->where('Y',$this->Y)
                ->where('M',$this->M)
                ->paginate(15, ['*'], 'tranPage')]);

    }
}
