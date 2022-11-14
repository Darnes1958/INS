<?php

namespace App\Http\Livewire\Tools;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class MyManyAccTable extends Component
{
  use WithPagination;
  public $PagNo=6;
  protected $paginationTheme = 'bootstrap';

  protected $listeners = [
    'GetMany_Bank_Acc',
  ];

  public $TableName='main';
  public $Bank;
  public $Acc;
  public function GetMany_Bank_Acc($bank,$acc){
    $this->Bank=$bank;
    $this->Acc=$acc;

  }

  public function selectItem($TheId, $action)
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
      Config::set('database.connections.other.database', Auth::user()->company);


      return view('livewire.tools.my-many-acc-table', [
          'TableList' => DB::connection('other')->table($this->TableName)
              ->select('no','name','sul','kst')
              ->where('bank', '=', $this->Bank)
              ->where('acc', '=', $this->Acc)
              ->paginate($this->PagNo)

      ]);
  }

}

