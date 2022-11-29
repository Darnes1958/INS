<?php

namespace App\Http\Livewire\Aksat\Rep\Okod;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class MosdadaTable extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';
  public $bank_no=0;
  public $search;
  public $baky=0;
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
  function mount(){


  }

    public function render()
    {
      Config::set('database.connections.other.database', Auth::user()->company);
      return view('livewire.aksat.rep.okod.mosdada-table',[
          'RepTable'=>DB::connection('other')->table('main_view')
              ->where([
              ['bank', '=', $this->bank_no],
              ['raseed','<=',$this->baky],
              ['name', 'like', '%'.$this->search.'%'],])
              ->orwhere([
                ['bank', '=', $this->bank_no],
                ['raseed','<=',$this->baky],
                ['acc', 'like', '%'.$this->search.'%'],])
            ->paginate(15)
        ]);
    }
}
