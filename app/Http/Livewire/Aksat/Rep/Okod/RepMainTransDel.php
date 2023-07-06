<?php

namespace App\Http\Livewire\Aksat\Rep\Okod;

use Livewire\Component;

class RepMainTransDel extends Component
{
    public $post='kst_tran_del_view';
    public $no;

    protected $listeners = [
        'GotoTrans',
    ];

    public function GotoTrans($no){
        $this->no=$no;
        $this->emit('GetWhereEquelValue',$no);
    }
    public function render()
    {
        return view('livewire.aksat.rep.okod.rep-main-trans-del');
    }
}
