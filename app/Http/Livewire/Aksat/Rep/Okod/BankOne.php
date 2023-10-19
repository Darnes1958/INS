<?php

namespace App\Http\Livewire\Aksat\Rep\Okod;


use App\Models\bank\BankTajmeehy;
use App\Models\bank\rep_bank;
use App\Models\bank\rep_banks;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;
use Livewire\WithPagination;

class BankOne extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';
  public $bank_no=0;
    public $TajNo=0;
    public $TajName;

  public $search;
  public $ByTajmeehy='Bank';
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
  }
    public function TakeTajNo($tajno){

        $this->TajNo=$tajno;

    }

    public function render()
    {

    if ($this->ByTajmeehy=='Bank')
      return view('livewire.aksat.rep.okod.bank-one',[
        'RepTable'=>rep_bank::on(Auth()->user()->company)->
           where([
            ['bank', '=', $this->bank_no],
            ['name', 'like', '%'.$this->search.'%'],])
          ->orwhere([
            ['bank', '=', $this->bank_no],

            ['acc', 'like', '%'.$this->search.'%'],])
          ->orderby($this->orderColumn,$this->sortOrder)
          ->paginate(15)
      ]);

        if ($this->ByTajmeehy=='Taj')
            return view('livewire.aksat.rep.okod.bank-one',[
                'RepTable'=>rep_bank::on(Auth()->user()->company)->
                whereIn('bank', function($q){
                    $q->select('bank_no')->from('bank')->where('bank_tajmeeh',$this->TajNo);})
                    ->orderby($this->orderColumn,$this->sortOrder)
                    ->paginate(15)
            ]);

    }
}
