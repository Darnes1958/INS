<?php

namespace App\Http\Livewire\Salary;

use App\Models\aksat\chk_tasleem;
use App\Models\Operations;
use App\Models\Salary\Salarys;
use App\Models\Salary\SalaryTrans;
use Carbon\Carbon;
use Faker\Guesser\Name;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class TransHead extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';
  public $year;
  public $month;
  public $TranType=3;
  public $SalId;
  public $TransId;
  public $Name;
  public $Sal;
  public $Val;
  public $Notes;
  public $IsSave=false;
  public $IsModify=false;

  protected $listeners = [
     'TakeSalId'
  ];

  public function TakeSalId($salid,$sal,$name){
    $this->SalId=$salid;
    $this->Name=$name;
    $this->Sal=$sal;
    $this->IsModify=false;
      $this->emit('gotonext','Val');

  }
  public function updated(){
    $this->IsSave=false;
  }

  public function selectItem($transid,$val,$notes,$action){
    $this->TransId=$transid;
    $this->Val=$val;
    $this->Notes=$notes;

    if ($action=='delete') {$this->dispatchBrowserEvent('OpenMyDelete');}
    if ($action=='update') {$this->IsModify=True;$this->emit('gotonext','Val');}
  }
  public function CloseDeleteDialog(){$this->dispatchBrowserEvent('CloseMyDelete');}


  public function delete(){
    $this->CloseDeleteDialog();

    SalaryTrans::where('id',$this->TransId)->delete();
    Operations::insert(['Proce'=>'حركة مرتب','Oper'=>'الغاء','no'=>$this->SalId,'created_at'=>Carbon::now(),'emp'=>auth::user()->empno,]);


    $this->Val='';
    $this->emit('refreshTable');
  }
  public function ChkYear(){
    if (!$this->year || $this->year<date('Y')-1 || $this->month>date('Y')) {
      $this->dispatchBrowserEvent('mmsg','ادخال خطأ');
      return;
    }
    $this->SalId=null;
    $this->emit('TakeYearMonth',$this->year,$this->month);
    $this->emit('refreshTable');
    $this->emit('gotonext','month');
  }
  public function ChkMonth(){
    if (!$this->month || $this->month<1 || $this->month>12) {
      $this->dispatchBrowserEvent('mmsg','ادخال خطأ');
      return;
    }
    $this->SalId=null;
    $this->emit('TakeYearMonth',$this->year,$this->month);
    $this->emit('refreshTable');
    $this->emit('gotonext','Val');
  }
  public function Save(){
    if ($this->IsSave) return;
    if (!$this->Name) {
      $this->dispatchBrowserEvent('mmsg','يجب اختيار موظف من الجدول');

      return;
    }
    if (!$this->Val || $this->Val<=0) {
      $this->dispatchBrowserEvent('mmsg','يجب ادخال قيمة صحيحة');
      $this->emit('gotonext','Val');
      return;
    }

      if ($this->IsModify) {
      SalaryTrans::where('id',$this->TransId)->update([
        'Val'=>$this->Val,
        'Notes'=>$this->Notes,
      ]);
        Operations::insert(['Proce'=>'حركة مرتب','Oper'=>'نعديل','no'=>$this->SalId,'created_at'=>Carbon::now(),'emp'=>auth::user()->empno,]);
      }else
        SalaryTrans::insert([

          'SalaryId'=>$this->SalId,
          'TranDate'=>date('Y-m-d'),
          'TranType'=>$this->TranType,
          'Val'=>$this->Val,
          'Notes'=>$this->Notes,
          'Y'=>$this->year,
          'M'=>$this->month,
          'MasCenter'=>Salarys::find($this->SalId)->MasCenter,
        ]);

    $this->IsModify=false;
    $this->Name='';
    $this->Val='';
    $this->Notes='';
    $this->IsSave=true;
    $this->emit('refreshTable');

  }
  public function mount(){
    $this->year=SalaryTrans::max('Y');
    $this->month=SalaryTrans::where('Y',$this->year)->max('M');
  }
    public function render()
    {
        return view('livewire.salary.trans-head',[
          'TransList'=>SalaryTrans::join('SalTranType','SalaryTrans.TranType','=','SalTranType.id')
              ->select('SalaryTrans.id','SalaryTrans.Val','SalaryTrans.TranDate','SalaryTrans.Notes','SalTranType.TypeName')
             ->where('SalaryId',$this->SalId)
            ->where('TranType',$this->TranType)
            ->orderBy('TranDate','desc')
            ->paginate(5)
        ]);
    }
}
