<?php

namespace App\Http\Livewire\Tools;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class MyManyAccTable2 extends Component
{
  use WithPagination;
  public $PagNo=6;
  protected $paginationTheme = 'bootstrap';

  protected $listeners = [
    'GetMany_Acc',
  ];

  public $TableName='main';
  public $Bank;
  public $Acc;
  public function GetMany_Acc($acc){

    $this->Acc=$acc;

  }

  public function selectItem($TheId)
  {
      $this->emit('Take_ManyAcc_No',$TheId);
      $this->dispatchBrowserEvent('CloseKstManyModal');

  }

  public function mount(){
    $this->Bank=0;
    $this->Acc='';
  }

  public function render()
  {

      return view('livewire.tools.my-many-acc-table2', [
          'TableList' => DB::connection(Auth()->user()->company)->table($this->TableName)
              ->join('bank',$this->TableName.'.bank','=','bank.bank_no')
              ->select('no','name','sul','kst','bank_name')

              ->where('acc', '=', $this->Acc)
              ->paginate($this->PagNo)

      ]);
  }

}

