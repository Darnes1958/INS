<?php

namespace App\Http\Livewire\Aksat\Rep\Okod;

use App\Models\aksat\kst_tran_view;
use App\Models\aksat\kst_trans;
use Livewire\Component;
use Livewire\WithPagination;

class RepMainTrans extends Component
{
   use WithPagination;
    public $post='kst_tran_view';
    public $no;

    protected $listeners = [
        'GotoTrans',
    ];

    public function GotoTrans($no){
        $this->no=$no;

    }
    public function render()
    {
        return view('livewire.aksat.rep.okod.rep-main-trans',[
          'TableList'=>kst_tran_view::join('PASS','emp','EMP_NO')
            ->select('kst_tran_view.*','EMP_NAME')
            ->where('no',$this->no)->orderBy('ser','asc')->paginate(15)]);
    }
}
