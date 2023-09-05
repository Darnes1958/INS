<?php

namespace App\Http\Livewire\Aksat\Rep\Okod;

use App\Models\aksat\Arc_MainArc;
use App\Models\aksat\chk_tasleem;
use App\Models\aksat\kst_trans;
use App\Models\aksat\main;
use App\Models\aksat\MainArc;
use App\Models\aksat\TransArc;
use App\Models\bank\bank;
use App\Models\jeha\jeha;
use App\Models\OverTar\over_kst;
use App\Models\OverTar\over_kst_a;
use App\Models\OverTar\tar_kst;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class RepMainDataArc2 extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';
    public $no=0;
    public $acc;
    public $name;
    public $bank;
    public $bank_name;
    public $order_no;
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
    public $libyana='';
    public $mdar='';

    public $mainitems='Arc_rep_sell_tran';


    protected $listeners = [
        'GotoDetail'
    ];



    public function GotoDetail($res){
      $this->HasArc=false;
      $this->HasChk=false;
      $this->HasOver=false;
      $this->HasTar=false;
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
      $this->bank=$res['bank'];
      $this->bank_name=bank::on(Auth()->user()->company)->find($this->bank)->bank_name;

    }

    public function render()
    {

        return view('livewire.aksat.rep.okod.rep-main-data-arc2',[
            'TableArc' => DB::connection(Auth()->user()->company)->table('Arc_MainArc')
                ->select('sul_date','no')
                ->where('jeha',$this->jeha)
                ->where('no','!=',$this->no)
                ->paginate(5),
            ]);
    }
}
