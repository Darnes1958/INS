<?php

namespace App\Http\Livewire\Amma\Mak;

use App\Models\stores\item_type;
use App\Models\stores\items;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use mysql_xdevapi\Table;

class ItemRep extends Component
{
    public $itemno=0;
    public $item_name;
    public $type_name;
    public $price_buy;
    public $price_cost;
    public $price;
    public $raseed;
    public $ItemGeted=false;
    public $TheItemIsSelected;

    public function updatedTheItemIsSelected(){
        $this->TheItemIsSelected=0;
        $this->ChkItemAndGo();
    }

    public function updatedItem()
    {
        $this->ItemGeted=false;
    }

    public function ChkItemAndGo(){
        $this->item_name='';
        if ($this->itemno!=null) {
            $result=items::on(Auth()->user()->company)
                ->where('item_no', $this->itemno)->first();
            if ($result) {
                $this->type_name=item_type::on(Auth()->user()->company)->
                 where('type_no',$result->item_type)->first()->type_name;
                $this->item_name=$result->item_name;

                $this->price_buy=number_format($result->price_buy, 2, '.', '')  ;
                $this->price_cost=number_format($result->price_cost, 2, '.', '')  ;
                $this->raseed= $result->raseed;
                $this->ItemGeted=true;
            }}
    }
    public function render()
    {
      if (!$this->itemno) $this->itemno=0;
        $first=DB::connection(Auth()->user()->company)->table('halls')
            ->join('halls_names','halls.hall_no','=','halls_names.hall_no')
            ->select('halls.item_no','halls.raseed','halls_names.hall_name as place_name')
            ->where('item_no', '=', $this->itemno)
            ->where('raseed','>', 0);

        $second=DB::connection(Auth()->user()->company)->table('stores')
            ->join('stores_names','stores.st_no','=','stores_names.st_no')
            ->select('stores.item_no','stores.raseed','stores_names.st_name as place_name')
            ->where('item_no', '=', $this->itemno)
            ->where('raseed','>', 0)
            ->union($first)
            ->get();
        return view('livewire.amma.mak.item-rep',[
            'pricetable'=>DB::connection(Auth()->user()->company)->table('item_price_sell')
            ->join('price_type','item_price_sell.price_type','=','price_type.type_no')
            ->select('item_price_sell.*', 'price_type.type_name')
            ->where('item_no',$this->itemno)

            ->get(),
            'placetable'=>$second]);
    }
}
