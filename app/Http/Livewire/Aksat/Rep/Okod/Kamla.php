<?php

namespace App\Http\Livewire\Aksat\Rep\Okod;

use App\Models\aksat\main;
use App\Models\bank\bank;
use App\Models\bank\BankTajmeehy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class Kamla extends Component
{
  use WithPagination;
  public $ByTajmeehy='Bank';
  protected $paginationTheme = 'bootstrap';
  public $bank_no=0;
  public $TajNo=0;
  public $bank_name='';
  public $months=5;
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
    public function updatingMonths()
    {
        $this->resetPage();
    }

  protected $listeners = [
    'TakeBank','TakeTajNo'
  ];


  public function TakeBank($bank_no){

    $this->bank_no=$bank_no;
    $this->bank_name=bank::on(Auth::user()->company)->find($this->bank_no)->bank_name;
      $this->resetPage();

  }
    public function TakeTajNo($tajno){

        $this->TajNo=$tajno;
        $this->bank_name=BankTajmeehy::on(Auth::user()->company)->find($this->TajNo)->TajName;
        $this->resetPage();

    }

  public function paginate($items, $perPage = 15, $page = null, $options = [])
  {
    $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
    $items = $items instanceof Collection ? $items : Collection::make($items);
    return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
  }
    public function render()
    {

      DB::connection(Auth()->user()->company)->table('late')->delete();
      if ($this->ByTajmeehy=='Bank')
      DB::connection(Auth()->user()->company)->statement( 'insert into late select main.no,DATEDIFF(month,max(ksm_date),getdate()),:emp
                            from main,kst_trans where main.no=kst_trans.no and (SUL_PAY)<(SUL-1) and main.no<>0 and sul_pay<>0
                            and bank=:bank group by main.no having DATEDIFF(month,max(ksm_date),getdate())>=:months ',
                            array('bank'=> $this->bank_no,'emp'=>Auth::user()->empno,'months'=>$this->months ));
      if ($this->ByTajmeehy=='Taj')
        DB::connection(Auth()->user()->company)->statement( 'insert into late select main.no,DATEDIFF(month,max(ksm_date),getdate()),:emp
                        from main,kst_trans where main.no=kst_trans.no and (SUL_PAY)<(SUL-1) and main.no<>0 and sul_pay<>0
                        and bank in (select bank_no from bank where bank_tajmeeh=:taj)
                        group by main.no having DATEDIFF(month,max(ksm_date),getdate())>=:months ',
            array('taj'=> $this->TajNo,'emp'=>Auth::user()->empno,'months'=>$this->months ));

      if ($this->ByTajmeehy=='Bank')
      DB::connection(Auth()->user()->company)->statement('insert into late select main.no,DATEDIFF(month,sul_date,getdate()),:emp from main
                            where  sul_pay=0 and  main.no<>0 and DATEDIFF(month,sul_date,getdate())>=:months and bank=:bank ',
                            array('bank'=> $this->bank_no,'emp'=>Auth::user()->empno,'months'=>$this->months ));

      if ($this->ByTajmeehy=='Taj')
            DB::connection(Auth()->user()->company)->statement('insert into late select main.no,DATEDIFF(month,sul_date,getdate()),:emp from main
                    where  sul_pay=0 and  main.no<>0 and DATEDIFF(month,sul_date,getdate())>=:months
                    and bank in (select bank_no from bank where bank_tajmeeh=:taj) ',
                    array('taj'=> $this->TajNo,'emp'=>Auth::user()->empno,'months'=>$this->months ));

      if ($this->RepRadio=='RepAll') {
          $page = 1;
          $paginate = 15;
          $first=DB::connection(Auth()->user()->company)->table('main_trans_view2')
            ->selectRaw('no,name,sul_date,sul,sul_pay,raseed,kst,bank_name,acc,order_no,max(ksm_date) as ksm_date')
            ->when($this->ByTajmeehy=='Bank',function($q){
              $q->where('bank', '=', $this->bank_no);
            })
            ->when($this->ByTajmeehy=='Taj',function($q){
              $q-> whereIn('bank', function($q){
                    $q->select('bank_no')->from('bank')->where('bank_tajmeeh',$this->TajNo);});
            })
            ->where([
               ['sul_pay','!=',0],
               ['name', 'like', '%'.$this->search.'%'],])

            ->whereExists(function ($query) {
              $query->select(DB::raw(1))
                ->from('late')
                ->whereColumn('main_trans_view2.no', 'late.no')
                ->where('emp',Auth::user()->empno);
            })
            ->groupBy('no','name','sul_date','sul','sul_pay','raseed','kst','bank_name','acc','order_no');
          $second=DB::connection(Auth()->user()->company)->table('main_view')
            ->selectraw('no,name,sul_date,sul,sul_pay,raseed,kst,bank_name,acc,order_no,null as ksm_date')
              ->when($this->ByTajmeehy=='Bank',function($q){
                  $q->where('bank', '=', $this->bank_no);
              })
              ->when($this->ByTajmeehy=='Taj',function($q){
                  $q-> whereIn('bank', function($q){
                      $q->select('bank_no')->from('bank')->where('bank_tajmeeh',$this->TajNo);});
              })

              ->where([
              ['sul_pay',0],
              ['name', 'like', '%'.$this->search.'%'],])

            ->whereExists(function ($query) {
              $query->select(DB::raw(1))
                ->from('late')
                ->whereColumn('main_view.no', 'late.no')
                ->where('emp',Auth::user()->empno);
            })
            ->union($first)
            ->orderby($this->orderColumn,$this->sortOrder)
            ->get();
           $data = $this->paginate($second);
          return view('livewire.aksat.rep.okod.kamla',[
            'RepTable'=>$data
         ]);}
      if ($this->RepRadio=='RepSome'){
        return view('livewire.aksat.rep.okod.kamla',[
          'RepTable'=>DB::connection(Auth()->user()->company)->table('main_view')
            ->selectraw('no,name,sul_date,sul,sul_pay,raseed,kst,bank_name,acc,order_no,null as ksm_date')
              ->when($this->ByTajmeehy=='Bank',function($q){
                  $q->where('bank', '=', $this->bank_no);
              })
              ->when($this->ByTajmeehy=='Taj',function($q){
                  $q-> whereIn('bank', function($q){
                      $q->select('bank_no')->from('bank')->where('bank_tajmeeh',$this->TajNo);});
              })
              ->where([
              ['sul_pay',0],
              ['name', 'like', '%'.$this->search.'%'],])
            ->whereExists(function ($query) {
              $query->select(DB::raw(1))
                ->from('late')
                ->whereColumn('main_view.no', 'late.no')
                ->where('emp',Auth::user()->empno);
               })
            ->orderby($this->orderColumn,$this->sortOrder)
            ->paginate()
        ]);
      }
    }
}
