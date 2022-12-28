<?php

namespace App\Http\Livewire\Aksat\Rep\Okod;


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
  public $search;

  public function updatingSearch()
  {
    $this->resetPage();
  }

  protected $listeners = [
    'TakeBank',
  ];
  public function TakeBank($bank_no){
    $this->bank_no=$bank_no;
  }
    public function render()
    {

      return view('livewire.aksat.rep.okod.bank-one',[
        'RepTable'=>rep_bank::on(Auth()->user()->company)->
           where([
            ['bank', '=', $this->bank_no],
            ['name', 'like', '%'.$this->search.'%'],])
          ->orwhere([
            ['bank', '=', $this->bank_no],

            ['acc', 'like', '%'.$this->search.'%'],])
          ->paginate(15)
      ]);

    }
}
