<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Zip;

class ZipController extends Controller
{
    public function build()
    {
        return Zip::create("package.zip", [
            storage_path(). '/app/'.Auth()->user()->company.'_'.date('Ymd').'.bak',

        ]);
    }
}
