<?php

namespace App\Http\Livewire\Salary;

use App\Models\masr\MasCenters;
use App\Models\salary\SalaryKsmIdafa_view;
use App\Models\Salary\Salarys;
use App\Models\Salary\SalaryTrans;
use App\Models\Salary\SalaryView;
use Livewire\Component;
use Livewire\WithPagination;

class InpSaheb extends Component
{

  use WithPagination;
  protected $paginationTheme = 'bootstrap';
  public $SalId;
  public $TransId;
  public $Val;
  public $Notes;
  public $IsSave=false;
  public $IsModify=false;
  public $TheSalIdListIsSelected;
  public $CenterName;
  public $Raseed;

  public function updatedTheSalIdListIsSelected(){

    $this->TheSalIdListIsSelected=0;
    $res=SalaryKsmIdafa_view::where('id',$this->SalId)->first();
    if ($res)
    {
     $this->CenterName=$res->CenterName;
     $this->Raseed=$res->Raseed;}
    else
    {
      $this->Raseed=0;
      $this->CenterName=SalaryView::where('id',$this->SalId)->first()->CenterName;
    }

    $this->emitTo('salary.emp-select','TakeSalIdNo',$this->SalId);
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

    $this->Val='';
    $this->Notes='';


  }
  public function Save(){
    if ($this->IsSave) return;
    info('tow : '.$this->SalId);
    if (!$this->SalId) {
      $this->dispatchBrowserEvent('mmsg','يجب اختيار موظف من القائمة');

      return;
    }
    if (!$this->Val || $this->Val<=0) {
      $this->dispatchBrowserEvent('mmsg','يجب ادخال قيمة صحيحة');
      $this->emit('gotonext','Val');
      return;
    }

    if ($this->IsModify)
      SalaryTrans::where('id',$this->TransId)->update([
        'Val'=>$this->Val,
        'Notes'=>$this->Notes,
      ]); else
      SalaryTrans::insert([
        'SalaryId'=>$this->SalId,
        'TranDate'=>date('Y-m-d'),
        'TranType'=>2,
        'Val'=>$this->Val,
        'Notes'=>$this->Notes,
        'Y'=>date('Y'),
        'M'=>date('m'),
        'MasCenter'=>Salarys::find($this->SalId)->MasCenter,
      ]);

    $this->IsModify=false;

    $this->Val='';
    $this->Notes='';


    $this->IsSave=true;


  }
  public function render()
    {

        return view('livewire.salary.inp-saheb',[
          'TransList'=>SalaryTrans::where('SalaryId',$this->SalId)
            ->where('TranType',2)
            ->orderBy('TranDate','desc')
            ->paginate(15)
        ]);
    }
}
