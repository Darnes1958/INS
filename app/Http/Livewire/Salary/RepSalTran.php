<?php

namespace App\Http\Livewire\Salary;

use App\Models\Salary\Sal_All_View;
use App\Models\Salary\SalaryTrans;
use App\Models\Salary\SalaryView;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class RepSalTran extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $Y,$M;
    public $date;
    public  $SalaryId=0;
    public $Name;
    public $TheSalIdListIsSelected;

    public function updatedTheSalIdListIsSelected(){

        $this->TheSalIdListIsSelected=0;

    }

    public function selectItem($id,$name){
        $this->SalaryId=$id;
        $this->Name=$name;

    }
    public function mount(){
        $this->date=Carbon::now();
        $this->date=$this->date->copy()->startOfYear();
    }
    public function render()
    {
        return view('livewire.salary.rep-sal-tran',[
         'TableList'=>SalaryView::
            when(!Auth::user()->can('مرتب خاص'),function($q){
                $q->where('vip','!=',1);
            })
            ->selectRaw('id,Name,Sal,dbo.ret_sal_raseed(id) raseed')
            ->paginate(15),
         'TableDetail'=>SalaryTrans::
            where('SalaryId',$this->SalaryId)
            ->join('SalTranType','SalaryTrans.TranType','=','SalTranType.id')
            ->selectRaw('TranDate,Val,TypeName,Notes')
                ->whereDate('TranDate','>',$this->date)
                ->paginate(15, ['*'], 'tranPage')
           ]);

    }

}
