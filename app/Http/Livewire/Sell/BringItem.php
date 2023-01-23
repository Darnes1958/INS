<?php

namespace App\Http\Livewire\Sell;

use App\Models\stores\halls;
use App\Models\stores\halls_names;
use App\Models\stores\stores;
use App\Models\stores\stores_names;
use Illuminate\Queue\Listener;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class BringItem extends Component
{
  public $item_no;
  public $FromTo;
  public $From='المخزن';
  public $To;
  public $Table1='Makazen';
  public $Table2;
  public $place_no1;
  public $place_no2;
  public $place_name1;
  public $place_name2;

  public $themax;
  public $ThePlace1ListIsSelected;

  public $Place1Geted=false;
  public $QuantGeted=false;

  public $stores_names;
  public $halls_names;
  public $raseed;

  protected $listeners =['TakeParam'];




  public function TakeParam($place,$item){
    $this->place_no2=$place;
    $this->item_no=$item;
  }
  public function TakeMe($raseed,$place_type,$place_no){

    $this->Table1=$place_type;
    $this->place_no1=$place_no;
    $this->raseed=$raseed;
    $this->Place1Geted=true;
    $this->emit('goto','quant');
  }



    public function render()
    {
      $first=DB::connection(Auth()->user()->company)->table('halls')
        ->join('halls_names','halls.hall_no','=','halls_names.hall_no')
        ->selectRaw('\'Salat\'  as place_type,halls.hall_no as Place_no,halls.raseed,halls_names.hall_name as place_name')
        ->where('item_no', '=', $this->item_no)
        ->where('raseed','>', 0);

      $second=DB::connection(Auth()->user()->company)->table('stores')
        ->join('stores_names','stores.st_no','=','stores_names.st_no')
        ->selectRaw('\'Makazen\' as place_type,stores.st_no as place_no,stores.raseed,stores_names.st_name as place_name')
        ->where('item_no', '=', $this->item_no)
        ->where('raseed','>', 0)
        ->union($first)
        ->get();
      $this->stores_names=DB::connection(Auth()->user()->company)->table('stores_names')->get();
      $this->halls_names=DB::connection(Auth()->user()->company)->table('halls_names')->get();
        return view('livewire.sell.bring-item',['second'=>$second]);
    }
}
