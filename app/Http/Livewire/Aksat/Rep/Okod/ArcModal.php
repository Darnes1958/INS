<?php

namespace App\Http\Livewire\Aksat\Rep\Okod;

use App\Models\aksat\chk_tasleem;
use App\Models\aksat\MainArc;
use App\Models\bank\bank;
use App\Models\OverTar\over_kst_a;
use App\Models\OverTar\tar_kst;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ArcModal extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';

  public $no=0;
  public $acc;
  public $name;
  public $bank;
  public $bank_name;
  public $order_no=0;
  public $jeha=0;
  public $sul_tot;
  public $sul;
  public $sul_date;
  public $sul_pay;
  public $raseed;
  public $kst_count;
  public $kst;
  public $chk_in;
  public $chk_out;
  public $notes;


  public $OverKst=0;
  public $TarKst=0;
  public $ArcMain=0;
  public $ChkTasleem=0;

  public $HasOver=false;
  public $HasTar=false;
  public $HasChk=false;
  public $HasArc=false;

  protected $listeners = [
    'TakeArcNo',
  ];
  public function TakeArcNo($no){
    $this->HasArc=false;
    $this->HasChk=false;
    $this->HasOver=false;
    $this->HasTar=false;
    $this->no=$no;
  }
  public function OpenOther($no){
    $this->no=$no;
  }
  public function ShowOver(){
    $this->HasOver=!$this->HasOver;
  }
  public function ShowTar(){
    $this->HasTar=!$this->HasTar;
  }
  public function ShowChk(){
    $this->HasChk=!$this->HasChk;
  }
  public function ShowArc(){
    $this->HasArc=!$this->HasArc;
  }
  public function GotoDetail($res){

    if ($res)
    {$this->no=$res['no'];
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
    $this->notes=$res['notes'];
    $this->bank=$res['bank'];
      $this->bank_name=bank::on(Auth()->user()->company)->find($this->bank)->bank_name;
    }

    $this->OverKst=over_kst_a::on(Auth()->user()->company)->where('no',$this->no)->count();
    $this->TarKst=tar_kst::on(Auth()->user()->company)->where('no',$this->no)->count();
    $this->ArcMain=MainArc::on(Auth()->user()->company)->where('jeha',$this->jeha)->where('no','!=',$this->no)->count();
    $this->ChkTasleem=chk_tasleem::on(Auth()->user()->company)->where('no',$this->no)->count();



  }
    public function render()
    {



      $res=MainArc::on(Auth()->user()->company)->where('no',$this->no)->first();
      $this->GotoDetail($res);
        return view('livewire.aksat.rep.okod.arc-modal',[
          'TableTrans' => DB::connection(Auth()->user()->company)->table('transarc')
            ->select('ser','kst_date','ksm_date','kst','ksm')
            ->where('no',$this->no)
            ->paginate(15),
          'TableItems' => DB::connection(Auth()->user()->company)->table('rep_sell_tran')
            ->select('item_no','item_name','quant','price','sub_tot')
            ->where('order_no',$this->order_no)
            ->paginate(15),
          'TableOver' => DB::connection(Auth()->user()->company)->table('over_kst_a')
            ->select('tar_date','kst')
            ->where('no',$this->no)
            ->paginate(5),
          'TableTar' => DB::connection(Auth()->user()->company)->table('tar_kst')
            ->select('tar_date','kst')
            ->where('no',$this->no)
            ->paginate(5),
          'TableChk' => DB::connection(Auth()->user()->company)->table('chk_tasleem')
            ->select('wdate','chk_count')
            ->where('no',$this->no)
            ->paginate(5),
          'TableArc' => DB::connection(Auth()->user()->company)->table('MainArc')
            ->select('sul_date','no')
            ->where('jeha',$this->jeha)
            ->where('no','!=',$this->no)
            ->paginate(5),

        ]);
    }
}
