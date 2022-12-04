<?php

namespace App\Http\Livewire\Aksat\Rep;

use App\Models\aksat\main;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class RepMainHead extends Component
{
 use WithPagination;
 protected $paginationTheme = 'bootstrap';
 public $no;
 public $acc;
 public $search='';
 public $IsSearch=true;

 public function updatingSearch()
  {
    $this->resetPage();
  }

 public function OpenTable(){
    $this->IsSearch=true;
 }
 public function CloseTable(){
        $this->search='';
        $this->IsSearch=false;
    }
 public function selectItem($no){
   $this->no=$no;
   $this->CloseTable();
   $this->ChkNoAndGo();
 }
 public function ChkNoAndGo(){
    Config::set('database.connections.other.database', Auth::user()->company);
    $this->acc='';
    if ($this->no!=null) {
        $result = main::where('no',$this->no)->first();
        if ($result) {
            $this->acc=$result->acc;
            $this->emit('GotoDetail',$result);
            $this->emit('GotoTrans',$this->no);
            $this->emit('GetWhereEquelValue2',$result->order_no);

        }
    }
 }
    public function render()
    {
        return view('livewire.aksat.rep.rep-main-head',[
            'TableList' => DB::connection('other')->table('main')
                ->select('no','acc', 'name','sul')
                ->where('name', 'like', '%'.$this->search.'%')
                ->orwhere('acc', 'like', '%'.$this->search.'%')
                ->orwhere('no', 'like', '%'.$this->search.'%')
                ->orwhere('sul', 'like', '%'.$this->search.'%')
                ->paginate(5)
    ]);
    }
}
