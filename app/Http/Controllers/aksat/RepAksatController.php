<?php

namespace App\Http\Controllers\aksat;

use App\Http\Controllers\Controller;
use App\Models\aksat\main;
use App\Models\bank\rep_banks;
use App\Models\Customers;
use ArPHP\I18N\Arabic;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RepAksatController extends Controller
{
  function RepMain (){
      return view('backend.aksat.rep.rep-main');
  }
  function RepMainArc (){
    return view('backend.aksat.rep.rep-main-arc');
  }
  function RepOkod ($rep){

    return view('backend.aksat.rep.rep-okod',compact('rep'));

  }
  function PdfMain($no){

    $RepDate=date('Y-m-d');
    $cus=Customers::where('Company',Auth::user()->company)->first();
    $res=DB::connection(Auth()->user()->company)->table('main_view')
      ->where('no',  $no)
      ->first();
    $res2=DB::connection(Auth()->user()->company)->table('kst_tran_view')
      ->where('no',  $no)
      ->orderBy('ser')
      ->get();

    $reportHtml = view('PrnView.aksat.Pdf-main',
      ['res'=>$res,'res2'=>$res2,'cus'=>$cus])->render();
    $arabic = new Arabic();
    $p = $arabic->arIdentify($reportHtml);

    for ($i = count($p)-1; $i >= 0; $i-=2) {
      $utf8ar = $arabic->utf8Glyphs(substr($reportHtml, $p[$i-1], $p[$i] - $p[$i-1]));
      $reportHtml = substr_replace($reportHtml, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
    }

    $pdf = PDF::loadHTML($reportHtml);
    return $pdf->download('report.pdf');

  }
    function PdfBankSum(){

        $RepDate=date('Y-m-d');
        $cus=Customers::where('Company',Auth::user()->company)->first();

        $res=rep_banks::on(Auth()->user()->company)
            ->orderby('bank')->get();
        $sul=main::on(Auth()->user()->company)->sum('sul');
        $pay=main::on(Auth()->user()->company)->sum('sul_pay');
        $raseed=main::on(Auth()->user()->company)->sum('raseed');
        $count=main::on(Auth()->user()->company)->count();

        $reportHtml = view('PrnView.aksat.pdf-bank-sum',
            ['RepTable'=>$res,'RepDate'=>$RepDate,'cus'=>$cus
                ,'sul'=>$sul,'pay'=>$pay,'raseed'=>$raseed,'count'=>$count])->render();
        $arabic = new Arabic();
        $p = $arabic->arIdentify($reportHtml);

        for ($i = count($p)-1; $i >= 0; $i-=2) {
            $utf8ar = $arabic->utf8Glyphs(substr($reportHtml, $p[$i-1], $p[$i] - $p[$i-1]));
            $reportHtml = substr_replace($reportHtml, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
        }

        $pdf = PDF::loadHTML($reportHtml);
        return $pdf->download('report.pdf');

    }


}
