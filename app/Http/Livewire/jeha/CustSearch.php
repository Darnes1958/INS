<?php

namespace App\Http\Livewire\Jeha;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class CustSearch extends Component
{
  use WithPagination;
  public $jeha_type=1;
  public $PagNo = 10;
  protected $paginationTheme = 'bootstrap';
  public $SearchJehaNo;
  public $Favorite=0;

  public $search;
  protected $listeners = [
    'refreshComponent' => '$refresh','WithJehaType'
  ];
  public function WithJehaType($jeha_type)
  {
    $this->jeha_type=$jeha_type;
  }
 public function selectFav($i){
    $this->Favorite=$i;
 }
  public function updatingSearch()
  {
    $this->resetPage();
  }

  public function selectItem($jeha_no)
  {
    $this->emit('Take_Search_JehaNo', $jeha_no);
    $this->dispatchBrowserEvent('CloseSelljehaModal');
    $this->dispatchBrowserEvent('ClosejehaModal');
    $this->dispatchBrowserEvent('CloseTransjehaModal');
  }

  public function render()
  {

      if ($this->jeha_type==123)
          return view('livewire.jeha.cust-search', [
              'TableList' => DB::connection(Auth()->user()->company)->table('jeha')
                  ->select('jeha_no', 'jeha_name')

                  ->where('available',1)
                  ->when($this->Favorite==1,function ($q){
                      $q->where('Favorite',1);
                  })
                  ->where('jeha_name', 'like', '%'.$this->search.'%')
                  ->when(!Auth::user()->can('عميل خاص'),function($q){
                      $q->where('acc_no','!=',1);
                  })
                  ->orderBy('jeha_no','desc')
                  ->paginate($this->PagNo)
          ]);
    if ($this->jeha_type!=3 && $this->jeha_type!=13 && $this->jeha_type!=123)
     return view('livewire.jeha.cust-search', [
      'TableList' => DB::connection(Auth()->user()->company)->table('jeha')
        ->select('jeha_no', 'jeha_name')
        ->where('jeha_type',$this->jeha_type)
        ->where('available',1)
        ->when($this->Favorite==1,function ($q){
          $q->where('Favorite',1);
        })
        ->where('jeha_name', 'like', '%'.$this->search.'%')
        ->when(!Auth::user()->can('عميل خاص'),function($q){
            $q->where('acc_no','!=',1);
        })
        ->orderBy('jeha_no','desc')
        ->paginate($this->PagNo)
    ]);
      if ($this->jeha_type==13)
          return view('livewire.jeha.cust-search', [
              'TableList' => DB::connection(Auth()->user()->company)->table('jeha')
                  ->select('jeha_no', 'jeha_name')
                  ->where('jeha_type','!=',2)
                ->where('available',1)
                ->when($this->Favorite==1,function ($q){
                  $q->where('Favorite',1);
                })

                  ->where('jeha_name', 'like', '%'.$this->search.'%')
                  ->when(!Auth::user()->can('عميل خاص'),function($q){
                      $q->where('acc_no','!=',1);
                  })
                  ->orderBy('jeha_no','desc')
                  ->paginate($this->PagNo)
          ]);
    if ($this->jeha_type==3)
      return view('livewire.jeha.cust-search', [
        'TableList' => DB::connection(Auth()->user()->company)->table('jeha')
          ->select('jeha_no', 'jeha_name')
          ->whereNotIn('jeha_type',[1,2])
          ->where('available',1)
          ->when($this->Favorite==1,function ($q){
            $q->where('Favorite',1);
          })

          ->where('jeha_name', 'like', '%'.$this->search.'%')
          ->when(!Auth::user()->can('عميل خاص'),function($q){
                $q->where('acc_no','!=',1);
            })
            ->orderBy('jeha_no','desc')
            ->paginate($this->PagNo)
      ]);

  }
}


