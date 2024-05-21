<?php

namespace App\Http\Livewire\Stores;

use App\Models\aksat\main_items;
use App\Models\aksat\main_items_deleted;
use App\Models\buy\buy_tran;
use App\Models\buy\buy_tran_work;
use App\Models\sell\sell_tran;
use App\Models\stores\halls;
use App\Models\stores\item_type;
use App\Models\stores\items;
use App\Models\stores\store_exp;
use App\Models\stores\stores;
use App\Models\Tar\tar_buy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use mysql_xdevapi\Table;

class ItemDamage extends Component
{
    public $itemno=0;
    public $itemno2=0;
    public $item_name;
    public $item_name2;
    public $type_name;
    public $type_name2;
    public $raseed;
    public $ItemGeted=false;
    public $ItemGeted2=false;
    public $TheItemIsSelected;
    public $TheItemIsSelected2;

    public function updatedTheItemIsSelected(){
        $this->TheItemIsSelected=0;
        $this->ChkItemAndGo();
    }
    public function updatedTheItemIsSelected2(){
        $this->TheItemIsSelected2=0;
        $this->ChkItemAndGo2();
    }

    public function updatedItem()
    {
        $this->ItemGeted=false;
    }
    public function updatedItem2()
    {
        $this->ItemGeted2=false;
    }


    public function ChkItemAndGo(){
        $this->item_name='';
        if ($this->itemno!=null) {
            if ($this->itemno2==$this->itemno){
                $this->itemno2=null;
                $this->item_name2='';
                $this->ItemGeted2=false;

            }
            $result=items::on(Auth()->user()->company)
                ->where('item_no', $this->itemno)->first();
            if ($result) {
                $this->type_name=item_type::on(Auth()->user()->company)->
                 where('type_no',$result->item_type)->first()->type_name;
                $this->item_name=$result->item_name;
                $this->raseed= $result->raseed;
                $this->ItemGeted=true;
            }
        }
    }
    public function ChkItemAndGo2(){
        $this->item_name2='';
        $this->ItemGeted2=false;
        if ($this->itemno2!=null) {
            if ($this->itemno2==$this->itemno){
                $this->itemno2=null;
                $this->ItemGeted2=false;
                return;
            }
            $result=items::on(Auth()->user()->company)
                ->where('item_no', $this->itemno2)->first();
            if ($result) {

                $this->type_name2=item_type::on(Auth()->user()->company)->
                where('type_no',$result->item_type)->first()->type_name;
                $this->item_name2=$result->item_name;
                $this->raseed= $result->raseed;
                $this->ItemGeted2=true;
            }}
    }

    public function Damage(){

        DB::connection(Auth()->user()->company)->beginTransaction();
        try {
            buy_tran::where('item_no', $this->itemno2)->update(['item_no' => $this->itemno]);
            buy_tran_work::where('item_no', $this->itemno2)->update(['item_no' => $this->itemno]);
            DB::connection(Auth()->user()->company)->table('buy_prices_daily')->where('item_no', $this->itemno2)->delete();
            DB::connection(Auth()->user()->company)->table('item_price_buy')->where('item_no', $this->itemno2)->delete();

            sell_tran::where('item_no', $this->itemno2)->update(['item_no' => $this->itemno]);
            DB::connection(Auth()->user()->company)->table('item_price_sell')->where('item_no', $this->itemno2)->delete();

            store_exp::where('item_no', $this->itemno2)->update(['item_no' => $this->itemno]);
            DB::connection(Auth()->user()->company)->table('store_imp')->where('item_no', $this->itemno2)->update(['item_no' => $this->itemno]);
            $res=stores::where('item_no', $this->itemno2)->get();
            foreach ($res as $item){
                $store=stores::where('item_no',$this->itemno)->where('st_no',$item->st_no)->first();
                if ($store) {
                    $q=$item->raseed+$store->raseed;
                    stores::where('item_no',$this->itemno)->where('st_no',$item->st_no)->update(['raseed'=>$q]);
                }
                else
                    stores::create(['item_no'=>$this->itemno,'st_no'=>$item->st_no,'raseed'=>$item->raseed]);
            }
            $res=halls::where('item_no', $this->itemno2)->get();
            foreach ($res as $item){
                $store=halls::where('item_no',$this->itemno)->where('hall_no',$item->hall_no)->first();
                if ($store) {
                    $q=$item->raseed+$store->raseed;
                    halls::where('item_no',$this->itemno)->where('hall_no',$item->hall_no)->update(['raseed'=>$q]);
                }
                else
                    halls::create(['item_no'=>$this->itemno,'hall_no'=>$item->hall_no,'raseed'=>$item->raseed]);
            }

            stores::where('item_no', $this->itemno2)->delete();
            halls::where('item_no', $this->itemno2)->delete();

            tar_buy::where('item_no', $this->itemno2)->update(['item_no' => $this->itemno]);

            main_items::where('item_no', $this->itemno2)->update(['item_no' => $this->itemno]);
            main_items_deleted::where('item_no', $this->itemno2)->update(['item_no' => $this->itemno]);
            DB::connection(Auth()->user()->company)->table('main_itemstemp')->where('item_no', $this->itemno2)->update(['item_no' => $this->itemno]);

            items::where('item_no', $this->itemno2)->delete();

            $this->emit('RefreshSelectItem');
            $this->emit('RefreshSelectItem2');

            DB::connection(Auth()->user()->company)->commit();
            $this->itemno=null;
            $this->item_name=null;
            $this->ItemGeted=false;

            $this->itemno2=null;
            $this->item_name2=null;
            $this->ItemGeted2=false;


        }
         catch (\Exception $e) {
            info($e);
            DB::connection(Auth()->user()->company)->rollback();
            $this->dispatchBrowserEvent('mmsg', 'حدث خطأ');
        }
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
        $first2=DB::connection(Auth()->user()->company)->table('halls')
            ->join('halls_names','halls.hall_no','=','halls_names.hall_no')
            ->select('halls.item_no','halls.raseed','halls_names.hall_name as place_name')
            ->where('item_no', '=', $this->itemno2)
            ->where('raseed','>', 0);

        $second2=DB::connection(Auth()->user()->company)->table('stores')
            ->join('stores_names','stores.st_no','=','stores_names.st_no')
            ->select('stores.item_no','stores.raseed','stores_names.st_name as place_name')
            ->where('item_no', '=', $this->itemno2)
            ->where('raseed','>', 0)
            ->union($first2)
            ->get();

        return view('livewire.stores.item-damage',[
            'pricetable'=>DB::connection(Auth()->user()->company)->table('item_price_sell')
            ->join('price_type','item_price_sell.price_type','=','price_type.type_no')
            ->select('item_price_sell.*', 'price_type.type_name')
            ->where('item_no',$this->itemno)

            ->get(),
            'pricetable2'=>DB::connection(Auth()->user()->company)->table('item_price_sell')
                ->join('price_type','item_price_sell.price_type','=','price_type.type_no')
                ->select('item_price_sell.*', 'price_type.type_name')
                ->where('item_no',$this->itemno2)

                ->get(),

            'placetable'=>$second, 'placetable2'=>$second2]);
    }
}
