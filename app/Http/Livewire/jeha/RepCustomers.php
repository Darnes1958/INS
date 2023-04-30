<?php

namespace App\Http\Livewire\Jeha;

use App\Models\jeha\jeha;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class RepCustomers extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';

  public $ZeroShow='yes';
  public $jeha_no=0;
  public $jeha_name='';
  public $Favorite=0;
  public $Special=0;
  public function selectFav($i){
    $this->Favorite=$i;
  }
  public $search;
  public function selectSpc($i){
    $this->Special=$i;
  }
  public function updatingSearch()
  {
    $this->resetPage();
  }
  public function selectItem($jeha,$action){
    if ($action=='favorite'){
      jeha::on(Auth::user()->company)
        ->where('jeha_no',$jeha)
        ->update(['Favorite'=>1]);
    }
    if ($action=='notfavorite'){
      jeha::on(Auth::user()->company)
        ->where('jeha_no',$jeha)
        ->update(['Favorite'=>0]);
    }
    if ($action=='special'){
      jeha::on(Auth::user()->company)
        ->where('jeha_no',$jeha)
        ->update(['acc_no'=>1]);
    }
    if ($action=='notspecial'){
      jeha::on(Auth::user()->company)
        ->where('jeha_no',$jeha)
        ->update(['acc_no'=>0]);
    }
    if ($action=='nothing') {
      $this->jeha_no = $jeha;
      $this->jeha_name = jeha::on(Auth()->user()->company)->find($this->jeha_no)->jeha_name;
      $this->resetPage();
    }
  }
    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
    public function render()
    {

        return view('livewire.jeha.rep-customers',[
            'RepTable'=>DB::connection(Auth()->user()->company)->table('CustomerMasterView')
                ->where('available',1)
                ->Where('jeha_name', 'like', '%'.$this->search.'%')
                ->when($this->Favorite==1,function ($q){
                    $q->where('Favorite',1);
                })
                ->when($this->Special==1,function ($q){
                    $q->where('acc_no',1);
                })

                ->when(!Auth::user()->can('عميل خاص'),function($q){
                    $q->where('acc_no','!=',1);
                })
                ->when($this->ZeroShow!='yes',function ($q) {
                    return $q->where('differ','!=', 0) ;     })
                ->paginate(15),
            'Sum'=>DB::connection(Auth()->user()->company)->table('CustomerMasterView')
                ->where('available',1)
                ->where('jeha_no','!=',1)
                ->when($this->Favorite==1,function ($q){
                    $q->where('Favorite',1);
                })
                ->when($this->Special==1,function ($q){
                    $q->where('acc_no',1);
                })

                ->when(!Auth::user()->can('عميل خاص'),function($q){
                    $q->where('acc_no','!=',1);
                })
                ->when($this->ZeroShow!='yes',function ($q) {
                    return $q->where('differ','!=', 0) ;     })
                ->sum('differ'),
          'RepTable2'=>DB::connection(Auth()->user()->company)->table('CustomerDetailView')
            ->where('jeha',$this->jeha_no)
            ->orderBy('order_date')
            ->paginate(15, ['*'], 'DetailTable'),

        ]);
    }
}
