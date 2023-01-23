<?php

namespace App\Http\Livewire\Sell;

use App\Models\aksat\place;
use App\Models\stores\halls;
use App\Models\stores\halls_names;
use App\Models\stores\store_exp;
use App\Models\stores\stores;
use App\Models\stores\stores_names;
use Illuminate\Queue\Listener;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class BringItem extends Component
{
  public $item_no;


  public $Table1='Makazen';
  public $Table2;
  public $place_no1;
  public $place_no2;


  public $themax;
  public $ThePlace1ListIsSelected;

  public $Place1Geted=false;
  public $QuantGeted=false;

  public $stores_names;
  public $halls_names;
  public $raseed;
  public $quantbring;

  protected $listeners =['TakeParam'];

  public function TakeParam($place_type,$place,$item){
    $this->place_no2=$place;
    $this->item_no=$item;
    $this->Table2=$place_type;

  }

  public function ChkQuant(){
      if ($this->quantbring>$this->raseed) $this->dispatchBrowserEvent('mmsg', 'الرصيد لا يسمح !');
      else {
          $this->QuantGeted=true;
          $this->emit('goto','head-btnbring');
      }
  }
    protected function rules()
    {

        return [

            'quantbring' =>   ['required','integer','gt:0'],

        ];
    }
    protected $messages = [
        'required' => 'لا يجوز ترك فراغ',

    ];
  public function Save(){
      $this->validate();
      if ($this->quantbring>$this->raseed) {
          $this->dispatchBrowserEvent('mmsg', 'الرصيد لا يسمح !');
      return false;
      }

      if ($this->Table1=='Makazen' && $this->Table2=='Makazen') $per_type=1;
      if ($this->Table1=='Makazen' && $this->Table2=='Salat') $per_type=2;
      if ($this->Table1=='Salat' && $this->Table2=='Makazen') $per_type=3;
      if ($this->Table1=='Salat' && $this->Table2=='Salat') $per_type=4;

      if ($per_type==1 or $per_type==3) {$st_no2=$this->place_no2;$hall_no=0;}
      if ($per_type==2 or $per_type==4) {$st_no2=0;$hall_no=$this->place_no2;}
      if (store_exp::on(Auth()->user()->company)->where('per_no',$this->themax)->exists())
          $this->themax=store_exp::on(Auth()->user()->company)->max('per_no')+1;

      DB::connection(Auth()->user()->company)->table('store_exp')->insert([
          'st_no'=>$this->place_no1,
          'per_no'=>$this->themax,
          'item_no' => $this->item_no,
          'quant' => $this->quantbring,
          'exp_date'=>date('Y-m-d'),
          'order_no'=>0,
          'per_type'=>$per_type,
          'st_no2'=>$st_no2,
          'hall_no'=>$hall_no,
          'emp'=>Auth::user()->empno,
      ]);
      $this->emit('CloseBringModal');


  }
  public function TakeMe($raseed,$place_type,$place_no){

    $this->Table1=$place_type;
    $this->place_no1=$place_no;
    $this->raseed=$raseed;
    $this->Place1Geted=true;

    $this->emit('goto','quantbring');
  }



    public function render()
    { $this->themax=store_exp::on(Auth()->user()->company)->max('per_no')+1;
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
