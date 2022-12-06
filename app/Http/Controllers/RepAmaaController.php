<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RepAmaaController extends Controller
{
  function RepAmma ($rep){

    return view('backend.Amma.rep-amma',compact('rep'));

  }
}
