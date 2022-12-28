<?php

namespace App\Http\Livewire\Amma\Mak;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;


class MakRep extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';
  public $search;
  public $RepChk=true;
  public function updatingSearch()
  {
    $this->resetPage();
  }
  public function updatingRepChk()
  {
    $this->resetPage();
  }

    public function render()
    {

      if ($this->RepChk) {
       return view('livewire.amma.mak.mak-rep',[
          'RepTable'=>DB::connection(Auth()->user()->company)->table('rep_makzoon')
            ->where('item_name', 'like', '%'.$this->search.'%')
            ->orwhere('item_no', 'like', '%'.$this->search.'%')
            ->orwhere('type_name', 'like', '%'.$this->search.'%')
            ->orderBy('item_type','asc')
            ->orderBy('item_no','asc')->paginate(15)
        ]);}
      else {
        return view('livewire.amma.mak.mak-rep',[
          'RepTable'=>DB::connection(Auth()->user()->company)->table('rep_makzoon')
            ->where('raseed','!=',0)
            ->where('place_ras','!=',0)
            ->where([
              ['item_name', 'like', '%'.$this->search.'%'],
              ['item_no', 'like', '%'.$this->search.'%'],
              ['type_name', 'like', '%'.$this->search.'%'],
            ])
            ->orderBy('item_type','asc')
            ->orderBy('item_no','asc')->paginate(15)
        ]);
      }
    }
}
