<?php

namespace App\Http\Livewire\Aksat\Rep\Okod;

use App\Models\bank\rep_banks;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class BankSum extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';
  public $search;

  public function updatingSearch()
  {
    $this->resetPage();
  }


  public function render()
  {

    return view('livewire.aksat.rep.okod.bank-sum',[
      'RepTable'=>rep_banks::on(Auth()->user()->company)->where('bank_name', 'like', '%'.$this->search.'%')->orderby('bank')->paginate(14)
    ]);
  }
}
