<?php

namespace App\Http\Controllers\Masr;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MasrController extends Controller
{
    function MasrInp(){
        return view('backend.masr.masr_inp');
    }
}
