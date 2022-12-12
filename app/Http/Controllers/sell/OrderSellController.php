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
    function OrderSell(){
        return view('backend.sell.inp_sell');
    }
  function OrderSellEdit (){
    return view('backend.sell.edit_sell');
  }
}
