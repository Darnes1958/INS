<?php

namespace App\Http\Livewire\Aksat\Rep\Okod;

use App\Models\aksat\kst_tran_view_a;
use Livewire\Component;

class RepMainTransArc extends Component
{
    public $post='transarc';
    public $no;

    protected $listeners = [
        'GotoTrans',
    ];

    public function GotoTrans($no){
        $this->no=$no;

    }
    public function render()
    {
        return view('livewire.aksat.rep.okod.rep-main-trans-arc',[
            'TableList'=>kst_tran_view_a::where('no',$this->no)->orderBy('ser','asc')->paginate(15)]);
    }
}
