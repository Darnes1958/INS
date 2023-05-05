<?php

namespace App\Http\Controllers\Exls;

use App\Exports\KhamlaXls;
use App\Exports\RepMakXls;
use App\Http\Controllers\Controller;
use App\Models\stores\RepMakzoon;
use Illuminate\Http\Request;
use App\Exports\MosdadaXls;
use Illuminate\Support\Facades\Auth;
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
  public function RepMakEX($place_type,$place_no,$withzero)
  {
    return Excel::download(new RepMakXls($place_type,$place_no,$withzero), 'RepStores.xlsx');
  }

}
