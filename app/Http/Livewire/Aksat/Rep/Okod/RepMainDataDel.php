<?php

namespace App\Http\Livewire\Aksat\Rep\Okod;

use App\Http\Livewire\Admin\Mahjoza;
use App\Models\aksat\chk_tasleem;
use App\Models\aksat\kst_trans;
use App\Models\aksat\kst_trans_deleted;
use App\Models\aksat\main;
use App\Models\aksat\main_deleted;
use App\Models\aksat\main_items;
use App\Models\aksat\main_items_deleted;
use App\Models\aksat\MainArc;
use App\Models\aksat\place;
use App\Models\bank\bank;
use App\Models\excel\MahjozaModel;
use App\Models\jeha\jeha;
use App\Models\Operations;
use App\Models\OverTar\over_kst;
use App\Models\OverTar\stop_kst;
use App\Models\OverTar\tar_kst;
use App\Models\OverTar\tar_kst_before;
use App\Models\sell\sells;
use App\Models\stores\halls_names;
use App\Models\stores\stores_names;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class RepMainDataDel extends Component
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
    public $point_name;
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

    public $mainitems='rep_sell_tran_del';
    public $OverKst=0;
    public $TarKst=0;
    public $ArcMain=0;
    public $ChkTasleem=0;

    public $aksat_tot=0,$aksat_count=0,$sal_date;

    public $HasOver=false;
    public $HasTar=false;
    public $HasChk=false;
    public $HasArc=false;

    public $kst_raseed;

    protected $listeners = [
        'GotoDetail','DoArch','refreshme'=>'$refresh'
    ];

    public function Archive(){

      if ($this->no==0) { $this->dispatchBrowserEvent('mmsg','يجب اختيار العقد ');return;}
      $this->dispatchBrowserEvent('arch');
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
      if ($tel){
       $this->libyana=$tel['libyana'];
       $this->mdar=$tel['mdar'];
       if ($this->libyana==null){$this->libyana='';}
      if ($this->mdar==null){$this->mdar='';}}

      $this->OverKst=over_kst::on(Auth()->user()->company)->where('no',$this->no)->count();
      $this->TarKst=tar_kst::on(Auth()->user()->company)->where('no',$this->no)->count();
      $this->ArcMain=MainArc::on(Auth()->user()->company)->where('jeha',$this->jeha)->count();
      $this->ChkTasleem=chk_tasleem::on(Auth()->user()->company)->where('no',$this->no)->count();

      if ($this->raseed<=0) $this->kst_raseed=0;
      else {
        if ($this->raseed<=$this->kst) $this->kst_raseed=1;
        else {
          $this->kst_raseed=ceil($this->raseed/$this->kst);
        }
      }

    }
  public function CloseArc(){
    $this->dispatchBrowserEvent('CloseArcModal');
  }
  public function OpenArc($no) {
    $this->emitTo('aksat.rep.okod.arc-modal','TakeArcNo',$no);
    $this->dispatchBrowserEvent('OpenArcModal');
  }

  public function Retrieve()
  {

      DB::connection('other')->beginTransaction();
      try {


          $select = main_deleted::where('no',$this->no)->select('no','name','bank','acc','sul_date','sul_type','sul_tot','dofa','sul',
              'kst','kst_count','sul_pay','raseed','order_no','jeha','place','notes','chk_in','chk_out','last_order','ref_no','emp','inp_date','taj_id');
          $bindings = $select->getBindings();
          $insertQuery = 'INSERT into main (no,name,bank,acc,sul_date,sul_type,sul_tot,dofa,sul,kst,kst_count,sul_pay,raseed,order_no,
                                               jeha,place,notes,chk_in,chk_out,last_order,ref_no,emp,inp_date,taj_id) '. $select->toSql();
          DB::connection(Auth()->user()->company)->insert($insertQuery, $bindings);

          $select = kst_trans_deleted::on(Auth()->user()->company)->where('no',$this->no)->select('ser','no','kst_date','ksm_type','chk_no','kst','ksm_date','ksm','h_no','emp','kst_notes','inp_date');
          $bindings = $select->getBindings();
          $insertQuery = 'INSERT into kst_trans (ser,no,kst_date,ksm_type,chk_no,kst,ksm_date,ksm,h_no,emp,kst_notes,inp_date) '. $select->toSql();
          DB::connection(Auth()->user()->company)->insert($insertQuery, $bindings);

          $select = main_items_deleted::where('no',$this->no)->select('no','item_no');
          $bindings = $select->getBindings();
          $insertQuery = 'INSERT into main_items (no,item_no) '. $select->toSql();
          DB::connection(Auth()->user()->company)->insert($insertQuery, $bindings);

          main_items_deleted::where('no',$this->no)->delete();
          kst_trans_deleted::on(Auth()->user()->company)->where('no',$this->no)->delete();
          main_deleted::on(Auth()->user()->company)->where('no',$this->no)->delete();

          Operations::insert(['Proce'=>'عقد','Oper'=>'ارجاع عقد ملغي','no'=>$this->no,'created_at'=>Carbon::now(),'emp'=>auth::user()->empno,]);

          DB::connection(Auth()->user()->company)->commit();
          $this->no=0; $this->orderno='';$this->name='';$this->bankno='';$this->acc='';$this->place='';
          $this->sul='';$this->sul_tot='';$this->dofa='';$this->kst='';
          $this->kstcount='';$this->notes='';$this->ref_no='';$this->chk_in='';
          $this->render();



      } catch (\Exception $e) {
          DB::connection(Auth()->user()->company)->rollback();
          info($e);
          $this->dispatchBrowserEvent('mmsg', 'حدث خطأ');
      }
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



        return view('livewire.aksat.rep.okod.rep-main-data-del',[
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
            ]);
    }
}
