<?php

namespace App\Http\Livewire\OverTar;

use App\Models\OverTar\over_kst;
use App\Models\OverTar\over_kst_a;
use App\Models\trans\trans;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class OverTable extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $no=0;
    public $wrec_no;
    public $Proc;

    protected $listeners = [
        'TakeNo','closeandrefresh'
    ];

    public function closeandrefresh(){

      $this->CloseEditDialog();
      $this->render();
    }
    public function TakeNo($no){
        $this->no=$no;
    }
    public function selectItem($wrec_no,$action){
      $this->wrec_no=$wrec_no;
      if ($action=='delete') {$this->dispatchBrowserEvent('OpenMyDelete');}
      if ($action=='update') {$this->emit('ToEditOver',$wrec_no,$this->Proc);$this->dispatchBrowserEvent('OpenMyEdit');}
    }
    public function CloseDeleteDialog(){$this->dispatchBrowserEvent('CloseMyDelete');}
    public function CloseEditDialog(){$this->dispatchBrowserEvent('CloseMyEdit');}

    public function delete(){
      $this->CloseDeleteDialog();

      if ($this->Proc=='over_kst') over_kst::on(Auth()->user()->company)->where('wrec_no',$this->wrec_no)->delete();
      if ($this->Proc=='over_kst_a') over_kst_a::on(Auth()->user()->company)->where('wrec_no',$this->wrec_no)->delete();
      $this->render();
    }

    public function mount($proc='over_kst'){
        $this->Proc=$proc;
    }

    public function render()
    {

     return view('livewire.over-tar.over-table',[
        'TableList'=>DB::connection(Auth()->user()->company)->table($this->Proc)
            ->where('no',$this->no)
            ->where('letters',0)
            ->orderBy('Wrec_no','asc')
            ->paginate(10)
    ]);

    }
}
