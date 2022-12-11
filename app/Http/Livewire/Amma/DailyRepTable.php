<?php

namespace App\Http\Livewire\Amma;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use function Termwind\render;

class DailyRepTable extends Component
{
  public $TableName;
  public $InpDate;
  public $RepDate;
  public $search;
  public $SearchField1;
  protected $listeners = [
    'TakeDate'
  ];
  public function TakeDate($d){

    $this->RepDate=$d;
    render();
  }

  public function mount($tablename='buys_view',$inpdate='order_date_input',$searachfield1='jeha_name'){
    $this->TableName=$tablename;
    $this->InpDate=$inpdate;
    $this->SearchField1=$searachfield1;
    if (!$this->RepDate) $this->RepDate=date('Y-m-d');
  }
  public function render()
    {
      Config::set('database.connections.other.database', Auth::user()->company);
      return view('livewire.amma.daily-rep-table',[
        'TableList'=>DB::connection('other')->table($this->TableName)
          ->where([
            [$this->InpDate,$this->RepDate],
            [$this->SearchField1, 'like', '%'.$this->search.'%'],
          ])
          ->paginate(15)
      ,'TableName'=>$this->TableName]);
    }
}
