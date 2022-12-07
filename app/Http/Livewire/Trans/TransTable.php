<?php

namespace App\Http\Livewire\Trans;

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
    public function updatingSearch()
    {
        $this->resetPage();
    }
    protected $listeners = [
        'TakeJehaAndType',
    ];

    public function TakeJehaAndType($j,$i){

        $this->jeha=$j;
        $this->imp_exp=$i;
    }
    public function render()
    {
     Config::set('database.connections.other.database', Auth::user()->company);
     return view('livewire.trans.trans-table',[
        'TableList'=>DB::connection('other')->table('trans')
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
            ->orderBy('tran_no','asc')
            ->paginate(15)
    ]);

    }
}
