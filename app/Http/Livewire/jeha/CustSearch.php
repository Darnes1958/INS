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

  public $PagNo = 10;
  protected $paginationTheme = 'bootstrap';
  public $SearchJehaNo;

  public $search;
  public function updatingSearch()
  {
    $this->resetPage();
  }

  public function selectItem($jeha_no)
  {
    $this->emit('Take_Search_JehaNo', $jeha_no);
    $this->dispatchBrowserEvent('CloseSelljehaModal');
  }

  public function render()
  {
    Config::set('database.connections.other.database', Auth::user()->company);
    return view('livewire.jeha.cust-search', [
      'TableList' => DB::connection('other')->table('jeha')
        ->select('jeha_no', 'jeha_name')
        ->where('jeha_type',1)
        ->where('jeha_name', 'like', '%'.$this->search.'%')
        ->paginate($this->PagNo)
    ]);
  }
}


