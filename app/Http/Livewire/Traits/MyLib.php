<?php
namespace App\Http\Livewire\Traits;

use App\Models\buy\buy_tran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

trait MyLib {
    public $OldItemQuant=0;
    public $ItemExistsInOrder=false;
    public function IfBuyItemExists($order_no,$item_no){
        Config::set('database.connections.other.database', Auth::user()->company);
        $res=buy_tran::where('order_no',$order_no)->where('item_no',$item_no)->first();
        if ($res) {$this->OldItemQuant=$res->quant; $this->ItemExistsInOrder=true; return (true);}
        else {$this->OldItemQuant=0; $this->ItemExistsInOrder=false; return (false);}
    }
}
