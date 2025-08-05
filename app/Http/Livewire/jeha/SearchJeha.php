<?php

namespace App\Http\Livewire\jeha;

use App\Models\aksat\main;
use App\Models\jeha\jeha;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SearchJeha extends Component
{

    public $showdiv = false;
    public $showinput = false;
    public $search = "";
    public $records;
    public $empDetails;
    public $sender;
    public $jeha;
    public $jeha_type;
    public $do=true;


    public $JehaGeted=false;

    protected $listeners = ['TakeJehaType','Hidediv','TakeSearch','TakeSearchToEdit'];

    public function updatedSearch(){
      $this->emitTo($this->sender,'TextIsUpdate',$this->search);
    }

    function hidediv(){
      $this->showdiv=false;
    }

  public function Goto(){
    if(!empty($this->search)){
      $this->showdiv=false;

      $this->emitTo($this->sender,'TakeJehaSearch');
    }
  }
  function TakeSearch($search){
    $this->search=$search;
    $this->searchResult();
  }
  function TakeSearchToEdit($search){
    $this->search=$search;


  }

    public function TakeJehatype($jehatype){
        $this->jeha_type=$jehatype;
        $this->JehaGeted=true;
    }
    // Fetch records
    public function searchResult(){
      if(!empty($this->search)){
          $this->records =jeha::on(Auth()->user()->company)->orderby('jeha_name','asc')
              ->select('*')
              ->where([
                  ['jeha_type',$this->jeha_type],
                  ['jeha_name','like','%'.$this->search.'%']
              ])
              ->when(!Auth::user()->can('عميل خاص'),function($q){
                  $q->where('acc_no','!=',1);
              })
              ->limit(5)
              ->get();
           $this->showdiv = true;
      }else{
          $this->showdiv = false;
        }
    }


    // Fetch record by ID
    public function fetchEmployeeDetail($id = 0){
        $record =jeha::on(Auth()->user()->company)->select('*')
            ->where('jeha_no',$id)
            ->when(!Auth::user()->can('عميل خاص'),function($q){
                $q->where('acc_no','!=',1);
            })
            ->first();
        $this->search = $record->acc;
        $this->emitTo($this->sender,'TakeTheJehaNo',$id,$record->jeha_name);
        $this->empDetails = $record;
        $this->showdiv = false;
    }

    public function render()
    {
        return view('livewire.jeha.search-jeha');
    }
}
