<?php

namespace App\Http\Livewire\Trans;

use App\Models\trans\trans;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class TransTable extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $jeha=0;
    public $imp_exp=1;
    public $tran_no;
    public function updatingSearch()
    {
        $this->resetPage();
    }
    protected $listeners = [
        'TakeJehaAndType','closeandrefresh'
    ];

    public function closeandrefresh(){
      $this->CloseEditDialog();
      $this->render();
    }
    public function TakeJehaAndType($j,$i){

        $this->jeha=$j;
        $this->imp_exp=$i;
    }
    public function selectItem($tran_no,$action){
      $this->tran_no=$tran_no;
      if ($action=='delete') {$this->dispatchBrowserEvent('OpenMyDelete');}
      if ($action=='update') {$this->emit('ToEditTran',$tran_no);$this->dispatchBrowserEvent('OpenMyEdit');}
    }
    public function CloseDeleteDialog(){$this->dispatchBrowserEvent('CloseMyDelete');}
    public function CloseEditDialog(){$this->dispatchBrowserEvent('CloseMyEdit');}

    public function delete(){
      $this->CloseDeleteDialog();
      trans::on(Auth()->user()->company)->where('tran_no',$this->edittran_no)->delete();
      $this->render();
    }



    public function render()
    {

     return view('livewire.trans.trans-table',[
        'TableList'=>DB::connection(Auth()->user()->company)->table('trans')
            ->where([
                ['jeha',$this->jeha],
                ['imp_exp',$this->imp_exp],
                ['tran_date', 'like', '%'.$this->search.'%'],
                ])
            ->orwhere([
                ['jeha',$this->jeha],
                ['imp_exp',$this->imp_exp],
                ['notes', 'like', '%'.$this->search.'%'],
               ])
            ->orwhere([
                ['jeha',$this->jeha],
                ['imp_exp',$this->imp_exp],
                ['val', 'like', '%'.$this->search.'%'],
            ])
            ->orderBy('tran_no','desc')
            ->paginate(15)
    ]);

    }
}
