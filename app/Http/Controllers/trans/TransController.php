<?php

namespace App\Http\Controllers\trans;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransController extends Controller
{
  function TransInp(){
    return view('backend.trans.inp_trans');
  }
}
