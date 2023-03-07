<?php

namespace App\Http\Livewire\Salary;

use App\Models\aksat\chk_tasleem;
use App\Models\Salary\Salarys;
use App\Models\Salary\SalaryTrans;
use Faker\Guesser\Name;
use Livewire\Component;

class TransHead extends Component
{
  public $year;
  public $month;
  public $TranType=3;
  public $SalId;
  public $Name;
  public $Sal;
  public $Val;
  public $Notes;
  public $IsSave=false;

  protected $listeners = [
     'TakeSalId'
  ];

  public function TakeSalId($salid,$sal,$name){
    $this->SalId=$salid;
    $this->Name=$name;
    $this->Sal=$sal;

  }
  public function updated(){
    $this->IsSave=false;
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


      SalaryTrans::insert([

        'SalaryId'=>$this->SalId,
        'TranDate'=>date('Y-m-d'),
        'TranType'=>$this->TranType,
        'Val'=>$this->Val,
        'Notes'=>$this->Notes,
        'Y'=>$this->year,
        'M'=>$this->month,
        'MasNo'=>0,
      ]);

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
        return view('livewire.salary.trans-head');
    }
}
