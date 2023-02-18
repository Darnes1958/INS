<?php

namespace App\Http\Livewire\Aksat\Rep\Okod;

use App\Models\aksat\chk_tasleem;
use App\Models\aksat\kst_trans;
use App\Models\aksat\main;
use App\Models\aksat\MainArc;
use App\Models\aksat\place;
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

class RepMainAllData extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';
    public $no=0;
    public $acc;
    public $name;
    public $bank;
    public $bank_name;
    public $place;
    public $place_name;
    public $order_no;
    public $jeha=0;
    public $sul_tot;
    public $sul;
    public $sul_date;
    public $sul_pay;
    public $raseed;
    public $kst_count;
    public $kst;
    public $chk_in=0;
    public $chk_out=0;
    public $notes;
    public $libyana='';
    public $mdar='';

    public $mainitems='rep_sell_tran';
    public $OverKst=0;
    public $TarKst=0;
    public $ArcMain=0;
    public $ChkTasleem=0;

    public $HasOver=false;
    public $HasTar=false;
    public $HasChk=false;
    public $HasArc=false;

    public $MainOrArc='قائم';
    public $OverTable='over_kst';

    protected $listeners = [
        'GotoDetail','DoArch','DoRetrieve','refreshme'=>'$refresh'
    ];

    public function Clean(){
        $this->HasArc=false;
        $this->HasChk=false;
        $this->HasOver=false;
        $this->HasTar=false;
        $this->no=0;
        $this->acc='';
        $this->name='';
        $this->order_no='';
        $this->jeha=0;
        $this->sul_tot='';
        $this->sul='';
        $this->sul_date='';
        $this->sul_pay='';
        $this->raseed='';
        $this->kst_count='';
        $this->kst='';
        $this->chk_in='';
        $this->chk_out='';
        $this->notes='';
        $this->bank='';
        $this->place='';
        $this->bank_name='';
        $this->place_name='';

        $tel='';
        $this->libyana='';
        $this->mdar='';

        $this->OverKst='';
        $this->TarKst='';
        $this->ArcMain='';
        $this->ChkTasleem='';
        $this->emit('GotoTrans',0,$this->MainOrArc);
        $this->emit('GetWhereEquelValue2',0);
        $this->emitTo('aksat.rep.okod.rep-main-all-head','RefreachHead');
    }
    public function Archive(){

      if ($this->no==0) { $this->dispatchBrowserEvent('mmsg','يجب اختيار العقد ');return;}
      $this->dispatchBrowserEvent('arch');
    }
    public function DoArch(){

      DB::connection(Auth()->user()->company)->beginTransaction();
      try {
        $select = main::on(Auth()->user()->company)->where('no',$this->no)->select('no','name','bank','acc','sul_date','sul_type','sul_tot','dofa','sul',
          'kst','kst_count','sul_pay','raseed','order_no','jeha','place','notes','chk_in','chk_out','last_order','ref_no','emp','inp_date');
        $bindings = $select->getBindings();
        $insertQuery = 'INSERT into mainarc (no,name,bank,acc,sul_date,sul_type,sul_tot,dofa,sul,kst,kst_count,sul_pay,raseed,order_no,
                                               jeha,place,notes,chk_in,chk_out,last_order,ref_no,emp,inp_date) '. $select->toSql();
        DB::connection(Auth()->user()->company)->insert($insertQuery, $bindings);

        $select = kst_trans::on(Auth()->user()->company)->where('no',$this->no)->select('ser','no','kst_date','ksm_type','chk_no','kst','ksm_date','ksm','h_no','emp','kst_notes','inp_date');
        $bindings = $select->getBindings();
        $insertQuery = 'INSERT into transarc (ser,no,kst_date,ksm_type,chk_no,kst,ksm_date,ksm,h_no,emp,kst_notes,inp_date) '. $select->toSql();
        DB::connection(Auth()->user()->company)->insert($insertQuery, $bindings);

        $select = over_kst::on(Auth()->user()->company)->where('no',$this->no)->select('no','name','bank','acc','kst','tar_type','tar_date','letters','emp','h_no','inp_date');
        $bindings = $select->getBindings();
        $insertQuery = 'INSERT into over_kst_a (no,name,bank,acc,kst,tar_type,tar_date,letters,emp,h_no,inp_date) '. $select->toSql();
        DB::connection(Auth()->user()->company)->insert($insertQuery, $bindings);
        DB::connection(Auth()->user()->company)->table('over_kst')->where('no',$this->no)->delete();
        DB::connection(Auth()->user()->company)->table('kst_trans')->where('no',$this->no)->delete();
        DB::connection(Auth()->user()->company)->table('main')->where('no',$this->no)->delete();
        DB::connection(Auth()->user()->company)->commit();
        $this->Clean();
        $this->resetPage();

      } catch (\Exception $e) {
        DB::connection(Auth()->user()->company)->rollback();
        $this->dispatchBrowserEvent('mmsg', 'حدث خطأ');
      }
    }
    public function Retrieve(){
        $this->dispatchBrowserEvent('retrieve');
    }
    public function DoRetrieve(){
        DB::connection(Auth()->user()->company)->beginTransaction();
        try {
            $select =MainArc::on(Auth()->user()->company)->where('no',$this->no)->select('no','name','bank','acc','sul_date','sul_type','sul_tot','dofa','sul',
                'kst','kst_count','sul_pay','raseed','order_no','jeha','place','notes','chk_in','chk_out','last_order','ref_no','emp','inp_date');
            $bindings = $select->getBindings();
            $insertQuery = 'INSERT into main (no,name,bank,acc,sul_date,sul_type,sul_tot,dofa,sul,kst,kst_count,sul_pay,raseed,order_no,
                                               jeha,place,notes,chk_in,chk_out,last_order,ref_no,emp,inp_date) '. $select->toSql();
            DB::connection(Auth()->user()->company)->insert($insertQuery, $bindings);

            $select = TransArc::on(Auth()->user()->company)->where('no',$this->no)->select('ser','no','kst_date','ksm_type','chk_no','kst','ksm_date','ksm','h_no','emp','kst_notes','inp_date');
            $bindings = $select->getBindings();
            $insertQuery = 'INSERT into kst_trans (ser,no,kst_date,ksm_type,chk_no,kst,ksm_date,ksm,h_no,emp,kst_notes,inp_date) '. $select->toSql();
            DB::connection(Auth()->user()->company)->insert($insertQuery, $bindings);

            $select =over_kst_a::on(Auth()->user()->company)->where('no',$this->no)->select('no','name','bank','acc','kst','tar_type','tar_date','letters','emp','h_no','inp_date');
            $bindings = $select->getBindings();
            $insertQuery = 'INSERT into over_kst (no,name,bank,acc,kst,tar_type,tar_date,letters,emp,h_no,inp_date) '. $select->toSql();
            DB::connection(Auth()->user()->company)->insert($insertQuery, $bindings);

            DB::connection(Auth()->user()->company)->table('over_kst_a')->where('no',$this->no)->delete();
            DB::connection(Auth()->user()->company)->table('TransArc')->where('no',$this->no)->delete();
            DB::connection(Auth()->user()->company)->table('MainArc')->where('no',$this->no)->delete();
            DB::connection(Auth()->user()->company)->commit();
            $this->Clean();
            $this->resetPage();
        } catch (\Exception $e) {
            DB::connection(Auth()->user()->company)->rollback();
            $this->dispatchBrowserEvent('mmsg', 'حدث خطأ');
        }
    }
    public function CloseArc(){
        $this->dispatchBrowserEvent('CloseArcModal');
    }
    public function OpenArc($no) {
        $this->emitTo('aksat.rep.okod.arc-modal','TakeArcNo',$no);
        $this->dispatchBrowserEvent('OpenArcModal');
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
    public function GotoDetail($res,$mainorarc){

      $this->MainOrArc=$mainorarc;
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
      $this->place=$res['place'];
      $this->place_name=place::on(Auth()->user()->company)->find($this->place)->place_name;

      $tel=jeha::on(Auth()->user()->company)->where('jeha_no',$this->jeha)->first();
       $this->libyana=$tel['libyana'];
       $this->mdar=$tel['mdar'];
       if ($this->libyana==null){$this->libyana='';}
      if ($this->mdar==null){$this->mdar='';}

      if ($this->MainOrArc=='قائم') {
       $this->OverTable='over_kst';
       $this->OverKst=over_kst::on(Auth()->user()->company)->where('no',$this->no)->count();}
      else {
          $this->OverTable='over_kst_a';
       $this->OverKst=over_kst_a::on(Auth()->user()->company)->where('no',$this->no)->count();}
      $this->TarKst=tar_kst::on(Auth()->user()->company)->where('no',$this->no)->count();
      $this->ArcMain=MainArc::on(Auth()->user()->company)
          ->where('jeha',$this->jeha)
          ->where('no','!=',$this->no)->count();
      $this->ChkTasleem=chk_tasleem::on(Auth()->user()->company)->where('no',$this->no)->count();

    }


    public function render()
    {


        return view('livewire.aksat.rep.okod.rep-main-all-data',[
            'TableOver' => DB::connection(Auth()->user()->company)->table($this->OverTable)
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
