<?php

namespace App\Http\Livewire\Stores;

use App\Models\stores\store_exp;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class RepPer extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';
  public $per_no=0;
  public $per_type;
  public $per_type_name;
  public $exp_date;
  public $st_no;
  public $st_name;
  public $place_no;
  public $place_name;
  public $order_no;

  public $ThePerListSelected;

  public function updatedThePerListSelected(){
    $this->ThePerListSelected=0;
    $this->ChkPerNoAndGo();
  }
  public function clearData(){
    $this->exp_date='';
    $this->place_no='';
    $this->place_name='';
    $this->st_no='';
    $this->st_name='';
    $this->per_type_name='';
    $this->order_no='';
  }
  public function ChkPerNoAndGo(){
    if ($this->per_no) {

      $res=DB::connection(Auth()->user()->company)->table('store_exp_view')->where('per_no',$this->per_no)->first();

      if ($res) {
        $this->exp_date=$res->exp_date;
        $this->st_no=$res->st_no;
        $this->st_name=$res->st_name;
        $this->place_no=$res->place_no;
        $this->place_name=$res->place_name;
        $this->order_no=$res->order_no;
        $this->per_type=$res->per_type;
        if ($this->per_type==1){ $this->per_type_name='من مخزن الي مخزن';}
        if ($this->per_type==2){ $this->per_type_name='من مخزن الي صالة';}
        if ($this->per_type==3){ $this->per_type_name='من صال إلي مخزن';}
        if ($this->per_type==4){ $this->per_type_name='من صالة الي صالة';}
      } else {$this->dispatchBrowserEvent('mmsg','هذا الرقم غير مخزون');$this->clearData();}
    }}


      public function render()
    {
        return view('livewire.stores.rep-per',[
          'perdetail'=>DB::connection(Auth()->user()->company)->table('store_exp_view')->where('per_no',$this->per_no)->paginate(15)
        ]);
    }
}
