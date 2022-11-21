<?php

namespace App\Http\Livewire\Haf;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;


class HafInputTable extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';

  protected $listeners = [
    'TakeHafithaTable',
  ];
  public $hafitha=0;
  public function TakeHafithaTable($h){

    $this->hafitha=$h;
  }
  public function render()
    {

        return view('livewire.haf.haf-input-table',[
          'HafithaTable' =>DB::connection('other')
            ->table('hafitha_tran_view')
            ->where('hafitha_no',$this->hafitha)
            ->orderBy('acc','asc')
            ->orderBy('ser_in_hafitha','asc')
            ->paginate(15)]);
    }
}
