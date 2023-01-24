<?php

namespace App\Http\Livewire\Stores;

use App\Models\aksat\main;
use App\Models\stores\items;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SearchItem extends Component
{

    public $showdiv = false;
    public $search = "";
    public $records;
    public $empDetails;
    public $sender;
    public $PlaceSelectType='items';
    public $PlaceToSelect;

    public $accToEdit;
    public $ActiveSearch=false;
    public $DoNotSearch=false;

    protected $listeners = ['TakeItemType','take_goto'];

    public function take_goto($p){
        $this->emit('gotoitembox','search_box');
    }

    public function TakeItemType($placetype,$placeid){

        $this->PlaceSelectType=$placetype;
        $this->PlaceToSelect=$placeid;
        $this->ActiveSearch=true;
    }
    public function ChkItem(){

      if ($this->search && is_numeric($this->search)  ){

        if (items::on(Auth::user()->company)->where('item_no',$this->search)->exists()){
          $this->showdiv = false;
          $this->emitTo($this->sender,'TakeTheItemNo',$this->search);
          $this->DoNotSearch=true;

        }
      }
    }
    // Fetch records
    public function searchResult(){
if ($this->DoNotSearch)
{
  $this->DoNotSearch=false;
  return false;
}
        if(!empty($this->search)){
          if ($this->PlaceSelectType=='items') {
            $this->records = items::on(Auth()->user()->company)->orderby('name','asc')
              ->select('item_no', 'raseed', 'item_name')
              ->where([
                ['available',1],
                ['item_name','like','%'.$this->search.'%']
              ])
              ->orWhere([
                ['available',1],
                ['item_no','like','%'.$this->search.'%']
              ])
              ->limit(5)
              ->get();
          }
          if ($this->PlaceSelectType=='Makazen') {
            $this->records =DB::connection(Auth()->user()->company)->table('stores')
              ->join('items', 'stores.item_no', '=', 'items.item_no')
              ->select('stores.item_no', 'stores.raseed', 'items.item_name')
              ->where([['stores.st_no',$this->PlaceToSelect],
                      ['stores.raseed','>',0],
                      ['item_name','like','%'.$this->search.'%'],
              ])
              ->orWhere([['stores.st_no',$this->PlaceToSelect],
                ['stores.raseed','>',0],
                ['items.item_no','like','%'.$this->search.'%'],
              ])
              ->limit(5)
              ->get();}
          if ($this->PlaceSelectType=='Salat') {
            $this->records=DB::connection(Auth()->user()->company)->table('halls')
              ->join('items', 'halls.item_no', '=', 'items.item_no')
              ->select('halls.item_no', 'halls.raseed', 'items.item_name')
              ->where([['halls.hall_no',$this->PlaceToSelect],
              ['halls.raseed','>',0],
              ['item_name','like','%'.$this->search.'%'],
              ])
              ->orWhere([['halls.hall_no',$this->PlaceToSelect],
                ['halls.raseed','>',0],
                ['items.item_no','like','%'.$this->search.'%'],
              ])

              ->limit(5)
              ->get();
          }

            $this->showdiv = true;
        }else{
            $this->showdiv = false;
        }
    }

    // Fetch record by ID
    public function fetchEmployeeDetail($id = 0){

        $record =  items::on(Auth()->user()->company)->select('*')
            ->where('item_no',$id)
            ->first();

        $this->search = $record->acc;
        $this->emitTo($this->sender,'TakeTheItemNo',$id);
        $this->empDetails = $record;
        $this->showdiv = false;
    }

    public function render()
    {
        return view('livewire.stores.search-item');
    }
}
