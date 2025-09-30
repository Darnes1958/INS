<?php

namespace App\Http\Livewire\Aksat\Rep\Okod;

use App\Models\aksat\main;
use App\Models\bank\bank;
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
  public $bank_no=0;
  public $bank_name;
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
    'TakeTajNo','TakeBank',
  ];
  public function TakeTajNo($tajno){
    $this->TajNo=$tajno;

  }
  public function TakeBank($bank_no){
    $this->bank_no=$bank_no;
    $this->bank_name=bank::on(Auth()->user()->company)->where('bank_no',$this->bank_no)->first()->bank_name;

  }
  public function mount(){


  }
    public function render()
    {
      $ActiveBank = DB::connection(Auth::user()->company)->table('bank')->select('bank_no')->where('bank_tajmeeh', $this->TajNo);
      $ActiveAcc = DB::connection(Auth::user()->company)-> table('main')->select('acc')->whereIn('bank', $ActiveBank);
      $ActiveAcc2 = DB::connection(Auth::user()->company)-> table('Kaema')->select('acc')->whereIn('bank', $ActiveBank);



        return view('livewire.aksat.rep.okod.rep-kaema',[
          'RepTable'=>KaemaModel::
            where('Taj', '=', $this->TajNo)
            ->Where(function($query) {
            $query->where('name', 'like', '%'.$this->search.'%')
              ->orwhere('acc', 'like', '%'.$this->search.'%');})
            ->orderby($this->orderColumn,$this->sortOrder)
            ->paginate(15),
          'RepOur'=>KaemaModel::
            whereIn('bank',$ActiveBank)
            ->whereNotIn('acc', $ActiveAcc)
            ->Where(function($query) {
              $query->where('name', 'like', '%'.$this->search.'%')
                ->orwhere('acc', 'like', '%'.$this->search.'%');})
            ->when($this->bank_no!=0,function($q){
              return $q->where('bank', '=', $this->bank_no);})
            ->paginate(15, ['*'], 'NotOurPage'),

          'RepThere2' => DB::connection(Auth::user()->company)->table("main")->select('*')
            ->when($this->bank_no!=0,function($q){
              return $q->where('bank', '=', $this->bank_no);})
            ->where('taj_id',$this->TajNo)
            ->whereNotIn('acc',function($query){
              $query->select('acc')->from('kaema')
                ->whereIn('bank',function ($q){
                  $q->select('bank_no')->from('bank')->where('bank_tajmeeh', $this->TajNo);
                });
            })
            ->Where(function($query) {
              $query->where('name', 'like', '%'.$this->search.'%')
                ->orwhere('acc', 'like', '%'.$this->search.'%');})
            ->paginate(15, ['*'], 'NotTherePage2'),

          'RepThere'=>main::

            whereIn('bank',$ActiveBank)
            ->whereNotIn('acc', $ActiveAcc2)
            ->when($this->bank_no!=0,function($q){
              return $q->where('bank', '=', $this->bank_no);})

            ->Where(function($query) {
              $query->where('name', 'like', '%'.$this->search.'%')
                ->orwhere('acc', 'like', '%'.$this->search.'%');})

            ->paginate(15, ['*'], 'NotTherePage'),

        ]);
    }
}
