<?php

namespace App\Http\Livewire\OverTar;

use App\Models\Operations;
use App\Models\OverTar\wrong_Kst;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class WrongTable extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';
 public $wrong_no;
 public $bank_no=0;
  public $search;
  public function updatingSearch()
  {
    $this->resetPage();
  }

 protected $listeners =['TakeBank','closeandrefresh'];
 public function TakeBank($bank){
   $this->bank_no=$bank;
 }
  public function closeandrefresh(){

    $this->CloseEditDialog();
    $this->render();
  }
  public function selectItem($wrong_no,$action){
    $this->wrong_no=$wrong_no;
    if ($action=='delete') {$this->dispatchBrowserEvent('OpenMyDelete');}
    if ($action=='update') {$this->emit('ToEditWrong',$wrong_no);$this->dispatchBrowserEvent('OpenMyEdit');}
  }
  public function CloseDeleteDialog(){$this->dispatchBrowserEvent('CloseMyDelete');}
  public function CloseEditDialog(){$this->dispatchBrowserEvent('CloseMyEdit');}

  public function delete(){
    $this->CloseDeleteDialog();
    wrong_Kst::on(Auth()->user()->company)->where('wrong_no',$this->wrong_no)->delete();
    Operations::insert(['Proce'=>'بالخطأ','Oper'=>'الغاء','no'=>0,'created_at'=>Carbon::now(),'emp'=>auth::user()->empno,]);
    $this->render();
  }
    public function render()
    {

        return view('livewire.over-tar.wrong-table',['TableList'=>DB::connection(Auth()->user()->company)->table('wrong_view')
          ->where([
            ['bank',$this->bank_no],
            ['name', 'like', '%'.$this->search.'%'],
          ])
          ->orwhere([
            ['bank',$this->bank_no],
            ['acc', 'like', '%'.$this->search.'%'],
          ])
          ->orwhere([
            ['bank',$this->bank_no],
            ['tar_date', 'like', '%'.$this->search.'%'],
          ])
      ->paginate(15)
    ]);
    }
}
