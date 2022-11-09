<?php

namespace App\Http\Livewire\Aksat;

use Livewire\Component;

class InpKstDetail extends Component
{
  public $name;
  public $sul_tot;
  public $dofa;
  public $sul;
  public $sul_pay;
  public $raseed;
  public $kst_count;
  public $kstfromtable;
  public $notes;
  public $ksm_date;
  public $kst;

  protected $listeners = [
    'nofound',
  ];
  public function nofound($res){

   $this->name=$res['name'];
   $this->sul_tot=$res['sul_tot'];
   $this->dofa=$res['dofa'];
   $this->sul=$res['sul'];
   $this->sul_pay=$res['sul_pay'];
   $this->raseed=$res['raseed'];
   $this->kst_count=$res['kst_count'];
   $this->kstfromtable=$res['kst'];
   $this->kst=$res['kst'];
  }

    public function render()
    {
        return view('livewire.aksat.inp-kst-detail');
    }
}
