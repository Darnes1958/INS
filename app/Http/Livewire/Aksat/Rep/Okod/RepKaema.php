<?php

namespace App\Http\Livewire\Aksat\Rep\Okod;

use App\Models\aksat\main;
use App\Models\excel\KaemaModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class RepKaema extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';
  public $TajNo=0;
  public $search;

  public $orderColumn = "acc";
  public $sortOrder = "asc";
  public $sortLink = '<i class="sorticon fas fa-angle-up"></i>';
  public $RepRadio='Our';

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
    'TakeTajNo',
  ];
  public function TakeTajNo($tajno){
    $this->TajNo=$tajno;

  }
    public function render()
    {
      $ActiveBank = DB::connection(Auth::user()->company)->table('bank')->select('bank_no')->where('bank_tajmeeh', $this->TajNo);
      $ActiveAcc = DB::connection(Auth::user()->company)-> table('main')->select('Acc')->whereIn('bank', $ActiveBank);
      $ActiveAcc2 = DB::connection(Auth::user()->company)-> table('Kaema')->select('Acc')->whereIn('bank', $ActiveBank);

        return view('livewire.aksat.rep.okod.rep-kaema',[
          'RepTable'=>KaemaModel::
          where('Taj', '=', $this->TajNo)
          ->where('name', 'like', '%'.$this->search.'%')
            ->orderby($this->orderColumn,$this->sortOrder)
            ->paginate(15),
          'RepOur'=>KaemaModel::
            whereNotIn('acc', $ActiveAcc)
            ->where('name', 'like', '%'.$this->search.'%')

            ->paginate(15, ['*'], 'NotOurPage'),
          'RepThere'=>main::
          whereNotIn('acc', $ActiveAcc2)

            ->where('name', 'like', '%'.$this->search.'%')

            ->paginate(15, ['*'], 'NotTherePage'),

        ]);
    }
}
