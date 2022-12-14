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
    Config::set('database.connections.other.database', Auth::user()->company);
    $main=main::all();
    $date = date('Y-m-d');
    return view('backend.aksat.InpKst', compact('main','date'));
  }
  function InpHaf (){
    Config::set('database.connections.other.database', Auth::user()->company);
    return view('backend.aksat.InpHaf');
  }
  function MainInp ($NewOld){
    Config::set('database.connections.other.database', Auth::user()->company);
    return view('backend.aksat.InpMain',compact('NewOld'));
  }
  function MainEdit ($EditDel){
    Config::set('database.connections.other.database', Auth::user()->company);
    return view('backend.aksat.EditMain',compact('EditDel'));
  }
}
