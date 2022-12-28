<?php

namespace App\Http\Controllers\bank;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\bank\bank;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class BankController extends Controller
{
    function BankList ($bankno){


        $datatable=bank::on(auth()->user()->company)->get();

        return view('backend.bank.rep_bank', compact('datatable'));


    }   //
}
