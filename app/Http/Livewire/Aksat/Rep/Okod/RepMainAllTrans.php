<?php

namespace App\Http\Livewire\Aksat\Rep\Okod;

use App\Models\aksat\main;
use Livewire\Component;

class RepMainAllTrans extends Component
{
    public $post='kst_trans';
    public $no;

    protected $listeners = [
        'GotoTrans',
    ];

    public function GotoTrans($no,$mainorarc){
        if ($mainorarc=='قائم')
           $this->post='kst_trans';
        else
            $this->post='TransArc';

        $this->emitTo('tools.my-table','TakeTable',$this->post);
        $this->no=$no;
        $this->emit('GetWhereEquelValue',$no);
    }
    public function render()
    {
        return view('livewire.aksat.rep.okod.rep-main-all-trans');
    }
}
