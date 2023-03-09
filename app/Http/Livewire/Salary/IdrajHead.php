<?php

namespace App\Http\Livewire\Salary;

use App\Models\aksat\chk_tasleem;
use App\Models\Salary\Salarys;
use App\Models\Salary\SalaryTrans;
use Livewire\Component;

class IdrajHead extends Component
{
  public $year;
  public $month;
  public $IsSave=false;

  public function updated(){
    $this->IsSave=false;
  }

  public function ChkMonth(){
    if (!$this->month || $this->month<1 || $this->month>12) {
      $this->dispatchBrowserEvent('mmsg','ادخال خطأ');
      return;
    }
    if (SalaryTrans::where('Y',$this->year)->where('M',$this->month)->exists()) {
      $this->dispatchBrowserEvent('mmsg','سبق ادراج مرتب هذا الشهر من السنة');
      return;
    }
    $this->emit('gotonext','save-btn');
  }
  public function Save(){
    if ($this->IsSave) return;
    if (!$this->month || $this->month<1 || $this->month>12) {
      $this->dispatchBrowserEvent('mmsg','ادخال خطأ');
      $this->emit('gotonext','month');
      return;
    }
    if (SalaryTrans::where('Y',$this->year)->where('M',$this->month)->exists()) {
      SalaryTrans::where('Y',$this->year)->where('M',$this->month)->delete();
    }
    $salary=Salarys::where('SalCase',1)->get();
    foreach ($salary as $item) {
      SalaryTrans::insert([

        'SalaryId'=>$item->id,
        'TranDate'=>date('Y-m-d'),
        'TranType'=>1,
        'Val'=>$item->Sal,
        'Notes'=>'مرتب شهر '.$this->month.' لسنه '.$this->year,
        'Y'=>$this->year,
        'M'=>$this->month,
        'MasCenter'=>$item->MasCenter,
      ]);

    }
    $this->IsSave=true;
    $this->dispatchBrowserEvent('mmsg','تم ادراج المرتب');
  }
  public function mount(){
    $this->year=date('Y');
    $this->month=date('m');
  }
    public function render()
    {
        return view('livewire.salary.idraj-head');
    }
}
