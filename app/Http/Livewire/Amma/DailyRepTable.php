<?php

namespace App\Http\Livewire\Amma;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class DailyRepTable extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
  public $TableName;
  public $InpDate;
  public $search;
  public $SearchField1;
  public $DateVal;
  protected $listeners = [
    'TakeDate','TakeParams'
  ];

  public function TakeParams($tablename,$inpdate,$searachfield1){
    $this->TableName=$tablename;
    $this->InpDate=$inpdate;
    $this->SearchField1=$searachfield1;

  }
  public function TakeDate($d){

    $this->DateVal=$d;

  }

  public function mount($tablename='buys_view',$inpdate='order_date_input',$searachfield1='jeha_name'){
    $this->TableName=$tablename;
    $this->InpDate=$inpdate;
    $this->SearchField1=$searachfield1;
    if (!$this->DateVal) $this->DateVal=date('Y-m-d');
  }
  public function render()
    {

      if ($this->TableName=='Aksat')
        return view('livewire.amma.daily-rep-table',[
          'TableList'=>DB::connection(Auth()->user()->company)->table('main')
            ->join('kst_trans', 'main.no', '=', 'kst_trans.no')
            ->join('bank', 'main.bank', '=', 'bank.bank_no')
            ->join('ksm_type', 'kst_trans.ksm_type', '=', 'ksm_type.ksm_type_no')
            ->where('kst_trans.inp_date',$this->DateVal)
            ->select('main.no','main.name','main.acc','kst_trans.ksm','kst_trans.ksm_date', 'bank.bank_name', 'ksm_type.ksm_type_name')
            ->paginate(15)
          ,'TableName'=>$this->TableName]);


      return view('livewire.amma.daily-rep-table',[
        'TableList'=>DB::connection(Auth()->user()->company)->table($this->TableName)
          ->where([
            [$this->InpDate,$this->DateVal],
            [$this->SearchField1, 'like', '%'.$this->search.'%'],
          ])
          ->paginate(15)
      ,'TableName'=>$this->TableName]);
    }
}
