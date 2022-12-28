<?php

namespace App\Http\Livewire\OverTar;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Tar2Table extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';
  public $no=0;
  public $acc='0';
  public $bank=0;
  protected $listeners =['TakeData'];

  public function TakeData($bank,$acc,$no,$name){
    $this->no=$no;
    $this->acc=$acc;
    $this->bank=$bank;
  }
    public function render()
    {
        return view('livewire.over-tar.tar2-table',[
          'TableList'=>DB::connection(Auth()->user()->company)->table('tar_kst')
            ->where('no',$this->no)
            ->where('bank',$this->bank)
            ->where('acc',$this->acc)
            ->where('ser','!=',0)
            ->orderBy('ser','asc')
            ->paginate(10)
        ]);
    }
}
