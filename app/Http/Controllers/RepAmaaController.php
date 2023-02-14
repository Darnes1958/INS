<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use ArPHP\I18N\Arabic;
use Illuminate\Support\Facades\Storage;

class RepAmaaController extends Controller
{
  function RepAmma ($rep){

    return view('backend.Amma.rep-amma',compact('rep'));

  }
  function PdfKlasa(Request $request){
    $date1=$request->date1;
    $date2=$request->date2;
    $RepDate=date('Y-m-d');
    $cus=Customers::where('Company',Auth::user()->company)->first();
    $BuyTable=DB::connection(Auth()->user()->company)->table('buys')
      ->join('price_type','buys.price_type','=','price_type.type_no')
      ->join('stores_names','buys.place_no','=','stores_names.st_no')
      ->whereBetween('order_date',[$date1,$date2])
      ->selectRaw('stores_names.st_no place_no,st_name as place_name,type_no,type_name,
                                 sum(tot1) as tot1,sum(ksm) as ksm,sum(tot) as tot,sum(cash) as cash,sum(not_cash) as not_cash')
      ->groupBy('stores_names.st_no','st_name','type_no','type_name')->get();
    $SellTableMak=DB::connection(Auth()->user()->company)->table('sells')
      ->join('price_type','sells.price_type','=','price_type.type_no')
      ->join('stores_names','sells.place_no','=','stores_names.st_no')
      ->where('sell_type',1)
      ->whereBetween('order_date',[$date1,$date2])
      ->selectRaw('stores_names.st_no place_no,st_name as place_name,type_no,type_name,
                                 sum(tot1) as tot1,sum(ksm) as ksm,sum(tot) as tot,sum(cash) as cash,sum(not_cash) as not_cash')
      ->groupBy('stores_names.st_no','st_name','type_no','type_name')->get();
    $SellTableSalat=DB::connection(Auth()->user()->company)->table('sells')
      ->join('price_type','sells.price_type','=','price_type.type_no')
      ->join('halls_names','sells.place_no','=','halls_names.hall_no')
      ->where('sell_type',2)
      ->whereBetween('order_date',[$date1,$date2])
      ->selectRaw('halls_names.hall_no place_no,hall_name as place_name,type_no,type_name,
                                     sum(tot1) as tot1,sum(ksm) as ksm,sum(tot) as tot,sum(cash) as cash,sum(not_cash) as not_cash')
      ->groupBy('halls_names.hall_no','hall_name','type_no','type_name')->get();
    $TransTableImp=DB::connection(Auth()->user()->company)->table('trans')
      ->join('price_type','trans.tran_type','=','price_type.type_no')
      ->join('tran_who','trans.tran_who','=','tran_who.who_no')
      ->where('imp_exp',1)
      ->whereBetween('tran_date',[$date1,$date2])
      ->selectRaw('imp_exp,who_no,who_name,type_no,type_name,sum(val) as val')
      ->groupBy('imp_exp','who_no','who_name','type_no','type_name')->get();
     $TransTableExp=DB::connection(Auth()->user()->company)->table('trans')
      ->join('price_type','trans.tran_type','=','price_type.type_no')
      ->join('tran_who','trans.tran_who','=','tran_who.who_no')
      ->where('imp_exp',2)
      ->whereBetween('tran_date',[$date1,$date2])
      ->selectRaw('imp_exp,who_no,who_name,type_no,type_name,sum(val) as val')
      ->groupBy('imp_exp','who_no','who_name','type_no','type_name')->get();

    $reportHtml = view('PrnView.amma.pdf-klasa',
      ['BuyTable'=>$BuyTable,'SellTableMak'=>$SellTableMak,'SellTableSalat'=>$SellTableSalat,
        'TransTableImp'=>$TransTableImp,'TransTableExp'=>$TransTableExp,'date1'=>$date1,'date2'=>$date2,'cus'=>$cus])->render();
    $arabic = new Arabic();
    $p = $arabic->arIdentify($reportHtml);
    for ($i = count($p)-1; $i >= 0; $i-=2) {
      $utf8ar = $arabic->utf8Glyphs(substr($reportHtml, $p[$i-1], $p[$i] - $p[$i-1]));
      $reportHtml = substr_replace($reportHtml, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
    }
    $pdf = PDF::loadHTML($reportHtml);

    return $pdf->download('report.pdf');
  }
    function PdfKlasaMail($company){
        $date1=date('Y-m-d',strtotime("-1 days"));
        $date2=date('Y-m-d',strtotime("-1 days"));
        $RepDate=date('Y-m-d',strtotime("-1 days"));
        $cus=Customers::where('Company',$company)->first();
        $BuyTable=DB::connection($company)->table('buys')
            ->join('price_type','buys.price_type','=','price_type.type_no')
            ->join('stores_names','buys.place_no','=','stores_names.st_no')
            ->whereBetween('order_date',[$date1,$date2])
            ->selectRaw('stores_names.st_no place_no,st_name as place_name,type_no,type_name,
                                 sum(tot1) as tot1,sum(ksm) as ksm,sum(tot) as tot,sum(cash) as cash,sum(not_cash) as not_cash')
            ->groupBy('stores_names.st_no','st_name','type_no','type_name')->get();
        $SellTableMak=DB::connection($company)->table('sells')
            ->join('price_type','sells.price_type','=','price_type.type_no')
            ->join('stores_names','sells.place_no','=','stores_names.st_no')
            ->where('sell_type',1)
            ->whereBetween('order_date',[$date1,$date2])
            ->selectRaw('stores_names.st_no place_no,st_name as place_name,type_no,type_name,
                                 sum(tot1) as tot1,sum(ksm) as ksm,sum(tot) as tot,sum(cash) as cash,sum(not_cash) as not_cash')
            ->groupBy('stores_names.st_no','st_name','type_no','type_name')->get();
        $SellTableSalat=DB::connection($company)->table('sells')
            ->join('price_type','sells.price_type','=','price_type.type_no')
            ->join('halls_names','sells.place_no','=','halls_names.hall_no')
            ->where('sell_type',2)
            ->whereBetween('order_date',[$date1,$date2])
            ->selectRaw('halls_names.hall_no place_no,hall_name as place_name,type_no,type_name,
                                     sum(tot1) as tot1,sum(ksm) as ksm,sum(tot) as tot,sum(cash) as cash,sum(not_cash) as not_cash')
            ->groupBy('halls_names.hall_no','hall_name','type_no','type_name')->get();
        $TransTableImp=DB::connection($company)->table('trans')
            ->join('price_type','trans.tran_type','=','price_type.type_no')
            ->join('tran_who','trans.tran_who','=','tran_who.who_no')
            ->where('imp_exp',1)
            ->whereBetween('tran_date',[$date1,$date2])
            ->selectRaw('imp_exp,who_no,who_name,type_no,type_name,sum(val) as val')
            ->groupBy('imp_exp','who_no','who_name','type_no','type_name')->get();
        $TransTableExp=DB::connection($company)->table('trans')
            ->join('price_type','trans.tran_type','=','price_type.type_no')
            ->join('tran_who','trans.tran_who','=','tran_who.who_no')
            ->where('imp_exp',2)
            ->whereBetween('tran_date',[$date1,$date2])
            ->selectRaw('imp_exp,who_no,who_name,type_no,type_name,sum(val) as val')
            ->groupBy('imp_exp','who_no','who_name','type_no','type_name')->get();

        $reportHtml = view('PrnView.amma.pdf-klasa',
            ['BuyTable'=>$BuyTable,'SellTableMak'=>$SellTableMak,'SellTableSalat'=>$SellTableSalat,
                'TransTableImp'=>$TransTableImp,'TransTableExp'=>$TransTableExp,'date1'=>$date1,'date2'=>$date2,'cus'=>$cus])->render();
        $arabic = new Arabic();
        $p = $arabic->arIdentify($reportHtml);
        for ($i = count($p)-1; $i >= 0; $i-=2) {
            $utf8ar = $arabic->utf8Glyphs(substr($reportHtml, $p[$i-1], $p[$i] - $p[$i-1]));
            $reportHtml = substr_replace($reportHtml, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
        }
        $pdf = PDF::loadHTML($reportHtml);
        Storage::put('public/upload/invoice.pdf', $pdf->output());


    }
}
