<?php

namespace App\Http\Livewire\Aksat\Rep\Okod;

use App\Http\Livewire\Admin\Mahjoza;
use App\Models\aksat\main;
use App\Models\aksat\main_view;
use App\Models\excel\KaemaModel;
use App\Models\excel\MahjozaModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class RepMahjoza extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';
  public $TajNo;
  public $search;

  public $orderColumn = "acc";
  public $sortOrder = "asc";
  public $sortLink = '<i class="sorticon fas fa-angle-up"></i>';
  public $RepRadio='Yes';

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


        return view('livewire.aksat.rep.okod.rep-mahjoza',[
          'RepTable'=>MahjozaModel::
          where('Taj', '=', $this->TajNo)
          ->where('name', 'like', '%'.$this->search.'%')
            ->orderby($this->orderColumn,$this->sortOrder)
            ->paginate(15),
          'RepNot'=>main_view::whereIn('bank',function ($q){
            $q->select('bank_no')->from('bank')->where('bank_tajmeeh',$this->TajNo);
          })
          ->whereNotIn('acc',function ($q){
            $q->select('acc')->from('Mahjoza')->where('Taj',$this->TajNo);
          })
            ->paginate(15, ['*'], 'Not'),
        ]);
    }
}
