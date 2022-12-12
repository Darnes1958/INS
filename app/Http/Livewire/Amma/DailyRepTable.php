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
      Config::set('database.connections.other.database', Auth::user()->company);
      return view('livewire.amma.daily-rep-table',[
        'TableList'=>DB::connection('other')->table($this->TableName)
          ->where([
            [$this->InpDate,$this->DateVal],
            [$this->SearchField1, 'like', '%'.$this->search.'%'],
          ])
          ->paginate(15)
      ,'TableName'=>$this->TableName]);
    }
}
