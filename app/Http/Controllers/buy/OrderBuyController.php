<?php

namespace App\Http\Controllers\buy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use App\Models\jeha\jeha;
use App\Models\stores\stores;
use App\Models\stores\stores_names;
use App\Models\stores\items;
use App\Models\buy\buys;
use App\Models\buy\buy_tran;


class OrderBuyController extends Controller
{
    function OrderBuy (){


        $jeha=jeha::on(auth()->user()->company)->where('jeha_type',2)->where('available',1)->get();
        $stores=stores::on(auth()->user()->company)->where('raseed','>',0)->get();
        $stores_names=stores_names::on(auth()->user()->company)->get();
        $items=items::on(auth()->user()->company)->where('raseed','>',0)->get();
        $date = date('Y-m-d');


        return view('backend.buy.inp_buy', compact('jeha','stores','items','stores_names','date'));


    }
  function OrderBuyEdit (){
    return view('backend.buy.edit_buy');
  }

    function GetItemsInStore (Request $request)
    {

        $wst=$request->store_id;
        $witems = stores::on(auth()->user()->company)->with ('storeitems')
            ->where('st_no',$wst)
            ->where('raseed','>',0)->get();

        return response()->json($witems);
    }

  function OrderBuyRep (){
    return view('backend.buy.rep_buy_order');
}
    //
}
