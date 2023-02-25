<?php

namespace App\Http\Controllers\Exls;

use App\Exports\KhamlaXls;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\MosdadaXls;
use Maatwebsite\Excel\Facades\Excel;

class ExController extends Controller
{
    public function MosdadaEX($bank,$baky)
    {
        return Excel::download(new MosdadaXls($bank,$baky), 'Mosdada.xlsx');
    }
    public function KhamlaEX($bank,$baky)
    {
        return Excel::download(new KhamlaXls($bank,$baky), 'Khamla.xlsx');
    }
}
