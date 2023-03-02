<?php

namespace App\Http\Livewire\Stores;

use App\Models\stores\items;
use App\Models\stores\place_view;
use App\Models\stores\RepMakzoon;
use App\Models\stores\stores;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class JaradHead extends Component
{
  public $place_no;
  public $place_type;
  public $place_name;
  public $item_type;
  public $JarRaseed;
  public $item_no,$item_name,$raseed;

  public function updated($field){

    if ($field=='place_name'){
      $res=place_view::where('place_name',$this->place_name)->first();
      if ($res){
        $this->place_no=$res->place_no;
        $this->place_type=$res->place_type-1;
      }
    }
    if ($field=='item_type'){
      $res=RepMakzoon::where('place_type',$this->place_type)
       ->where('place_no',$this->place_no)
       ->where('item_type',$this->item_type)
        ->orderby('item_no')
        ->first();
      if ($res){
        $this->item_no=$res->item_no;
        $this->item_name=$res->item_name;
        $this->raseed=$res->raseed;
        $this->JarRaseed=$res->place_ras;
        $this->emit('gotonext','JarRaseed');
      }
    }

  }
  public function SaveRas(){
    if ($this->JarRaseed){
      stores::where('st_no',$this->place_no)
            ->where('item_no',$this->item_no)
            ->update(['raseed'=>$this->JarRaseed,]);



    }
  }
  public function render()
    {

        return view('livewire.stores.jarad-head',[
          'places'=>place_view::all(),
          'item_types'=>RepMakzoon::select('item_type','type_name')
            ->where('place_type',$this->place_type)->where('place_no',$this->place_no)
            ->groupby('item_type','type_name')->get(),
          'RepMak'=>RepMakzoon::where('place_type',$this->place_type)
          ->where('place_no',$this->place_no)
          ->where('item_type',$this->item_type)
          ->orderby('item_no')
          ->get(),

        ]);
    }
}
