<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\buy\rep_buy_tran;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;


use ArPHP\I18N\Arabic;


class pdfController extends Controller
{

  public function RepOrderPdf(){
    $orderdetail=rep_buy_tran::on(Auth()->user()->company)->where('order_no',20)->get();

  //  $pdf = Pdf::loadView('PrnView.buy.rep-order-buy', ['orderdetail'=>$orderdetail]);
 //   return $pdf->download('invoice.pdf');
    //$pdf = App::make('dompdf.wrapper');
    $pdf = PDF::loadView('PrnView.buy.rep-order-buy', ['orderdetail'=>$orderdetail]);
    return $pdf->stream('invoice.pdf');
 //   $reportHtml=View('PrnView.buy.rep-order-buy', ['orderdetail'=>$orderdetail])->render();
   //$arabic = new Arabic();
    //$p = $arabic->arIdentify($reportHtml);

    //for ($i = count($p)-1; $i >= 0; $i-=2) {
     //$utf8ar = $arabic->utf8Glyphs(substr($reportHtml, $p[$i-1], $p[$i] - $p[$i-1]));
      //$reportHtml = substr_replace($reportHtml, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
   //}

    //$pdf = PDF::loadHTML($reportHtml);
   //return $pdf->stream(); -->

  }  //
}
