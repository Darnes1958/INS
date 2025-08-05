<?php

namespace App\Http\Controllers\aksat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class OverTarController extends Controller
{
  function OverInp ($Proc){

    return view('backend.aksat.InpOverTar',compact('Proc'));
  }  //
  function StopKst2 (){

    return view('backend.aksat.InpStop2');
  }  //
}
