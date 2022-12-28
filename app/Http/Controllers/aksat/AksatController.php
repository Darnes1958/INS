<?php

namespace App\Http\Controllers\aksat;

use App\Http\Controllers\Controller;
use App\Models\aksat\main;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class AksatController extends Controller
{
  function InpKst (){

    $main=main::on(auth()->user()->company)->get();
    $date = date('Y-m-d');
    return view('backend.aksat.InpKst', compact('main','date'));
  }
  function InpHaf (){

    return view('backend.aksat.InpHaf');
  }
  function MainInp ($NewOld){

    return view('backend.aksat.InpMain',compact('NewOld'));
  }
  function MainEdit ($EditDel){

    return view('backend.aksat.EditMain',compact('EditDel'));
  }
}
