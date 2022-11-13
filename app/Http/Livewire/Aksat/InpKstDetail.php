<?php

namespace App\Http\Livewire\Aksat;

use League\CommonMark\Extension\CommonMark\Parser\Inline\OpenBracketParser;
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
  public $kst;
  public $notes;
  public $ksm_date;
  public $ksm;

  public $OpenKstDetail;

  protected $listeners = [
    'nofound','NoAtUpdate','bankfound','GoResetKstDetail',
  ];
  public function GoResetKstDetail(){
    $this->ResetKstDetail();

  }
  public function nofound($res){
   $this->FillKstDetail($res);
   $this->OpenKstDetail=true;
  }
  public function NoAtUpdate($res){
    $this->FillKstDetail($res);
  }
  public function FillKstDetail($res){
    $this->name=$res['name'];
    $this->sul_tot=$res['sul_tot'];
    $this->dofa=$res['dofa'];
    $this->sul=$res['sul'];
    $this->sul_pay=$res['sul_pay'];
    $this->raseed=$res['raseed'];
    $this->kst_count=$res['kst_count'];
    $this->kst=$res['kst'];
    $this->ksm=$res['kst'];

  }

  public function bankfound(){
   $this->ResetKstDetail();
  }
function ResetKstDetail (){
  $this->name='';
  $this->sul_tot='';
  $this->dofa='';
  $this->sul='';
  $this->sul_pay='';
  $this->raseed='';
  $this->kst_count='';
  $this->kst='';
  $this->ksm='';

  $this->OpenKstDetail=false;

}

function mount(){
    $this->ResetKstDetail();
  $this->ksm_date=date('Y-m-d');

}
    public function render()
    {
        return view('livewire.aksat.inp-kst-detail');
    }
}
