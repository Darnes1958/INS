<?php

namespace App\Http\Livewire\Amma;

use App\Models\aksat\kst_trans;
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
    public $ByChk=false;
    public $By;
  protected $listeners = [
    'TakeDate','TakeParams','TakeBy'
  ];

  public function TakeParams($tablename,$inpdate,$searachfield1){
    $this->TableName=$tablename;
    $this->InpDate=$inpdate;
    $this->SearchField1=$searachfield1;

  }
  public function TakeDate($d){

    $this->DateVal=$d;

  }
    public function TakeBy($bychk,$by){

        $this->ByChk=$bychk;
        $this->By=$by;

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
            ->join('pass','kst_trans.emp','=','pass.emp_no')
            ->when($this->ByChk,function ($q){
                  $q->where('kst_trans.emp',$this->By);
              })
            ->where('kst_trans.inp_date',$this->DateVal)
            ->where('kst_trans.ksm','!=',0)

            ->select('main.no','main.name','main.acc','kst_trans.ksm','kst_trans.ksm_date', 'bank.bank_name', 'ksm_type.ksm_type_name','pass.emp_name')
            ->paginate(15)
          ,'TableName'=>$this->TableName]);


      return view('livewire.amma.daily-rep-table',[
        'TableList'=>DB::connection(Auth()->user()->company)->table($this->TableName)
          ->join('pass',$this->TableName.'.emp','=','pass.emp_no')
          ->select($this->TableName.'.*','pass.emp_name')
          ->when($this->ByChk,function ($q){
              $q->where([
                  ['emp',$this->By],
                  [$this->InpDate,$this->DateVal],
                  [$this->SearchField1, 'like', '%'.$this->search.'%'],
              ]);
          })
            ->when(!$this->ByChk,function ($q){
                $q->where([

                    [$this->InpDate,$this->DateVal],
                    [$this->SearchField1, 'like', '%'.$this->search.'%'],
                ]);
            })

          ->paginate(15)
      ,'TableName'=>$this->TableName]);
    }
}
