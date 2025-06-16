<?php

namespace App\Http\Controllers\Stores;

use App\Http\Controllers\Controller;
use App\Models\Customers;

use App\Models\stores\place_view;
use App\Models\stores\RepMakzoon;
use ArPHP\I18N\Arabic;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StoresController extends Controller
{
  function JaradRaseed(){
    return view('backend.stores.jarad');
  }
    function JaradRaseed2(){
        return view('backend.stores.jarad2');
    }

    function StoresAdd($from_to){
    return view('backend.stores.stores_add',compact('from_to'));
  }
    function ItemPrices(){
        return view('backend.stores.item-prices');
    }
    function ItemDamage(){
        return view('backend.stores.item-damage');
    }
  function RepPerPdf(Request $request){

    $RepDate=date('Y-m-d');
    $cus=Customers::where('Company',Auth::user()->company)->first();
    $res=DB::connection(Auth()->user()->company)->table('store_exp_view')->where('per_no',$request->per_no)->first();
    $res2=DB::connection(Auth()->user()->company)->table('store_exp_view')->where('per_no',$request->per_no)->get();

    $reportHtml = view('PrnView.amma.Pdf-Per',
      ['res'=>$res,'res2'=>$res2,'cus'=>$cus,'per_no'=>$request->per_no])->render();
    $arabic = new Arabic();
    $p = $arabic->arIdentify($reportHtml);

    for ($i = count($p)-1; $i >= 0; $i-=2) {
      $utf8ar = $arabic->utf8Glyphs(substr($reportHtml, $p[$i-1], $p[$i] - $p[$i-1]));
      $reportHtml = substr_replace($reportHtml, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
    }
    $pdf = PDF::loadHTML($reportHtml);
    return $pdf->download('report.pdf');
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
  function PdfItemKsmTran(Request $request){
    $RepDate=date('Y-m-d');
    $cus=Customers::where('Company',Auth::user()->company)->first();

    $first=DB::connection(Auth()->user()->company)->table('main')
      ->join('kst_trans','main.no','=','kst_trans.no')
      ->join('sell_tran','main.order_no','=','sell_tran.order_no')
      ->selectRaw('main.no,acc,name,ksm_date,ksm,\'قائم\'as MainOrArc' )
      ->where('item_no',$request->item_no)
      ->where('ksm_date','>=',$request->tran_date)
      ->where('kst_trans.ksm','!=',null)
      ->where('kst_trans.ksm','!=',0);

    $second=DB::connection(Auth()->user()->company)->table('mainarc')
      ->join('transarc','mainarc.no','=','transarc.no')
      ->join('sell_tran','mainarc.order_no','=','sell_tran.order_no')
      ->selectRaw('mainarc.no,acc,name,ksm_date,ksm,\'أرشيف\'as MainOrArc')
      ->where('item_no',$request->item_no)
      ->where('ksm_date','>=',$request->tran_date)
      ->where('transarc.ksm','!=',null)
      ->where('transarc.ksm','!=',0)
      ->unionAll($first)
      ->orderBy('ksm_date')
      ->get();
    $res=$second;
    $SumKsm=$second->sum('ksm');


    $reportHtml = view('PrnView.amma.pdf-item-ksm-tran',
      ['RepTable'=>$res,'cus'=>$cus,'item_name'=>$request->item_name,'tran_date'=>$request->tran_date,'SumKsm'=>$SumKsm])->render();
    $arabic = new Arabic();
    $p = $arabic->arIdentify($reportHtml);

    for ($i = count($p)-1; $i >= 0; $i-=2) {
      $utf8ar = $arabic->utf8Glyphs(substr($reportHtml, $p[$i-1], $p[$i] - $p[$i-1]));
      $reportHtml = substr_replace($reportHtml, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
    }
    $pdf = PDF::loadHTML($reportHtml);
    return $pdf->download('report.pdf');
  }
  function RepMakPdf(Request $request){

    $RepDate=date('Y-m-d');
    $cus=Customers::where('Company',Auth::user()->company)->first();
    $place_type=$request->place_type;
    $place_no=$request->place_no;
    $res=RepMakzoon::
      when($request->place_no!=0,function ($q) use ($place_no){
       return $q->where('place_no','=', $place_no) ;     })
      ->when($request->place_no!=0,function  ($q )  use ($place_type) {
       return $q->where('place_type','=', $place_type) ;     })
        ->when( $request->withzero==0,function ($q) {
            return $q->where('raseed','!=', 0) ;     })
        ->when( $request->withzero==0,function ($q) {
            return $q->where('place_ras','!=', 0) ;     })
      ->where('place_type',$place_type)
      ->orderBy('item_type','asc')
      ->orderBy('item_no','asc')
      ->get();

    $item_type=RepMakzoon::select('type_name')->where('place_type',$place_type)->where('place_no',$place_no)->groupby('type_name')->orderby('type_name')->get();
    $reportHtml = view('PrnView.amma.pdf-mak-jarad',
      ['res'=>$res,'cus'=>$cus,'item_type'=>$item_type,])->render();
    $arabic = new Arabic();
    $p = $arabic->arIdentify($reportHtml);

    for ($i = count($p)-1; $i >= 0; $i-=2) {
      $utf8ar = $arabic->utf8Glyphs(substr($reportHtml, $p[$i-1], $p[$i] - $p[$i-1]));
      $reportHtml = substr_replace($reportHtml, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
    }

    $pdf = PDF::loadHTML($reportHtml);
    return $pdf->download('report.pdf');

  }
    function RepMakPdf2(Request $request){

        $RepDate=date('Y-m-d');
        $cus=Customers::where('Company',Auth::user()->company)->first();
        $place_type=$request->place_type;
        $place_no=$request->place_no;

        $place_name=place_view::where('place_type',$place_type+1)
            ->where('place_no',$place_no)->first()->place_name;
        $res=RepMakzoon::
        when($request->place_no!=0,function ($q) use ($place_no){
            return $q->where('place_no','=', $place_no) ;     })
            ->when($request->place_no!=0,function  ($q )  use ($place_type) {
                return $q->where('place_type','=', $place_type) ;     })
            ->when($request->withzero==0,function ($q){
                return $q->where('raseed','!=',0);
            })
            ->when( $request->withzero==0,function ($q) {
                return $q->where('raseed','!=', 0) ;     })
            ->when( $request->withzero==0,function ($q) {
                return $q->where('place_ras','!=', 0) ;     })
            ->where('place_type',$place_type)
            ->orderBy('item_type','asc')
            ->orderBy('item_no','asc')
            ->get();

        $item_type=RepMakzoon::select('type_name')->where('place_type',$place_type)->where('place_no',$place_no)->groupby('type_name')->orderby('type_name')->get();
        $reportHtml = view('PrnView.amma.pdf-mak',
            ['place_name'=>$place_name,'res'=>$res,'cus'=>$cus,'item_type'=>$item_type,])->render();
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
