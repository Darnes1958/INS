<?php

namespace App\Http\Livewire\jeha;

use App\Exports\MordAll;
use App\Exports\MordTran;
use App\Models\jeha\jeha;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class RepMordeen extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';

  public $ZeroShow='yes';
  public $jeha_no=0;
  public $jeha_name='';
  public $Favorite=0;
  public $Special=0;
  public function selectFav($i){
    $this->Favorite=$i;
  }
  public function selectSpc($i){
    $this->Special=$i;
  }

  public function selectItem($jeha,$action){
    if ($action=='favorite'){
      jeha::on(Auth::user()->company)
        ->where('jeha_no',$jeha)
        ->update(['Favorite'=>1]);
    }
    if ($action=='notfavorite'){
      jeha::on(Auth::user()->company)
        ->where('jeha_no',$jeha)
        ->update(['Favorite'=>0]);
    }
    if ($action=='special'){
      jeha::on(Auth::user()->company)
        ->where('jeha_no',$jeha)
        ->update(['acc_no'=>1]);
    }
    if ($action=='notspecial'){
      jeha::on(Auth::user()->company)
        ->where('jeha_no',$jeha)
        ->update(['acc_no'=>0]);
    }
    if ($action=='nothing') {
      $this->jeha_no = $jeha;
      $this->jeha_name = jeha::on(Auth()->user()->company)->find($this->jeha_no)->jeha_name;

    }
  }
    public function toExcl(){
        return Excel::download(new MordTran($this->jeha_no), 'Mordeen.xlsx');
    }
    public function toExclAll(){
        return Excel::download(new MordAll($this->ZeroShow), 'Mordeen.xlsx');
    }
    public function render()
    {

        return view('livewire.jeha.rep-mordeen',[
          'RepTable'=>DB::connection(Auth()->user()->company)->table('Mordeen_Master_view')
            ->where('available',1)
            ->when($this->Favorite==1,function ($q){
              $q->where('Favorite',1);
            })
            ->when($this->Special==1,function ($q){
              $q->where('acc_no',1);
            })

            ->when(!Auth::user()->can('عميل خاص'),function($q){
              $q->where('acc_no','!=',1);
            })
            ->when($this->ZeroShow!='yes',function ($q) {
              return $q->where('differ','!=', 0) ;     })
            ->paginate(15),
          'Sum'=>DB::connection(Auth()->user()->company)->table('Mordeen_Master_view')
            ->where('available',1)
            ->when($this->Favorite==1,function ($q){
              $q->where('Favorite',1);
            })
            ->when($this->Special==1,function ($q){
              $q->where('acc_no',1);
            })

            ->when(!Auth::user()->can('عميل خاص'),function($q){
              $q->where('acc_no','!=',1);
            })
            ->when($this->ZeroShow!='yes',function ($q) {
              return $q->where('differ','!=', 0) ;     })
            ->sum('differ'),

          'RepTable2'=>DB::connection(Auth()->user()->company)->table('MordeenDetailView')
            ->where('jeha',$this->jeha_no)
            ->orderBy('order_date')
            ->paginate(15, ['*'], 'DetailTable'),

        ]);
    }
}
