<?php

namespace App\Http\Livewire\Aksat\Rep;

use App\Models\aksat\chk_tasleem;
use App\Models\aksat\MainArc;
use App\Models\OverTar\over_kst;
use App\Models\OverTar\tar_kst;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RepMainData extends Component
{
    public $no=0;
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
    public $notes;

    public $mainitems='rep_sell_tran';
    public $OverKst=0;
    public $TarKst=0;
    public $ArcMain=0;
    public $ChkTasleem=0;

    public $HasOver=false;
    public $HasTar=false;

    protected $listeners = [
        'GotoDetail',
    ];

    public function ShowOver(){
     $this->HasOver=!$this->HasOver;
    }
    public function ShowTar(){
        $this->HasTar=!$this->HasTar;
    }
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
      $this->notes=$res['notes'];

      $this->OverKst=over_kst::where('no',$this->no)->count();
      $this->TarKst=tar_kst::where('no',$this->no)->count();
      $this->ArcMain=MainArc::where('no',$this->no)->count();
      $this->ChkTasleem=chk_tasleem::where('no',$this->no)->count();

    }
    public function render()
    {
        return view('livewire.aksat.rep.rep-main-data',[
            'TableOver' => DB::connection('other')->table('over_kst')
                ->select('tar_date','kst')
                ->where('no',$this->no)
                ->paginate(5),
            'TableTar' => DB::connection('other')->table('tar_kst')
                ->select('tar_date','kst')
                ->where('no',$this->no)
                ->paginate(5)
        ]);
    }
}
