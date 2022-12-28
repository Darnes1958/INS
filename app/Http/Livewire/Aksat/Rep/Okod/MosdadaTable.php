<?php

namespace App\Http\Livewire\Aksat\Rep\Okod;

use App\Models\aksat\kst_trans;
use App\Models\OverTar\over_kst;
use App\Models\aksat\main;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class MosdadaTable extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';
  public $bank_no=0;
  public $search;
  public $baky=0;
  public $mychecked=[];
  public $ArcProgress=0;
  public $ArcCount=0;
  public $ShowTar=false;
  public $CheckAll=false;
  public $UncheckAll=false;
  public function updatingSearch()
  {
    $this->resetPage();
  }

  protected $listeners = [
    'TakeBank',
  ];

  public function DoCheckAll(){

    $this->CheckAll=true;
  }
  public function TakeBank($bank_no){
    $this->bank_no=$bank_no;


    $this->ShowTar=main::on(Auth()->user()->company)->where('bank',$bank_no)->where('raseed','<=',0)->count()>0;

  }
  public function ArcTarheel()
   {
     $this->ArcCount=count($this->mychecked);
     $this->ArcProgress=0;
    foreach ($this->mychecked as $key=>$value)
      { if ($value==1) {

        DB::connection(Auth()->user()->company)->beginTransaction();
        try {
          $select = main::on(Auth()->user()->company)->where('no',$key)->select('no','name','bank','acc','sul_date','sul_type','sul_tot','dofa','sul',
            'kst','kst_count','sul_pay','raseed','order_no','jeha','place','notes','chk_in','chk_out','last_order','ref_no','emp','inp_date');
          $bindings = $select->getBindings();
          $insertQuery = 'INSERT into mainarc (no,name,bank,acc,sul_date,sul_type,sul_tot,dofa,sul,kst,kst_count,sul_pay,raseed,order_no,
                                               jeha,place,notes,chk_in,chk_out,last_order,ref_no,emp,inp_date) '. $select->toSql();
          DB::connection(Auth()->user()->company)->insert($insertQuery, $bindings);

          $select = kst_trans::on(Auth()->user()->company)->where('no',$key)->select('ser','no','kst_date','ksm_type','chk_no','kst','ksm_date','ksm','h_no','emp','kst_notes','inp_date');
          $bindings = $select->getBindings();
          $insertQuery = 'INSERT into transarc (ser,no,kst_date,ksm_type,chk_no,kst,ksm_date,ksm,h_no,emp,kst_notes,inp_date) '. $select->toSql();
          DB::connection(Auth()->user()->company)->insert($insertQuery, $bindings);

          $select = over_kst::on(Auth()->user()->company)->where('no',$key)->select('no','name','bank','acc','kst','tar_type','tar_date','letters','emp','h_no','inp_date');
          $bindings = $select->getBindings();
          $insertQuery = 'INSERT into over_kst_a (no,name,bank,acc,kst,tar_type,tar_date,letters,emp,h_no,inp_date) '. $select->toSql();
          DB::connection(Auth()->user()->company)->insert($insertQuery, $bindings);

          DB::connection(Auth()->user()->company)->table('over_kst')->where('no',$key)->delete();
          DB::connection(Auth()->user()->company)->table('kst_trans')->where('no',$key)->delete();
          DB::connection(Auth()->user()->company)->table('main')->where('no',$key)->delete();
          DB::connection(Auth()->user()->company)->commit();
          $this->ArcProgress++;


        } catch (\Exception $e) {
          info($e);
          DB::connection(Auth()->user()->company)->rollback();
          $this->dispatchBrowserEvent('mmsg', 'حدث خطأ');
        }
        $this->mychecked=[];
        $this->ArcProgress=0;
        $this->ArcCount=0;

      }
    }
   }
  function mount(){


  }

    public function render()
    {

      return view('livewire.aksat.rep.okod.mosdada-table',[
          'RepTable'=>DB::connection(Auth()->user()->company)->table('main_view')
              ->where([
              ['bank', '=', $this->bank_no],
              ['raseed','<=',$this->baky],
              ['name', 'like', '%'.$this->search.'%'],])
              ->orwhere([
                ['bank', '=', $this->bank_no],
                ['raseed','<=',$this->baky],
                ['acc', 'like', '%'.$this->search.'%'],])
            ->paginate(15)
        ]);
    }
}
