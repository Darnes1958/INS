<?php

namespace App\Http\Controllers\Tar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TarController extends Controller
{
    function TarBuy(){
        return view('backend.Tar.tar_buy');
    }
}
