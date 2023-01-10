<?php

namespace App\Http\Livewire\Jeha;

use App\Models\aksat\main;
use App\Models\aksat\MainArc;
use App\Models\buy\buys;
use App\Models\jeha\jeha;
use App\Models\sell\sells;
use App\Models\trans\trans;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Illuminate\Pagination\LengthAwarePaginator;

use Livewire\WithPagination;

class RepJehaTran extends Component
{
    use WithPagination;


    public $jeha_no;
    public $jeha_type;
    public $jeha_name;
    public $tran_date;

    public $jehano=0;
    public $trandate;

    public $MdenBefore;
    public $DaenBefore;
    public $Mden;
    public $Daen;
    public $Raseed;
    protected $listeners = [
        'Take_Search_JehaNo',
    ];

    public function Chkjeha(){
        if ($this->jeha_no !=null ) {

            $this->jeha_name = '';
            $this->jeha_type = 0;
            $conn=Auth()->user()->company;
            $res = jeha::on(Auth()->user()->company)->find($this->jeha_no);
            if ($res) {
                $this->jeha_name = $res->jeha_name;
                $this->jeha_type = $res->jeha_type;
                if ($res->jeha_no==1) {return('amaa');}
                if ($res->jeha_type==2) {return('supp');}

                return ('ok');
            } else {
                $this->dispatchBrowserEvent('mmsg', 'هذا الرقم غير مخزون ؟');
                return ('not');
            }
        } else {return ('empty');}
    }
    public function JehaKeyDown(){
        $this->validate();
        $res=$this->Chkjeha();
        if ($res !='empty' && $res!='not')  {
            $this->jehano=$this->jeha_no;
            $this->emit('gotonext','tran_date');

        }

    }
    public function DateKeyDown(){

     $this->validate();
     $this->trandate=$this->tran_date;


    }
    protected function rules()
    {
        Config::set('database.connections.other.database', Auth::user()->company);

        return [

            'jeha_no' =>['required','integer','gt:0', 'exists:other.jeha,jeha_no'],
            'tran_date' => ['required','date'],


        ];
    }
    protected $messages = [
        'exists' => 'هذا الرقم غير مخزون',
        'required' => 'لا يجوز ترك فراغ',

        'tran_date.required'=>'يجب ادخال تاريخ صحيح',
    ];
    public function Take_Search_JehaNo($jeha_no){
        $this->jeha_no=$jeha_no;
        $this->JehaKeyDown();
    }
    public function OpenJehaSerachModal(){
        $this->dispatchBrowserEvent('OpenjehaModal');
    }
    public function CloseJehaSerachModal(){
        $this->dispatchBrowserEvent('ClosejehaModal');
    }
    public function mount(){

        $date = Carbon::now()->subYear();

        $this->tran_date = $date->copy()->startOfYear();
        $this->tran_date=$this->tran_date->ToDateString();
        $this->trandate=$this->tran_date;

    }
    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
    public function render()
    {
        $page = 1;
        $paginate = 15;


        $collection = collect(DB::connection(Auth()->user()->company)->
        select('Select * from dbo.frep_jeha_tran (?) as result where order_date>=? order by order_date,order_no '
            ,array($this->jehano,$this->trandate)));

        $data = $this->paginate($collection);

        $this->MdenBefore=sells::on(Auth()->user()->company)->where('order_date','<',$this->trandate)
          ->where('jeha',$this->jehano)->sum('tot');
        $this->MdenBefore+=trans::on(Auth()->user()->company)->where('tran_date','<',$this->trandate)
          ->where('jeha',$this->jehano)->where('imp_exp',2)->sum('val');

        $this->DaenBefore=buys::on(Auth()->user()->company)->where('order_date','<',$this->trandate)
          ->where('jeha',$this->jehano)->sum('tot');
        $this->DaenBefore+=trans::on(Auth()->user()->company)->where('tran_date','<',$this->trandate)
          ->where('jeha',$this->jehano)->where('imp_exp',1)->sum('val');
        $this->DaenBefore+=main::on(Auth()->user()->company)
          ->join('kst_trans','main.no','kst_trans.no')
          ->where('ksm_date','<',$this->trandate)
          ->where('jeha',$this->jehano)
          ->where('ksm','!=',0)
          ->sum('ksm');
        $this->DaenBefore+=MainArc::on(Auth()->user()->company)
          ->join('transarc','MainArc.no','TransArc.no')
          ->where('ksm_date','<',$this->trandate)
          ->where('jeha',$this->jehano)
          ->where('ksm','!=',0)
          ->sum('ksm');
        $this->Daen+=main::on(Auth()->user()->company)
          ->join('over_kst','main.no','over_kst.no')
          ->where('tar_date','<',$this->trandate)
          ->where('jeha',$this->jehano)
          ->sum('over_kst.kst');
        $this->Daen+=MainArc::on(Auth()->user()->company)
          ->join('over_kst_a','MainArc.no','over_kst_a.no')
          ->where('tar_date','<',$this->trandate)
          ->where('jeha',$this->jehano)
          ->sum('over_kst_a.kst');
        $this->Mden+=main::on(Auth()->user()->company)
          ->join('tar_kst','main.no','tar_kst.no')
          ->where('tar_date','<',$this->trandate)
          ->where('jeha',$this->jehano)
          ->sum('tar_kst.kst');
        $this->Mden+=MainArc::on(Auth()->user()->company)
          ->join('tar_kst','MainArc.no','tar_kst.no')
          ->where('tar_date','<',$this->trandate)
          ->where('jeha',$this->jehano)
          ->sum('tar_kst.kst');


      $this->Mden=sells::on(Auth()->user()->company)->where('jeha',$this->jehano)->sum('tot');
      $this->Mden+=trans::on(Auth()->user()->company)->where('jeha',$this->jehano)->where('imp_exp',2)->sum('val');

      $this->Daen=buys::on(Auth()->user()->company)->where('jeha',$this->jehano)->sum('tot');
      $this->Daen+=trans::on(Auth()->user()->company)->where('jeha',$this->jehano)->where('imp_exp',1)->sum('val');
      $this->Daen+=main::on(Auth()->user()->company)
        ->join('kst_trans','main.no','kst_trans.no')
        ->where('jeha',$this->jehano)
        ->where('ksm','!=',0)
        ->sum('ksm');
      $this->Daen+=MainArc::on(Auth()->user()->company)
        ->join('transarc','MainArc.no','TransArc.no')
        ->where('jeha',$this->jehano)
        ->where('ksm','!=',0)
        ->sum('ksm');

      $this->Daen+=main::on(Auth()->user()->company)
        ->join('over_kst','main.no','over_kst.no')
        ->where('jeha',$this->jehano)
        ->sum('over_kst.kst');
      $this->Daen+=MainArc::on(Auth()->user()->company)
        ->join('over_kst_a','MainArc.no','over_kst_a.no')
        ->where('jeha',$this->jehano)
        ->sum('over_kst_a.kst');
      $this->Mden+=main::on(Auth()->user()->company)
        ->join('tar_kst','main.no','tar_kst.no')
        ->where('jeha',$this->jehano)
        ->sum('tar_kst.kst');
      $this->Mden+=MainArc::on(Auth()->user()->company)
        ->join('tar_kst','MainArc.no','tar_kst.no')
        ->where('jeha',$this->jehano)
        ->sum('tar_kst.kst');


        return view('livewire.jeha.rep-jeha-tran',['RepTable'=> $data]);

    }
}
