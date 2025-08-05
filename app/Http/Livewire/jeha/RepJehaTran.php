<?php

namespace App\Http\Livewire\jeha;

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
    public $sumBefore;
    public $sumAfter;
    public $Raseed;
    protected $listeners = [
        'Take_Search_JehaNo',
    ];

    public function DisModal($data,$order_no){

      if ($data=='مبيعات')
      {
        $this->OpenModalToDis();
        $this->emitTo('sell.rep-order-sell','TakeOrderNo',$order_no);
      }


    }
    public function CloseModalToDis(){
      $this->dispatchBrowserEvent('CloseModalToDis');
    }
  public function OpenModalToDis(){
    $this->dispatchBrowserEvent('OpenModalToDis');
  }

    public function Chkjeha(){
        if ($this->jeha_no !=null ) {
            $this->jeha_name = '';
            $this->jeha_type = 0;
            $res = jeha::on(Auth()->user()->company)->find($this->jeha_no);
            if ($res) {
                if ($res->acc_no==1 && !Auth::user()->can('عميل خاص')) {return('special');}
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
            if ( $this->jeha_type==2 && ! Auth()->user()->can('تقرير الموردين')) {
              $this->dispatchBrowserEvent('mmsg', 'هذا العميل من الموردين');
              return(false);

            }
            if ( $res =='special') {
                $this->dispatchBrowserEvent('mmsg', 'هذا العميل خاص');
                return(false);

            }
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

        $this->sumBefore=collect(DB::connection(Auth()->user()->company)->
        select('Select isnull(sum(mden),0) mden,isnull(sum(daen),0) daen from dbo.frep_jeha_tran (?) as result where order_date<?  '
          ,array($this->jehano,$this->trandate)));
        $this->MdenBefore=$this->sumBefore->first()->mden;
        $this->DaenBefore=$this->sumBefore->first()->daen;

      $this->sumAfter=collect(DB::connection(Auth()->user()->company)->
      select('Select isnull(sum(mden),0) mden,isnull(sum(daen),0) daen from dbo.frep_jeha_tran (?) as result '
        ,array($this->jehano,$this->trandate)));
      $this->Mden=$this->sumAfter->first()->mden;
      $this->Daen=$this->sumAfter->first()->daen;



        $collection = collect(DB::connection(Auth()->user()->company)->
        select('Select * from dbo.frep_jeha_tran (?) as result where order_date>=? order by order_date,order_no '
            ,array($this->jehano,$this->trandate)));

        $data = $this->paginate($collection);








        return view('livewire.jeha.rep-jeha-tran',['RepTable'=> $data,]);

    }
}
