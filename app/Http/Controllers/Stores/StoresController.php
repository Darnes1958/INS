<?php

namespace App\Http\Controllers\Stores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StoresController extends Controller
{
  function StoresAdd($from_to){
    return view('backend.stores.stores_add',compact('from_to'));
  }
}
