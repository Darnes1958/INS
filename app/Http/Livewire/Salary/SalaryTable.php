<?php

namespace App\Http\Livewire\Salary;

use App\Models\masr\Masrofat;
use App\Models\masr\MasView;
use App\Models\Operations;
use App\Models\Salary\Salarys;
use App\Models\Salary\SalaryTrans;
use App\Models\Salary\SalaryView;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class SalaryTable extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $SalaryId=0;

    protected $listeners = [
        'refreshComponent' => '$refresh'
    ];


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function selectItem($salaryid,$action){
        $this->SalaryId=$salaryid;

        if ($action=='delete') {$this->dispatchBrowserEvent('OpenMyDelete');}
        if ($action=='update') {$this->emitTo('salary.salary-inp','TakeSalNo',$salaryid);}
      if ($action=='special'){
        Salarys::where('id',$salaryid)
          ->update(['vip'=>1]);
      }
      if ($action=='notspecial'){
        Salarys::where('id',$salaryid)
          ->update(['vip'=>0]);
      }
    }
    public function CloseDeleteDialog(){$this->dispatchBrowserEvent('CloseMyDelete');}


    public function delete(){
        $this->CloseDeleteDialog();
        if (SalaryTrans::where('SalaryId',$this->SalaryId)->exists())
        {
          $this->dispatchBrowserEvent('mmsg', 'سبق ادخال مرتبات علي هذا الحساب');
          return;
        }
        Salarys::where('id',$this->SalaryId)->delete();
        Operations::insert(['Proce'=>'مرتبات','Oper'=>'الغاء','no'=>$this->SalaryId,'created_at'=>Carbon::now(),'emp'=>auth::user()->empno,]);

        $this->render();
    }
    public function render()
    {
        return view('livewire.salary.salary-table',[
            'TableList'=>SalaryView::
              when(!Auth::user()->can('مرتب خاص'),function($q){
                $q->where('vip','!=',1);
              })
              ->orderby('id')
            ->paginate(15)
        ]);
    }
}
