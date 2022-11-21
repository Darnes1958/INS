<?php

namespace App\Http\Livewire\Haf;

use Livewire\Component;

class HafInputDetail extends Component
{
    public $no;
    public $hafitha=0;
    public $bank=0;
    public $acc;
    public $name;
    public $sul_tot;
    public $dofa;
    public $sul;
    public $sul_pay;
    public $raseed;
    public $kst_count;
    public $kst;
    public $notes;
    public $ksm_date;
    public $ksm;

    public $TheNoListIsSelectd;

    protected $listeners = [
        'TakeHafithaDetail',
    ];

    public function TakeHafithaDetail($h,$b){
        $this->hafitha=$h;
        $this->bank=$b;
        $this->emit('bankfound',$this->bank,'');
    }
    public function ChkAccAndGo(){

    }
    public function ChkKsm(){

    }
    public function ChkNoAndG(){

    }
    public function render()
    {
        return view('livewire.haf.haf-input-detail');
    }
}
