<?php

namespace App\Http\Controllers\aksat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RepAksatController extends Controller
{
  function RepMain (){
      return view('backend.aksat.rep.rep-main');
  }
  function RepMainArc (){
    return view('backend.aksat.rep.rep-main-arc');
  }
  function RepOkod ($rep){

    return view('backend.aksat.rep.rep-okod',compact('rep'));

  }

}
