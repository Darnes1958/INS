<?php

namespace App\Http\Livewire\Jeha;

use App\Models\jeha\jeha;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class RepMordeen extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';

  public $ZeroShow='yes';
  public $jeha_no=0;
  public $jeha_name='';
  public function selectItem($jeha){
    $this->jeha_no=$jeha;
    $this->jeha_name=jeha::on(Auth()->user()->company)->find($this->jeha_no)->jeha_name;
    $this->resetPage();
  }
    public function render()
    {

        return view('livewire.jeha.rep-mordeen',[
          'RepTable'=>DB::connection(Auth()->user()->company)->table('Mordeen_Master_view')
            ->when($this->ZeroShow!='yes',function ($q) {
              return $q->where('differ','!=', 0) ;     })
            ->paginate(15),
          'Sum'=>DB::connection(Auth()->user()->company)->table('Mordeen_Master_view')
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
