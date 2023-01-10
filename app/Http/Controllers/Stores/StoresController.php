<?php

namespace App\Http\Controllers\Stores;

use App\Http\Controllers\Controller;
use App\Models\Customers;

use ArPHP\I18N\Arabic;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StoresController extends Controller
{
  function StoresAdd($from_to){
    return view('backend.stores.stores_add',compact('from_to'));
  }
  function PdfItemTran(Request $request){
    $RepDate=date('Y-m-d');
    $cus=Customers::where('Company',Auth::user()->company)->first();
    $res = DB::connection(Auth()->user()->company)->table('rep_item_tran')
      ->where('item_no',$request->item_no)
      ->where('order_date','>=',$request->tran_date)->get();

    $reportHtml = view('PrnView.amma.pdf-item-tran',
      ['RepTable'=>$res,'cus'=>$cus,'item_name'=>$request->item_name,'tran_date'=>$request->tran_date])->render();
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
