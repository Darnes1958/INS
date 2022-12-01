<?php

namespace App\Http\Livewire\Aksat\Rep;

use Livewire\Component;

class RepMainData extends Component
{
    public $no;
    public $acc;
    public $name;
    public $bank_name;
    public $order_no;
    public $jeha;
    public $sul_tot;
    public $sul;
    public $sul_date;
    public $sul_pay;
    public $raseed;
    public $kst_count;
    public $kst;
    public $chk_in;
    public $chk_out;

    protected $listeners = [
        'GotoDetail',
    ];

    public function GotoDetail($res){
      $this->no=$res['no'];
      $this->acc=$res['acc'];
      $this->name=$res['name'];
      $this->order_no=$res['order_no'];
      $this->jeha=$res['jeha'];
      $this->sul_tot=$res['sul_tot'];
      $this->sul=$res['sul'];
      $this->sul_date=$res['sul_date'];
      $this->sul_pay=$res['sul_pay'];
      $this->raseed=$res['raseed'];
      $this->kst_count=$res['kst_count'];
      $this->kst=$res['kst'];
      $this->chk_in=$res['chk_in'];
      $this->chk_out=$res['chk_out'];

    }
    public function render()
    {
        return view('livewire.aksat.rep.rep-main-data');
    }
}
