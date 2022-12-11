<?php
namespace App\Http\Livewire\Traits;

use App\Models\buy\buy_tran;
use App\Models\stores\stores;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

trait MyLib {
    public $OldItemQuant=0;
    public $PlaceItemQuant;
    public $ItemExistsInOrder=false;
    public function IfBuyItemExists($order_no,$item_no,$stno){
        Config::set('database.connections.other.database', Auth::user()->company);
        $res=buy_tran::where('order_no',$order_no)->where('item_no',$item_no)->first();
        if ($res) {$this->OldItemQuant=$res->quant;
                   $ras=stores::where('st_no',$stno)->where('item_no',$item_no)->first();
                   $this->PlaceItemQuant=$ras->raseed;
                   $this->ItemExistsInOrder=true;
                   return (true);}
        else {$this->OldItemQuant=0; $this->ItemExistsInOrder=false; return (false);}
    }
}
