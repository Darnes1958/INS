<?php

namespace App\Http\Livewire\Aksat\Rep\Okod;

use App\Models\aksat\main;
use App\Models\bank\bank;
use App\Models\bank\BankTajmeehy;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class Before extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';
  public $bank_no=0;
  public $bank_name;
  public $TajNo=0;
  public $TajName;
  public $month;
  public $Not_pay=false;
  public $ByTajmeehy='Bank';

  public $search;
  public $RepRadio='RepAll';

  public $orderColumn = "no";
  public $sortOrder = "asc";
  public $sortLink = '<i class="sorticon fas fa-angle-up"></i>';

  public function sortOrder($columnName=""){
    $caretOrder = "up";
    if($this->sortOrder == 'asc'){
      $this->sortOrder = 'desc';
      $caretOrder = "down";
    }else{
      $this->sortOrder = 'asc';
      $caretOrder = "up";
    }
    $this->sortLink = '<i class="sorticon fas fa-angle-'.$caretOrder.'"></i>';

    $this->orderColumn = $columnName;

  }

  public function updatingSearch()
  {
    $this->resetPage();
  }


  protected $listeners = [
    'TakeBank','TakeTajNo',
  ];


  public function TakeBank($bank_no){

    $this->bank_no=$bank_no;
    $this->bank_name=bank::on(Auth::user()->company)->find($this->bank_no)->bank_name;
    $this->resetPage();

  }
  public function TakeTajNo($tajno){

    $this->TajNo=$tajno;
    $this->TajName=BankTajmeehy::on(Auth::user()->company)->find($this->TajNo)->TajName;
    info($this->TajNo);
    $this->resetPage();

  }

    public function render()
    {

      $res=DB::connection(Auth()->user()->company)->table('settings')->where('no',3)->first();
      $DAY_OF_KSM=$res->s1;
      $day=Carbon::now()->day;
      $month=Carbon::now()->month;
      $year=Carbon::now()->year;

      $this->month=$month.'\\'.$year;


      if ($day<$DAY_OF_KSM) {
        $myDate = '28/'.$month.'/'.$year;
        $date = Carbon::createFromFormat('d/m/Y', $myDate)->format('Y-m-d');
      } else $date=date('Y-m-d');
      DB::connection(Auth()->user()->company)->table('late')->delete();
      if ($this->ByTajmeehy=='Taj')
      DB::connection(Auth()->user()->company)->statement( 'insert into late select main.no,count(*) late,:emp
                            from main,kst_trans where main.no=kst_trans.no and bank in (select bank_no from bank where bank_tajmeeh=:Taj) and (ksm=0 or ksm is null) 
                                  and kst_date<=:wdate                
                                  group by main.no  ',
                            array('Taj'=> $this->TajNo,'emp'=>Auth::user()->empno,'wdate'=>$date ));
      else
        DB::connection(Auth()->user()->company)->statement( 'insert into late select main.no,count(*) late,:emp
                            from main,kst_trans where main.no=kst_trans.no and bank=:bank and (ksm=0 or ksm is null) 
                                  and kst_date<=:wdate                
                                  group by main.no  ',
          array('bank'=> $this->bank_no,'emp'=>Auth::user()->empno,'wdate'=>$date ));


      return view('livewire.aksat.rep.okod.before',[
        'RepTable'=>DB::connection(Auth()->user()->company)->table('main')
          ->join('late','main.no','=','late.no')
          ->selectRaw('acc,name,sul_date,sul,kst_count,sul_pay,raseed,main.kst,main.no,round((sul_pay/kst),0) pay_count,late,
                               late*main.kst kst_late')
          ->when($this->ByTajmeehy=='Bank',function ($q){
            return $q->where('bank',$this->bank_no);
          })
          ->when($this->ByTajmeehy=='Taj',function ($q){
           return $q->whereIn('bank', function($q){
             $q->select('bank_no')->from('bank')->where('bank_tajmeeh',$this->TajNo);});
          })

          ->when($this->Not_pay,function($q){
            return $q->where([

              ['sul_pay',0],
              ['late', '>', 0],
              ['kst','!=',0],
              ['name', 'like', '%'.$this->search.'%'],]);})
          ->when( ! $this->Not_pay,function ($q) {
            return $q->where([

              ['late', '>', 0],
              ['kst','!=',0],
              ['name', 'like', '%'.$this->search.'%'],]);})
          ->orderby($this->orderColumn,$this->sortOrder)
          ->paginate(15)
        ]
      );


    }
}
