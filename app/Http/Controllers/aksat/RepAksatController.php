<?php

namespace App\Http\Controllers\aksat;

use App\Http\Controllers\Controller;
use App\Models\aksat\hafitha;
use App\Models\aksat\ksm_type;
use App\Models\aksat\kst_type;
use App\Models\aksat\main;
use App\Models\bank\bank;
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
  function PdfKamla(Request $request){

    $RepDate=date('Y-m-d');
    $cus=Customers::where('Company',Auth::user()->company)->first();
    $first=DB::connection(Auth()->user()->company)->table('main_trans_view2')
      ->selectRaw('no,name,sul_date,sul,sul_pay,raseed,kst,bank_name,acc,order_no,max(ksm_date) as ksm_date')
      ->where([
        ['bank', '=', $request->bank_no],
        ['sul_pay','!=',0],])
      ->whereExists(function ($query) {
        $query->select(DB::raw(1))
          ->from('late')
          ->whereColumn('main_trans_view2.no', 'late.no')
          ->where('emp',Auth::user()->empno);
      })
      ->groupBy('no','name','sul_date','sul','sul_pay','raseed','kst','bank_name','acc','order_no');
    $second=DB::connection(Auth()->user()->company)->table('main_view')
      ->selectraw('no,name,sul_date,sul,sul_pay,raseed,kst,bank_name,acc,order_no,null as ksm_date')
      ->where([
        ['bank', '=', $request->bank_no],
        ['sul_pay',0],])
      ->whereExists(function ($query) {
        $query->select(DB::raw(1))
          ->from('late')
          ->whereColumn('main_view.no', 'late.no')
          ->where('emp',Auth::user()->empno);
      })
      ->union($first)
      ->get();

    $reportHtml = view('PrnView.aksat.pdf-kamla',
      ['res'=>$second,'cus'=>$cus,'bank_name'=>$request->bank_name,'months'=>$request->months,'RepDate'=>$RepDate])->render();
    $arabic = new Arabic();
    $p = $arabic->arIdentify($reportHtml);

    for ($i = count($p)-1; $i >= 0; $i-=2) {
      $utf8ar = $arabic->utf8Glyphs(substr($reportHtml, $p[$i-1], $p[$i] - $p[$i-1]));
      $reportHtml = substr_replace($reportHtml, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
    }

    $pdf = PDF::loadHTML($reportHtml);
    return $pdf->download('report.pdf');

  }
  function PdfWrong(Request $request){

    $RepDate=date('Y-m-d');
    $cus=Customers::where('Company',Auth::user()->company)->first();
    $res=DB::connection(Auth()->user()->company)->table('wrong_view')
      ->whereBetween('tar_date',[$request->wrong_date1,$request->wrong_date2])
      ->where('bank', '=', $request->bank_no)
      ->get();

    $reportHtml = view('PrnView.aksat.pdf-wrong',
      ['res'=>$res,'cus'=>$cus,'bank_name'=>$request->bank_name,'wrong_date1'=>$request->wrong_date1,'wrong_date2'=>$request->wrong_date2])->render();
    $arabic = new Arabic();
    $p = $arabic->arIdentify($reportHtml);

    for ($i = count($p)-1; $i >= 0; $i-=2) {
      $utf8ar = $arabic->utf8Glyphs(substr($reportHtml, $p[$i-1], $p[$i] - $p[$i-1]));
      $reportHtml = substr_replace($reportHtml, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
    }

    $pdf = PDF::loadHTML($reportHtml);
    return $pdf->download('report.pdf');

  }
  function PdfStop(Request $request){

    $RepDate=date('Y-m-d');
    $cus=Customers::where('Company',Auth::user()->company)->first();
    $res=DB::connection(Auth()->user()->company)->table('stop_view')
      ->whereBetween('stop_date',[$request->stop_date1,$request->stop_date2])
      ->where('bank', '=', $request->bank_no)
      ->get();

    $reportHtml = view('PrnView.aksat.pdf-stop',
      ['res'=>$res,'cus'=>$cus,'bank_name'=>$request->bank_name,'stop_date1'=>$request->stop_date1,'stop_date2'=>$request->stop_date2])->render();
    $arabic = new Arabic();
    $p = $arabic->arIdentify($reportHtml);

    for ($i = count($p)-1; $i >= 0; $i-=2) {
      $utf8ar = $arabic->utf8Glyphs(substr($reportHtml, $p[$i-1], $p[$i] - $p[$i-1]));
      $reportHtml = substr_replace($reportHtml, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
    }

    $pdf = PDF::loadHTML($reportHtml);
    return $pdf->download('report.pdf');

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
    public function PdfHafMini(Request $request){
        $RepDate=date('Y-m-d');
        $cus=Customers::where('Company',Auth::user()->company)->first();
        $res = DB::connection(Auth()->user()->company)
            ->table('hafitha_tran_view')
            ->where('hafitha_no',  $request->hafitha)
            ->where('kst_type',  $request->rep_type)
            ->when( $request->DisRadio=='DisMe', function($q)  {
                return $q->where(   'emp',Auth::user()->empno); })
            ->orderBy('acc','asc')
            ->orderBy('ser_in_hafitha','asc')->get();
        $bank_no=hafitha::on(Auth()->user()->company)->find($request->hafitha)->bank;
        $bank_name=bank::on(Auth()->user()->company)->find($bank_no)->bank_name;
        $kst_type_name=kst_type::on(Auth()->user()->company)->find($request->rep_type)->kst_type_name;
        if ($request->DisRadio=='DisMe'){
            $who='مدخلة بواسطة : '.Auth()->user()->name;
        } else $who='';

        $reportHtml = view('PrnView.aksat.pdf-haf-mini',
            ['RepTable'=>$res,'cus'=>$cus,'bank_name'=>$bank_name,'kst_type_name'=>$kst_type_name
                ,'hafitha'=>$request->hafitha ,'who'=>$who ,'RepDate'=>$RepDate])->render();
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
