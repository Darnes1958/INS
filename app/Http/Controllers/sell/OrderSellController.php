<?php

namespace App\Http\Controllers\sell;

use App\Http\Controllers\Controller;
use App\Models\jeha\jeha;
use App\Models\stores\items;
use App\Models\stores\stores;
use App\Models\stores\stores_names;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class OrderSellController extends Controller
{
    function OrderSell($price_type){
        return view('backend.sell.inp_sell',compact('price_type'));
    }
  function OrderSellEdit (){
    return view('backend.sell.edit_sell');
  }
  function OrderSellRep (){
    return view('backend.sell.rep_sell_order');
  }
  function OrderSellRepARc (){
    return view('backend.sell.rep_sell_order_arc');
  }

}
