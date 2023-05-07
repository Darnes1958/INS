<?php

namespace App\Http\Livewire\Salary;

use App\Models\Salary\Sal_All_View;
use App\Models\Salary\SalaryTrans;
use App\Models\Salary\SalaryView;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class RepSalTot extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $Y,$M;

    public  $SalaryId=0;
    public $Name;
    public $TheSalIdListIsSelected;

    public function updatedTheSalIdListIsSelected(){

        $this->TheSalIdListIsSelected=0;

    }

    public function selectItem($m){
      info($m);
        $this->M=$m;


    }
    public function mount(){

        $this->Y=date('Y');
    }
    public function render()
    {
        return view('livewire.salary.rep-sal-tot',[
          'TableList'=>Sal_All_View::
          when(!Auth::user()->can('مرتب خاص'),function($q){
            $q->where('vip','!=',1);
          })
            ->selectRaw('Y,M,sum(Sal) sal,sum(saheb) saheb,sum(idafa) idafa,sum(ksm) ksm')
            ->groupby('Y','M')
            ->get(),

         'TableDetail'=>Sal_All_View::
         when(!Auth::user()->can('مرتب خاص'),function($q){
           $q->where('vip','!=',1);
         })
           ->where('Y',$this->Y)
            ->where('M',$this->M)
           ->where('TranType',1)
           ->orderby('id')
            ->paginate(15)
           ]);

    }

}
