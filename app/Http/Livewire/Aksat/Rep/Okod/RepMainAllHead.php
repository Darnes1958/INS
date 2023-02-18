<?php

namespace App\Http\Livewire\Aksat\Rep\Okod;

use App\Models\aksat\main;
use App\Models\aksat\MainArc;
use App\Models\jeha\jeha;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class RepMainAllHead extends Component
{
 use WithPagination;
 protected $paginationTheme = 'bootstrap';
 public $no;
 public $acc;
 public $search='';
 public $IsSearch=true;
 public $jeha_no;
 public $TheBankListIsSelectd;

 public $isEmpty = '',$ShowSearch=false;

    public function updatingSearch()
    {
        $this->resetPage();
    }

 public function fetchEmployeeDetail($key){
        $this->search='';
        $this->jeha_no=$key;

    }
    public function SearchEnter(){
        if ($this->search && is_numeric($this->search)  ){

            if (jeha::on(Auth::user()->company)->where('jeha_no',$this->search)->exists()){
                $this->jeha_no=$this->search;
                $this->search='';
                $this->ShowSearch=false;


            } else $this->ShowSearch=true;
        }
    }

 protected $listeners = ['OpenTable','RefreachHead'];

 public function RefreachHead(){
     $this->render();
 }

 public function updatedTheBankListIsSelectd(){
        $this->TheBankListIsSelectd=0;
        $this->emitTo('bank.bank-select','akeBankNo',$this->bankno);
    }


 public function OpenTable(){
    $this->IsSearch=true;
 }
 public function CloseTable(){
        $this->search='';
        $this->IsSearch=false;
    }
 public function selectItem($no,$mainorarc){
   $this->no=$no;
   $this->ShowSearch=false;
   if ($mainorarc=='قائم')
     $result = main::where('no',$this->no)->first();
   else
     $result = MainArc::where('no',$this->no)->first();

     if ($result) {
         $this->CloseTable();
         $this->acc=$result->acc;
         $this->emitTo('aksat.rep.okod.rep-main-all-data','GotoDetail',$result,$mainorarc);
         $this->emitTo('aksat.rep.okod.rep-main-all-trans','GotoTrans',$this->no,$mainorarc);
         $this->emit('GetWhereEquelValue2',$result->order_no);
     }

 }
    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
    public function render()
    {
        $page = 1;
        $paginate = 5;
        if (!is_null($this->search)) {

            $records = jeha::search($this->search,1)
                ->where(function($query) {
                    $query->whereIn('jeha_no', function ($q){
                        $q->select('jeha')->from('main');
                    })
                        ->OrwhereIn('jeha_no', function ($q){
                            $q->select('jeha')->from('MainArc');
                        });
                })
                ->take(7)
                ->get();
            $this->isEmpty = '';

        } else {
            $records = [];
            $this->isEmpty = __('Nothings Found.');
        }
        $first= DB::connection(Auth()->user()->company)->table('main')
        ->selectRaw('no,sul_tot, kst,\'قائم\' as MainOrArc')
        ->where('jeha',$this->jeha_no);
        $second =DB::connection(Auth()->user()->company)->table('MainArc')
        ->selectRaw('no,sul_tot, kst,\'أرشيف\' as MainOrArc')
        ->where('jeha',$this->jeha_no)
        ->union($first)
        ->get();
        $data = $this->paginate($second);
        return view('livewire.aksat.rep.okod.rep-main-all-head',[
            'TableList' =>$data,


            'records'=>$records,
    ]);
    }
}
