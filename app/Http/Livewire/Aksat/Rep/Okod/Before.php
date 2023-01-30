<?php

namespace App\Http\Livewire\Aksat\Rep\Okod;

use App\Models\aksat\main;
use App\Models\bank\bank;
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
  public $month;
  public $Not_pay=false;

  public $search;
  public $RepRadio='RepAll';



  public function updatingSearch()
  {
    $this->resetPage();
  }


  protected $listeners = [
    'TakeBank',
  ];


  public function TakeBank($bank_no){

    $this->bank_no=$bank_no;
    $this->bank_name=bank::on(Auth::user()->company)->find($this->bank_no)->bank_name;
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

          ->when($this->Not_pay,function($q){
            return $q->where([
              ['bank', '=', $this->bank_no],
              ['sul_pay',0],
              ['late', '>', 0],
              ['kst','!=',0],
              ['name', 'like', '%'.$this->search.'%'],]);})
          ->when( ! $this->Not_pay,function ($q) {
            return $q->where([
              ['bank', '=', $this->bank_no],
              ['late', '>', 0],
              ['kst','!=',0],
              ['name', 'like', '%'.$this->search.'%'],]);})
          ->paginate(15)
        ]
      );


    }
}
