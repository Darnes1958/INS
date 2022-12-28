<?php

namespace App\Http\Livewire\Sell;

use App\Models\sell\price_type;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PriceSelect extends Component
{
  public $type_no=1;

  public $PriceList;


  protected $listeners = [
    'TakeTypeNo'  ];

  public function TakeTypeNo($wo){

      $this->type_no = $wo;


  }

  public function hydrate(){
    $this->emit('price-change-event');
  }
  public function render()
  {

    $this->PriceList=price_type::on(Auth::user()->company)->where('type_no','!=',2)->get();

    return view('livewire.sell.price-select',$this->PriceList);

  }
}

