<?php
namespace App\Http\Livewire\Traits;

use App\Models\buy\buy_tran;
use App\Models\others\price_type;
use App\Models\sell\sell_tran;
use App\Models\stores\items;
use App\Models\stores\stores;
use App\Models\stores\halls;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

trait MyLib {
    public $OldItemQuant=0;
    public $PlaceItemQuant;
    public $ItemExistsInOrder=false;

  function isDate($value) {
    if (!$value) {
      return false;
    } else {
      $date = date_parse($value);
      if($date['error_count'] == 0 && $date['warning_count'] == 0){
        return checkdate($date['month'], $date['day'], $date['year']);
      } else {
        return false;
      }
    }
  }

    public function IfBuyItemExists($order_no,$item_no,$stno){
        $conn=Auth()->user()->company;
        $res=buy_tran::on($conn)->where('order_no',$order_no)->where('item_no',$item_no)->first();
        if ($res) {$this->OldItemQuant=$res->quant;
                   $ras=stores::on($conn)->where('st_no',$stno)->where('item_no',$item_no)->first();
                   $this->PlaceItemQuant=$ras->raseed;
                   $this->ItemExistsInOrder=true;
                   return (true);}
        else {$this->OldItemQuant=0; $this->ItemExistsInOrder=false; return (false);}
    }
  public function IfSellItemExists($order_no,$item_no,$placetype,$stno){
    $conn=Auth()->user()->company;
    $res=sell_tran::on($conn)->where('order_no',$order_no)->where('item_no',$item_no)->first();
    if ($res) {$this->OldItemQuant=$res->quant;
               $this->RetPlaceRaseed($item_no,$placetype,$stno);
               $this->ItemExistsInOrder=true;
               return (true);}
    else {$this->OldItemQuant=0; $this->ItemExistsInOrder=false; return (false);}
  }

  public function RetPlaceRaseed($item_no,$placetype,$stno){
    $conn=Auth()->user()->company;
    if ($placetype=='Makazen')
     {$ras=stores::on($conn)->where('st_no',$stno)->where('item_no',$item_no)->first();}
    else
     {$ras=halls::on($conn)->where('hall_no',$stno)->where('item_no',$item_no)->first();}
    if ($ras) $this->PlaceItemQuant=$ras->raseed;
    else $this->PlaceItemQuant=0;
    return $this->PlaceItemQuant;
  }
 public function RetItemData($item){
     $conn=Auth()->user()->company;
  $result=items::on($conn)->where('item_no', $item)->first();
  return $result;
 }
 public function RetItemPrice($item,$pricetype){
     $conn=Auth()->user()->company;
   $pr=DB::connection($conn)->table('item_price_sell')
     ->where('price_type', '=', $pricetype)
     ->where('item_no','=',$item)
     ->first('price');
   if ($pr) return $pr->price;
   else return 0;
 }
}
