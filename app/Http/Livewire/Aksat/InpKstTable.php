<?php

namespace App\Http\Livewire\Aksat;

use Livewire\Component;

class InpKstTable extends Component
{
  public $post='kst_trans';
  public $post2='rep_sell_tran';
  protected $listeners = [
    'GotoKstDetail',
  ];

   public function GotoKstDetail($no,$worder){
     $this->emit('GetWhereEquelValue',$no);
     $this->emit('GetWhereEquelValue2',$worder);
     $this->emit('kstdetail_goto','ksm_date');

   }
    public function render()
    {
        return view('livewire.aksat.inp-kst-table');
    }
}
