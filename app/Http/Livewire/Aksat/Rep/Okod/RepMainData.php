<?php

namespace App\Http\Livewire\Aksat\Rep\Okod;

use App\Http\Livewire\Admin\Mahjoza;
use App\Models\aksat\chk_tasleem;
use App\Models\aksat\kst_trans;
use App\Models\aksat\main;
use App\Models\aksat\MainArc;
use App\Models\aksat\place;
use App\Models\aksat\TransArc;
use App\Models\bank\bank;
use App\Models\excel\MahjozaModel;
use App\Models\jeha\jeha;
use App\Models\OverTar\over_kst;
use App\Models\OverTar\stop_kst;
use App\Models\OverTar\tar_kst;
use App\Models\sell\sells;
use App\Models\stores\halls_names;
use App\Models\stores\stores_names;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class RepMainData extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';
    public $no=0;
    public $ref_no='';
    public $last_tot=0;
    public $acc;
    public $name;
    public $bank;
    public $bank_name;
    public $place;
    public $place_name;
    public $point_name;
    public $order_no;
    public $jeha=0;
    public $sul_tot;
    public $cash;
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
    public $by='';
    public $mainitems='rep_sell_tran';
    public $OverKst=0;
    public $TarKst=0;
    public $ArcMain=0;
    public $ChkTasleem=0;

    public $aksat_tot=0,$aksat_count=0,$sal_date;

    public $HasOver=false;
    public $HasTar=false;
    public $HasChk=false;
    public $HasArc=false;
    public $prevented=false;

    public $IsMosdad=false;
    public $IsStop=false;
    public $TajNo=0;
    public $stop_date;

    public $kst_raseed;

    protected $listeners = [
        'GotoDetail','DoArch','refreshme'=>'$refresh','DoStop'
    ];


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



        $this->emit('GotoTrans',0);
        $this->emit('GetWhereEquelValue2',0);
        $this->HasArc=false;
        $this->HasChk=false;
        $this->HasOver=false;
        $this->HasTar=false;
        $this->IsStop=false;
        $this->IsMosdad=false;
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

        $this->kst_raseed='';

      } catch (\Exception $e) {

        DB::connection(Auth()->user()->company)->rollback();
        $this->dispatchBrowserEvent('mmsg', 'حدث خطأ');
      }


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

      $this->HasArc=false;
      $this->HasChk=false;
      $this->HasOver=false;
      $this->HasTar=false;
      $this->IsStop=false;
      $this->IsMosdad=false;

      $this->no=$res['no'];
      if ($res['last_order'] && $res['last_order']!=0){
        $rec=MainArc::where('order_no',$res['last_order'])->first();

        if ($rec) {
          $ser=TransArc::where('no',$rec->no)->where('ksm','!=',0)->where('kst_notes','!=',null)->max('ser');
          if ($ser) $this->last_tot=TransArc::where('no',$rec->no)->where('ser',$ser)->first()->ksm;
          else $this->last_tot=0;

        }
        else $this->last_tot=0;
      }
      else $this->last_tot=0;

      if ($res['ref_no'])
       $this->ref_no='الإشاري : '.$res['ref_no'];
      else $this->ref_no='';
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
      $this->by=DB::connection(Auth::user()->company)->table('PASS')->where('EMP_NO',$res['emp'])->first()->EMP_NAME;
      $this->bank_name=bank::on(Auth()->user()->company)->find($this->bank)->bank_name;
      $this->place=$res['place'];
      $this->place_name=place::on(Auth()->user()->company)->find($this->place)->place_name;
      $point=sells::where('order_no',$this->order_no)->first();
      if ($point->sell_type==1)
       $this->point_name=stores_names::where('st_no',$point->place_no)->first()->st_name;
      else
       $this->point_name=halls_names::where('hall_no',$point->place_no)->first()->hall_name;
      $this->cash=$point->cash;
      $tel=jeha::on(Auth()->user()->company)->where('jeha_no',$this->jeha)->first();
       $this->libyana=$tel['libyana'];
       $this->mdar=$tel['mdar'];
       if ($this->libyana==null){$this->libyana='';}
      if ($this->mdar==null){$this->mdar='';}

      $this->OverKst=over_kst::on(Auth()->user()->company)->where('no',$this->no)->count();
      $this->TarKst=tar_kst::on(Auth()->user()->company)->where('no',$this->no)->count();
      $this->ArcMain=MainArc::on(Auth()->user()->company)->where('jeha',$this->jeha)->count();
      $this->ChkTasleem=chk_tasleem::on(Auth()->user()->company)->where('no',$this->no)->count();

      $this->prevented=jeha::find($this->jeha)->prevented;

      $this->IsMosdad=$this->raseed==0;
      $this->IsStop=stop_kst::where('no',$this->no)->exists();
      if ($this->IsStop) {
        $this->TajNo=bank::where('bank_no',$this->bank)->first()->bank_tajmeeh;
        $this->stop_date=stop_kst::where('no',$this->no)->first()->stop_date;
      }

      if ($this->raseed<=0) $this->kst_raseed=0;
      else {
        if ($this->raseed<=$this->kst) $this->kst_raseed=1;
        else {
          $this->kst_raseed=ceil($this->raseed/$this->kst);
        }
      }

    }
  public function Stop(){

    $this->dispatchBrowserEvent('stop');
  }
  public function DoStop(){
    stop_kst::on(Auth()->user()->company)->insert([
      'no'=>$this->no,'name'=>$this->name,'bank'=>$this->bank,'acc'=>$this->acc,
      'stop_type'=>1,'stop_date'=>date('Y-m-d'),'letters'=>0,'emp'=>auth::user()->empno,
    ]);
    $this->TajNo=bank::where('bank_no',$this->bank)->first()->bank_tajmeeh;
    $this->stop_date=date('Y-m-d');
    $this->IsStop=True;
  }
  public function CloseArc(){
    $this->dispatchBrowserEvent('CloseArcModal');
  }
  public function OpenArc($no) {
    $this->emitTo('aksat.rep.okod.arc-modal','TakeArcNo',$no);
    $this->dispatchBrowserEvent('OpenArcModal');
  }

    public function render()
    {
        $res=MahjozaModel::where('no',$this->no)->first();
        if ($res){
        $this->aksat_tot=number_format($res->aksat_tot,2, '.', '');
        $this->aksat_count=$res->aksat_count;
        $this->sal_date=$res->sal_date;}
        else {
          $this->aksat_tot=null;
          $this->aksat_count=null;
          $this->sal_date=null;}

        if ($this->prevented) $bg='#ffe5e5'; else $bg='white';

        return view('livewire.aksat.rep.okod.rep-main-data',[
            'TableOver' => DB::connection(Auth()->user()->company)->table('over_kst')
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
                ->paginate(5),
            'bg'=>$bg,
            ]);
    }
}
