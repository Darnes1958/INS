<?php

namespace App\Http\Livewire\Tools;

use App\Models\stores\item_type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class MyTable extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';

  protected $listeners = [
    'GetWhereEquelValue',
  ];

  public function GetWhereEquelValue($ID){
    $this->WhereEquelValue=$ID;

}

  public $TableName;
  public array $ColNames  ;
  public array $ColHeader  ;
  public $PagNo;

  public $HasWhereEquel;
  public $WhereEquelField;
  public $WhereEquelValue;

  public $IsSearchable;
  public $Col1Search;
  public $Col2Search;
  public $Col3Search;

  public $HasEdit;
  public $HasDelete;
  Public $HasAdd;

  public $ModalTitle;
  public $AddModal;
  public $EditModal;



  public function selectItem($TheId, $action)
  {

    if ($action == 'delete') {
      $this->dispatchBrowserEvent('OpenMyTableEdit');
    }
    else {
      $this->emit('GetTheId', $TheId);
      $this->dispatchBrowserEvent('OpenMyTableEdit');


    }
  }


  public $search;
  public function updatingSearch()
  {
    $this->resetPage();
  }

  protected $queryString = ['search'];

  public array $myquery;
  public function mount($IsSearchable=false,$Arr=[false,false,false,false,false] ,
    $hasadd=false,$hasedit=false,$hasdelete=false,
    $pagno=10,
    $addmodal='stores.add-item',$editmodal='stores.edit-item',$modaltitle='',
    $haswhereequel=false,$whereequelfield='',$whereequelvalue=''){

    $this->PagNo=$pagno;
    $this->IsSearchable=$IsSearchable;
    $this->Col1Search=$Arr[0];
    $this->Col2Search=$Arr[1];
    $this->Col3Search=$Arr[2];
    $this->HasDelete=$hasdelete;
    $this->HasEdit=$hasedit;
    $this->HasAdd=$hasadd;
    $this->AddModal=$addmodal;
    $this->EditModal=$editmodal;
    $this->ModalTitle=$modaltitle;
    $this->HasWhereEquel =$haswhereequel;
    $this->WhereEquelField=$whereequelfield;
    $this->WhereEquelValue=$whereequelvalue;

  }

  public function render()
  {
    for ($x = 0; $x <count($this->ColNames); $x++) {
      $this->myquery[$x]=$this->ColNames[$x].' as Col'.$x+1;
    }

    Config::set('database.connections.other.database', Auth::user()->company);

    if ($this->HasWhereEquel) {
      return view('livewire.tools.my-table',[
        'TableList' => DB::connection('other')->table($this->TableName)
          ->select($this->myquery)
          ->where($this->WhereEquelField,'=', $this->WhereEquelValue)
          ->paginate($this->PagNo),
        $this->ColNames,$this->ColHeader,
      ]);

    } else {
        return view('livewire.tools.my-table',[
          'TableList' => DB::connection('other')->table($this->TableName)
            ->select($this->myquery)
            ->when($this->HasWhereEquel,function ($q) {
              return $q->where($this->WhereEquelField,'=', $this->WhereEquelValue) ;     })
            ->when($this->IsSearchable, function($q)  {
              return $q->where($this->ColNames[0], 'like', '%'.$this->search.'%');       })
            ->when($this->Col1Search, function($q)  {
              return $q->orwhere($this->ColNames[1], 'like', '%'.$this->search.'%');     })
            ->when($this->Col2Search, function($q)  {
              return $q->orwhere($this->ColNames[2], 'like', '%'.$this->search.'%');     })
            ->when($this->Col3Search, function($q)  {
              return $q->orwhere($this->ColNames[3], 'like', '%'.$this->search.'%');     })

            ->paginate($this->PagNo),
          $this->ColNames,$this->ColHeader,$this->HasEdit,$this->HasDelete
        ]);}
  }
}

