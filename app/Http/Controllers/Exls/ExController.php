<?php

namespace App\Http\Controllers\Exls;

use App\Exports\BankoneXls;
use App\Exports\DefferXls;
use App\Exports\KhamlaXls;
use App\Exports\KlasaXls;
use App\Exports\NotThereXls;
use App\Exports\RepMakXls;
use App\Http\Controllers\Controller;
use App\Models\stores\RepMakzoon;
use Illuminate\Http\Request;
use App\Exports\MosdadaXls;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;


class ExController extends Controller
{
    public function BankoneEX($by,$taj,$bank)
    {


        return Excel::download(new BankoneXls($by,$taj,$bank), 'BankOne.xlsx');
    }
    public function MosdadaEX($bank,$baky)
    {
        return Excel::download(new MosdadaXls($bank,$baky), 'Mosdada.xlsx');
    }
  public function DefferEX($bank,$deffer)
  {
    return Excel::download(new DefferXls($bank,$deffer), 'Deffer.xlsx');
  }
    public function NotThereEX($bank_no,$TajNo)
    {
        return Excel::download(new NotThereXls($bank_no,$TajNo), 'NotThere.xlsx');
    }
    public function KhamlaEX($bank,$baky,$repradio)
    {
        return Excel::download(new KhamlaXls($bank,$baky,$repradio), 'Khamla.xlsx');
    }
  public function RepMakEX($place_type,$place_no,$withzero)
  {
    return Excel::download(new RepMakXls($place_type,$place_no,$withzero), 'RepStores.xlsx');
  }
  public function KlasaEX($date1,$date2)
  {
    return Excel::download(new KlasaXls($date1,$date2), 'RepKlasa.xlsx');
  }
}
