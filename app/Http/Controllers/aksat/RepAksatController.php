<?php

namespace App\Http\Controllers\aksat;

use App\Http\Controllers\Controller;
use App\Models\aksat\hafitha;
use App\Models\aksat\ksm_type;
use App\Models\aksat\kst_trans;
use App\Models\aksat\kst_type;
use App\Models\aksat\main;
use App\Models\aksat\main_kst_count;
use App\Models\aksat\main_view;
use App\Models\bank\bank;
use App\Models\bank\BankTajmeehy;
use App\Models\bank\Companies;
use App\Models\bank\rep_bank;
use App\Models\bank\rep_banks;
use App\Models\Customers;
use App\Models\excel\KaemaModel;
use App\Models\excel\MahjozaModel;
use App\Models\jeha\jeha;
use App\Models\sell\rep_sell_tran;
use ArPHP\I18N\Arabic;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
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
  function RepMainArc2 (){
    return view('backend.aksat.rep.rep-main-arc2');
  }
    function RepMainAll (){
        return view('backend.aksat.rep.rep-main-all');
    }
  function RepMainDel (){
    return view('backend.aksat.rep.rep-main-del');
  }

  function RepOkod ($rep){

    return view('backend.aksat.rep.rep-okod',compact('rep'));

  }
  function PdfChk(Request $request){

    $RepDate=date('Y-m-d');
    $cus=Customers::where('Company',Auth::user()->company)->first();
    $reportHtml = view('PrnView.aksat.pdf-chk',
      ['cus'=>$cus,'bank_name'=>$request->bank_name,'name'=>$request->name,'RepDate'=>$RepDate
        ,'acc'=>$request->acc,'chk_count'=>$request->chk_count,'wdate'=>$request->wdate])->render();
    $arabic = new Arabic();
    $p = $arabic->arIdentify($reportHtml);

    for ($i = count($p)-1; $i >= 0; $i-=2) {
      $utf8ar = $arabic->utf8Glyphs(substr($reportHtml, $p[$i-1], $p[$i] - $p[$i-1]));
      $reportHtml = substr_replace($reportHtml, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
    }

    $pdf = PDF::loadHTML($reportHtml);
    return $pdf->download('report.pdf');

  }
    function PdfMahjoza($TajNo){

        $RepDate=date('Y-m-d');
        $cus=Customers::where('Company',Auth::user()->company)->first();
        $bank_name=BankTajmeehy::find($TajNo)->TajName;
        $res=main_view::whereIn('bank',function ($q) use ($TajNo){
            $q->select('bank_no')->from('bank')->where('bank_tajmeeh',$TajNo);
        })
            ->whereNotIn('acc',function ($q) use ($TajNo){
                $q->select('acc')->from('Mahjoza')->where('Taj',$TajNo);
            })
        ->get();

        $reportHtml = view('PrnView.aksat.pdf-mahjoza',
            ['cus'=>$cus,'bank_name'=>$bank_name,'date'=>$RepDate
                ,'res'=>$res])->render();
        $arabic = new Arabic();
        $p = $arabic->arIdentify($reportHtml);

        for ($i = count($p)-1; $i >= 0; $i-=2) {
            $utf8ar = $arabic->utf8Glyphs(substr($reportHtml, $p[$i-1], $p[$i] - $p[$i-1]));
            $reportHtml = substr_replace($reportHtml, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
        }

        $pdf = PDF::loadHTML($reportHtml);
        return $pdf->download('report.pdf');

    }
  function PdfPlaceKstCount( $place_name){

    $RepDate=date('Y-m-d');
    $cus=Customers::where('Company',Auth::user()->company)->first();
    $PlaceTable=main_kst_count::on(Auth()->user()->company)

      ->selectRaw('place_no,place_name,bank, bank_name, COUNT(*) AS WCOUNT, SUM(sul) AS sumsul, SUM(sul_pay) AS sumpay,
                            SUM(raseed) AS sumraseed,sum(kst_count) as kst_count,sum(kst_count_not) as kst_count_not ')

      ->where('place_name','=', $place_name)
      ->groupBy('place_no','place_name','bank','bank_name')
      ->orderBy('place_no')->get();

    $PlaceTableSum=main_kst_count::on(Auth()->user()->company)
      ->selectRaw('place_name , COUNT(*) AS WCOUNT, SUM(sul) AS sumsul, SUM(sul_pay) AS sumpay,
                            SUM(raseed) AS sumraseed,sum(kst_count) as kst_count,sum(kst_count_not) as kst_count_not ')
      ->where('place_name','=', $place_name)
      ->groupBy('place_name')->first();

    $reportHtml = view('PrnView.aksat.pdf-place-kst-count',
      ['res'=>$PlaceTable,'PlaceTableSum'=>$PlaceTableSum,'cus'=>$cus,'place_name'=>$place_name,'RepDate'=>$RepDate])->render();
    $arabic = new Arabic();
    $p = $arabic->arIdentify($reportHtml);

    for ($i = count($p)-1; $i >= 0; $i-=2) {
      $utf8ar = $arabic->utf8Glyphs(substr($reportHtml, $p[$i-1], $p[$i] - $p[$i-1]));
      $reportHtml = substr_replace($reportHtml, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
    }

    $pdf = PDF::loadHTML($reportHtml);
    return $pdf->download('report.pdf');

    $RepDate=date('Y-m-d');
    $cus=Customers::where('Company',Auth::user()->company)->first();
    $PlaceTable=main_kst_count::on(Auth()->user()->company)

        ->selectRaw('place_no,place_name,bank, bank_name, COUNT(*) AS WCOUNT, SUM(sul) AS sumsul, SUM(sul_pay) AS sumpay,
                            SUM(raseed) AS sumraseed,sum(kst_count) as kst_count,sum(kst_count_not) as kst_count_not ')

          ->where('place_name','=', $place_name)
        ->groupBy('place_no','place_name','bank','bank_name')
        ->orderBy('place_no')->get();
    $reportHtml = view('PrnView.aksat.pdf-place-kst-count',
      ['res'=>$PlaceTable,'cus'=>$cus,'place_name'=>$place_name,'RepDate'=>$RepDate])->render();
    $arabic = new Arabic();
    $p = $arabic->arIdentify($reportHtml);

    for ($i = count($p)-1; $i >= 0; $i-=2) {
      $utf8ar = $arabic->utf8Glyphs(substr($reportHtml, $p[$i-1], $p[$i] - $p[$i-1]));
      $reportHtml = substr_replace($reportHtml, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
    }

    $pdf = PDF::loadHTML($reportHtml);
    return $pdf->download('report.pdf');

  }
  function PdfBefore(Request $request){

    $RepDate=date('Y-m-d');
    $cus=Customers::where('Company',Auth::user()->company)->first();
    $RepTable= DB::connection(Auth()->user()->company)->table('main')
      ->join('late','main.no','=','late.no')
      ->selectRaw('acc,name,sul_date,sul,kst_count,sul_pay,raseed,main.kst,main.no,round((sul_pay/kst),0) pay_count,late,
                               late*main.kst kst_late')
      ->when($request->ByTajmeehy=='Bank',function ($q){
        return $q->where('bank',\request()->bank_no);
      })
      ->when($request->ByTajmeehy=='Taj',function ($q){
        return $q->whereIn('bank', function($q){
          $q->select('bank_no')->from('bank')->where('bank_tajmeeh',\request()->TajNo);});
      })

      ->when($request->Not_pay,function($q){
        return $q->where([

          ['sul_pay',0],
          ['late', '>', 0],
          ['kst','!=',0],]);})
      ->when( ! $request->Not_pay,function ($q) {
        return $q->where([

          ['late', '>', 0],
          ['kst','!=',0],]);})
      ->get(15);


    $reportHtml = view('PrnView.aksat.pdf-before',
      ['res'=>$RepTable,'cus'=>$cus,'bank_name'=>$request->bank_name,'TajName'=>$request->TajName,'ByTajmeehy'=>$request->ByTajmeehy,'month'=>$request->month,'RepDate'=>$RepDate,'Not_pay'=>$request->Not_pay])->render();
    $arabic = new Arabic();
    $p = $arabic->arIdentify($reportHtml);

    for ($i = count($p)-1; $i >= 0; $i-=2) {
      $utf8ar = $arabic->utf8Glyphs(substr($reportHtml, $p[$i-1], $p[$i] - $p[$i-1]));
      $reportHtml = substr_replace($reportHtml, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
    }

    $pdf = PDF::loadHTML($reportHtml);
    return $pdf->download('report.pdf');

  }
  function PdfKamla(Request $request){

    $RepDate=date('Y-m-d');
    $cus=Customers::where('Company',Auth::user()->company)->first();
    if ($request->RepRadio=='RepAll') {
      $first = DB::connection(Auth()->user()->company)->table('main_trans_view2')
        ->selectRaw('no,name,sul_date,sul,sul_pay,raseed,kst,bank_name,acc,order_no,max(ksm_date) as ksm_date')
          ->when($request->ByTajmeehy=='Taj',function($q) use ($request) {
              $q-> whereIn('bank', function($q) use ($request) {
                  $q->select('bank_no')->from('bank')->where('bank_tajmeeh',$request->TajNo);});
          })
          ->where('sul_pay','!=',0)

        ->whereExists(function ($query) {
          $query->select(DB::raw(1))
            ->from('late')
            ->whereColumn('main_trans_view2.no', 'late.no')
            ->where('emp', Auth::user()->empno);
        })
        ->groupBy('no', 'name', 'sul_date', 'sul', 'sul_pay', 'raseed', 'kst', 'bank_name', 'acc', 'order_no');
      $second = DB::connection(Auth()->user()->company)->table('main_view')
        ->selectraw('no,name,sul_date,sul,sul_pay,raseed,kst,bank_name,acc,order_no,null as ksm_date')
          ->when($request->ByTajmeehy=='Taj',function($q) use ($request) {
              $q-> whereIn('bank', function($q) use ($request) {
                  $q->select('bank_no')->from('bank')->where('bank_tajmeeh',$request->TajNo);});
          })
          ->where('sul_pay','=',0)

        ->whereExists(function ($query) {
          $query->select(DB::raw(1))
            ->from('late')
            ->whereColumn('main_view.no', 'late.no')
            ->where('emp', Auth::user()->empno);
        })
        ->union($first)
        ->get();
    }
    if ($request->RepRadio=='RepSome'){

      $second=DB::connection(Auth()->user()->company)->table('main_view')
          ->selectraw('no,name,sul_date,sul,sul_pay,raseed,kst,bank_name,acc,order_no,null as ksm_date')
          ->when($request->ByTajmeehy=='Taj',function($q) use ($request) {
              $q-> whereIn('bank', function($q) use ($request) {
                  $q->select('bank_no')->from('bank')->where('bank_tajmeeh',$request->TajNo);});
          })
          ->where('sul_pay','=',0)
          ->whereExists(function ($query) {
            $query->select(DB::raw(1))
              ->from('late')
              ->whereColumn('main_view.no', 'late.no')
              ->where('emp',Auth::user()->empno);
          })

          ->get();

    }



      $reportHtml = view('PrnView.aksat.pdf-kamla',
      ['res'=>$second,'cus'=>$cus,'bank_name'=>$request->bank_name,'months'=>$request->months,'RepDate'=>$RepDate,'RepRadio'=>$request->RepRadio])->render();
    $arabic = new Arabic();
    $p = $arabic->arIdentify($reportHtml);

    for ($i = count($p)-1; $i >= 0; $i-=2) {
      $utf8ar = $arabic->utf8Glyphs(substr($reportHtml, $p[$i-1], $p[$i] - $p[$i-1]));
      $reportHtml = substr_replace($reportHtml, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
    }

    $pdf = PDF::loadHTML($reportHtml);
    return $pdf->download('report.pdf');

  }
  function PdfBankOne(Request $request){

    $RepDate=date('Y-m-d');
    $cus=Customers::where('Company',Auth::user()->company)->first();
    $res=rep_bank::where('bank', '=', $request->bank_no)
      ->orderby($request->column,$request->sort)
      ->get();
   if ($request->by=='Bank')  {
       $res=rep_bank::where('bank', '=', $request->bank_no)
           ->orderby($request->column,$request->sort)
           ->get();
       $bank_name=bank::find($request->bank_no)->bank_name;
   }
   else {
       $res=rep_bank::whereIn('bank', function($q) use ($request) {
           $q->select('bank_no')->from('bank')->where('bank_tajmeeh',$request->TajNo);})
           ->get();

       $bank_name=BankTajmeehy::find($request->TajNo)->TajName;
   }
    $reportHtml = view('PrnView.aksat.pdf-bankone',
      ['res'=>$res,'cus'=>$cus,'bank_name'=>$bank_name,'RepDate'=>$RepDate])->render();
    $arabic = new Arabic();
    $p = $arabic->arIdentify($reportHtml);

    for ($i = count($p)-1; $i >= 0; $i-=2) {
      $utf8ar = $arabic->utf8Glyphs(substr($reportHtml, $p[$i-1], $p[$i] - $p[$i-1]));
      $reportHtml = substr_replace($reportHtml, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
    }

    $pdf = PDF::loadHTML($reportHtml);
    return $pdf->download('report.pdf');

  }
  function PdfKaemaNotOur( $TajNo,$bank_no){

    $RepDate=date('Y-m-d');
    $cus=Customers::where('Company',Auth::user()->company)->first();
    $ActiveBank = DB::connection(Auth::user()->company)->table('bank')->select('bank_no')->where('bank_tajmeeh', $TajNo);
    $ActiveAcc = DB::connection(Auth::user()->company)-> table('main')->select('Acc')->whereIn('bank', $ActiveBank);
    $res=KaemaModel::
    whereNotIn('acc', $ActiveAcc)
      ->when($bank_no!=0,function($q) use ($bank_no) {
        return $q->where('bank', '=', $bank_no);})
      ->get();
    $TajName=BankTajmeehy::where('TajNo',$TajNo)->first()->TajName;
    if ($bank_no!=0) $bank_name=bank::where('bank_no',$bank_no)->first()->bank_name;
    else $bank_name=null;
    $reportHtml = view('PrnView.aksat.pdf-kaemaNotOur',
      ['res'=>$res,'cus'=>$cus,'TajName'=>$TajName,'RepDate'=>$RepDate,'bank_no'=>$bank_no,'bank_name'=>$bank_name])->render();
    $arabic = new Arabic();
    $p = $arabic->arIdentify($reportHtml);

    for ($i = count($p)-1; $i >= 0; $i-=2) {
      $utf8ar = $arabic->utf8Glyphs(substr($reportHtml, $p[$i-1], $p[$i] - $p[$i-1]));
      $reportHtml = substr_replace($reportHtml, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
    }

    $pdf = PDF::loadHTML($reportHtml);
    return $pdf->download('report.pdf');

  }
  function PdfKaemaNotThere( $TajNo,$bank_no){

    $RepDate=date('Y-m-d');
    $cus=Customers::where('Company',Auth::user()->company)->first();
    $ActiveBank = DB::connection(Auth::user()->company)->table('bank')->select('bank_no')->where('bank_tajmeeh', $TajNo);
    $ActiveAcc2 = DB::connection(Auth::user()->company)-> table('Kaema')->select('Acc')->whereIn('bank', $ActiveBank);

    $res=main::
    whereNotIn('acc', $ActiveAcc2)
      ->when($bank_no!=0,function($q) use ($bank_no) {
        return $q->where('bank', '=', $bank_no);})
      ->get();
    $TajName=BankTajmeehy::where('TajNo',$TajNo)->first()->TajName;
    if ($bank_no!=0) $bank_name=bank::where('bank_no',$bank_no)->first()->bank_name;
    else $bank_name=null;

    $reportHtml = view('PrnView.aksat.pdf-kaemaNotThere',
      ['res'=>$res,'cus'=>$cus,'TajName'=>$TajName,'RepDate'=>$RepDate,'bank_no'=>$bank_no,'bank_name'=>$bank_name])->render();
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
  function PdfOver(Request $request){

    $RepDate=date('Y-m-d');
    $cus=Customers::where('Company',Auth::user()->company)->first();
    $res=DB::connection(Auth()->user()->company)->table($request->Table)
      ->whereBetween('tar_date',[$request->over_date1,$request->over_date2])

      ->where('bank', '=', $request->bank_no)
      ->where('letters',$request->letters)
      ->get();

    $reportHtml = view('PrnView.aksat.pdf-over',
      ['res'=>$res,'cus'=>$cus,'bank_name'=>$request->bank_name,'over_date1'=>$request->over_date1,
       'over_date2'=>$request->over_date2,'Table'=>$request->Table,'letters'=>$request->letters])->render();
    $arabic = new Arabic();
    $p = $arabic->arIdentify($reportHtml);

    for ($i = count($p)-1; $i >= 0; $i-=2) {
      $utf8ar = $arabic->utf8Glyphs(substr($reportHtml, $p[$i-1], $p[$i] - $p[$i-1]));
      $reportHtml = substr_replace($reportHtml, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
    }

    $pdf = PDF::loadHTML($reportHtml);
    return $pdf->download('report.pdf');

  }
  function PdfTar(Request $request){

    $RepDate=date('Y-m-d');
    $cus=Customers::where('Company',Auth::user()->company)->first();
    $res=DB::connection(Auth()->user()->company)->table('tar_kst')
      ->whereBetween('tar_date',[$request->tar_date1,$request->tar_date2])

      ->where('bank', '=', $request->bank_no)
      ->where('tar_type',$request->tar_type)
      ->get();

    $reportHtml = view('PrnView.aksat.pdf-tar',
      ['res'=>$res,'cus'=>$cus,'bank_name'=>$request->bank_name,'tar_date1'=>$request->tar_date1,
        'tar_date2'=>$request->tar_date2,'tar_type'=>$request->tar_type])->render();
    $arabic = new Arabic();
    $p = $arabic->arIdentify($reportHtml);

    for ($i = count($p)-1; $i >= 0; $i-=2) {
      $utf8ar = $arabic->utf8Glyphs(substr($reportHtml, $p[$i-1], $p[$i] - $p[$i-1]));
      $reportHtml = substr_replace($reportHtml, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
    }

    $pdf = PDF::loadHTML($reportHtml);
    return $pdf->download('report.pdf');

  }

  function PdfKsm(Request $request){

    $RepDate=date('Y-m-d');
    $cus=Customers::where('Company',Auth::user()->company)->first();
    if ($request->RepRadio=='Geted')
    $res=DB::connection(Auth()->user()->company)->table('main')
      ->join('kst_trans','main.no','=','kst_trans.no')
      ->selectRaw('main.*,kst_trans.ksm,Kst_trans.ksm_date')
      ->whereBetween('kst_trans.ksm_date',[$request->rep_date1,$request->rep_date2])
      ->where('ksm','!=',0)
      ->where('main.bank', '=', $request->bank_no)
      ->orderby('no')
      ->get();
    else
      $res=DB::connection(Auth()->user()->company)->table('main')
      ->join('kst_trans','main.no','=','kst_trans.no')
      ->selectRaw('main.no,name,sul_date,acc,sul,sul_pay,raseed,kst_count,main.kst,max(ksm_date) as ksm_date')
      ->whereNotIn('main.no',function($query) use ($request){
              $query->select('no')->from('kst_trans')
                  ->where('main.bank', '=', $request->bank_no)
                  ->where('ksm','!=',0)
                  ->whereBetween('kst_trans.ksm_date',[$request->rep_date1,$request->rep_date2]);
          })


      ->where('raseed','>',$request->baky)
      ->where('main.bank', '=', $request->bank_no)
      ->groupBy('main.no','name','sul_date','acc','sul','sul_pay','raseed','kst_count','main.kst')
      ->orderby('no')
      ->get();

    $reportHtml = view('PrnView.aksat.pdf-ksm',
      ['res'=>$res,'cus'=>$cus,'bank_name'=>$request->bank_name,'rep_date1'=>$request->rep_date1,
        'rep_date2'=>$request->rep_date2,'RepRadio'=>$request->RepRadio])->render();
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
    $TajNo=bank::on(Auth()->user()->company)->where('bank_no',$request->bank_no)->first()->bank_tajmeeh;
    $taj=BankTajmeehy::on(Auth::user()->company)->where('TajNo',$TajNo)->first();
    $company=Companies::on(Auth::user()->company)->where('CompNo',$taj->CompNo)->first();

    $reportHtml = view('PrnView.aksat.pdf-stop',
      ['res'=>$res,'cus'=>$cus,'bank_name'=>$taj->TajName,'comp_name'=>$company->CompName,'CompMan'=>$company->CompMan,'TajAcc'=>$taj->TajAcc])->render();
    $arabic = new Arabic();
    $p = $arabic->arIdentify($reportHtml);

    for ($i = count($p)-1; $i >= 0; $i-=2) {
      $utf8ar = $arabic->utf8Glyphs(substr($reportHtml, $p[$i-1], $p[$i] - $p[$i-1]));
      $reportHtml = substr_replace($reportHtml, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
    }

    $pdf = PDF::loadHTML($reportHtml);
    return $pdf->download('report.pdf');

  }
  function PdfStopOne(Request $request){

    $RepDate=date('Y-m-d');
    $cus=Customers::where('Company',Auth::user()->company)->first();

    $TajNo=$request->bank_tajmeeh;
    $taj=BankTajmeehy::on(Auth::user()->company)->where('TajNo',$TajNo)->first();
    $company=Companies::on(Auth::user()->company)->where('CompNo',$taj->CompNo)->first();

    $reportHtml = view('PrnView.aksat.pdf-stop-one',
      ['cus'=>$cus,'bank_name'=>$taj->TajName,'name'=>$request->name,'acc'=>$request->acc,
        'kst'=>$request->kst,'comp_name'=>$company->CompName,'CompMan'=>$company->CompMan,'TajAcc'=>$taj->TajAcc,'stop_date'=>$request->stop_date])->render();
    $arabic = new Arabic();
    $p = $arabic->arIdentify($reportHtml);

    for ($i = count($p)-1; $i >= 0; $i-=2) {
      $utf8ar = $arabic->utf8Glyphs(substr($reportHtml, $p[$i-1], $p[$i] - $p[$i-1]));
      $reportHtml = substr_replace($reportHtml, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
    }

    $pdf = PDF::loadHTML($reportHtml);
    return $pdf->download('report.pdf');

  }

  function PdfStopOneAll(Request $request){

    $RepDate=date('Y-m-d');
    $cus=Customers::where('Company',Auth::user()->company)->first();
    $res=DB::connection(Auth()->user()->company)->table('stop_view')
      ->whereBetween('stop_date',[$request->stop_date1,$request->stop_date2])
      ->where('bank', '=', $request->bank_no)
      ->get();

    $TajNo=bank::on(Auth()->user()->company)->where('bank_no',$request->bank_no)->first()->bank_tajmeeh;
    $taj=BankTajmeehy::on(Auth::user()->company)->where('TajNo',$TajNo)->first();
    $company=Companies::on(Auth::user()->company)->where('CompNo',$taj->CompNo)->first();

    $reportHtml = view('PrnView.aksat.pdf-stop-one-all',
      ['res'=>$res,'cus'=>$cus,'bank_name'=>$taj->TajName,'comp_name'=>$company->CompName,'CompMan'=>$company->CompMan,'TajAcc'=>$taj->TajAcc])->render();
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
    $res3=rep_sell_tran::where('order_no',$res->order_no)->get();
    $res4=MahjozaModel::where('no',$no)->first();

    $reportHtml = view('PrnView.aksat.Pdf-main',
      ['res'=>$res,'res2'=>$res2,'res3'=>$res3,'res4'=>$res4,'cus'=>$cus])->render();
    $arabic = new Arabic();
    $p = $arabic->arIdentify($reportHtml);

    for ($i = count($p)-1; $i >= 0; $i-=2) {
      $utf8ar = $arabic->utf8Glyphs(substr($reportHtml, $p[$i-1], $p[$i] - $p[$i-1]));
      $reportHtml = substr_replace($reportHtml, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
    }

    $pdf = PDF::loadHTML($reportHtml);
    return $pdf->download('report.pdf');

  }
  function PdfMainCont($no){

    $RepDate=date('Y-m-d');
    $cus=Customers::where('Company',Auth::user()->company)->first();
    $res=DB::connection(Auth()->user()->company)->table('main_view')
      ->where('no',  $no)
      ->first();

    $items=rep_sell_tran::where('order_no',$res->order_no)->get();
    $item_name='';
    foreach($items as $item) {
     $item_name=$item_name.' / '.$item->item_name;}

    $taj=bank::where('bank_no',$res->bank)->first()->bank_tajmeeh;
    $tajacc=BankTajmeehy::where('TajNo',$taj)->first()->TajAcc;


    $mindate=kst_trans::where('no',$no)->min('kst_date');
    $mdate=Carbon::parse($mindate) ;
    $mmdate=$mdate->month.'-'.$mdate->year;

    $maxdate=kst_trans::where('no',$no)->max('kst_date');
    $xdate=Carbon::parse($maxdate) ;
    $xxdate=$xdate->month.'-'.$xdate->year;

    $reportHtml = view('PrnView.aksat.Pdf-main-Cont',
      ['res'=>$res,'mindate'=>$mmdate,'maxdate'=>$xxdate,'cus'=>$cus,'TajAcc'=>$tajacc,'item_name'=>$item_name])->render();
    $arabic = new Arabic();
    $p = $arabic->arIdentify($reportHtml);

    for ($i = count($p)-1; $i >= 0; $i-=2) {
      $utf8ar = $arabic->utf8Glyphs(substr($reportHtml, $p[$i-1], $p[$i] - $p[$i-1]));
      $reportHtml = substr_replace($reportHtml, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
    }

    $pdf = PDF::loadHTML($reportHtml);
    return $pdf->download('report.pdf');

  }
  function PdfMainCont2($no){

    $RepDate=date('Y-m-d');
    $cus=Customers::where('Company',Auth::user()->company)->first();
    $res=DB::connection(Auth()->user()->company)->table('main_view')
      ->where('no',  $no)
      ->first();

    $items=rep_sell_tran::where('order_no',$res->order_no)->get();
    $item_name='';
    foreach($items as $item) {
      $item_name=$item_name.' / '.$item->item_name;}

    $taj=bank::where('bank_no',$res->bank)->first()->bank_tajmeeh;
    $tajacc=BankTajmeehy::where('TajNo',$taj)->first()->TajAcc;
    $tajname=BankTajmeehy::where('TajNo',$taj)->first()->TajName;
    $CompNo=BankTajmeehy::where('TajNo',$taj)->first()->CompNo;;
    $company=Companies::where('CompNo',$CompNo)->first();


    $mindate=kst_trans::where('no',$no)->min('kst_date');
    $mdate=Carbon::parse($mindate) ;
    $mmdate=$mdate->month.'-'.$mdate->year;

    $maxdate=kst_trans::where('no',$no)->max('kst_date');
    $xdate=Carbon::parse($maxdate) ;
    $xxdate=$xdate->month.'-'.$xdate->year;

    $jeha=jeha::where('jeha_no',$res->jeha)->first();

    $reportHtml = view('PrnView.aksat.Pdf-main-Cont2',
      ['tajname'=>$tajname,'res'=>$res,'mindate'=>$mmdate,'maxdate'=>$xxdate,'company'=>$company,'cus'=>$cus,'TajAcc'=>$tajacc,'item_name'=>$item_name,'jeha'=>$jeha])->render();
    $arabic = new Arabic();
    $p = $arabic->arIdentify($reportHtml);

    for ($i = count($p)-1; $i >= 0; $i-=2) {
      $utf8ar = $arabic->utf8Glyphs(substr($reportHtml, $p[$i-1], $p[$i] - $p[$i-1]));
      $reportHtml = substr_replace($reportHtml, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
    }

    $pdf = PDF::loadHTML($reportHtml);
    return $pdf->download('report.pdf');

  }
  function PdfMainToBank($no){

    $RepDate=date('Y-m-d');
    $cus=Customers::where('Company',Auth::user()->company)->first();
    $res=DB::connection(Auth()->user()->company)->table('main_view')
      ->where('no',  $no)
      ->first();

    $TajNo=bank::where('bank_no',$res->bank)->first()->bank_tajmeeh;
    $reportHtml = view('PrnView.aksat.Pdf-main-to-bank',
      ['res'=>$res,'TajNo'=>$TajNo,'cus'=>$cus])->render();
    $arabic = new Arabic();
    $p = $arabic->arIdentify($reportHtml);

    for ($i = count($p)-1; $i >= 0; $i-=2) {
      $utf8ar = $arabic->utf8Glyphs(substr($reportHtml, $p[$i-1], $p[$i] - $p[$i-1]));
      $reportHtml = substr_replace($reportHtml, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
    }

    $pdf = PDF::loadHTML($reportHtml);
    return $pdf->download('report.pdf');

  }


  function PdfBankSum(Request $request){

        $RepDate=date('Y-m-d');
        $cus=Customers::where('Company',Auth::user()->company)->first();

       if ($request->RepChk==1) {
         $res = DB::connection(Auth()->user()->company)->table('main_view')
           ->selectRaw('bank, bank_name, COUNT(*) AS WCOUNT, SUM(sul) AS sumsul, SUM(sul_pay) AS sumpay,
                            SUM(raseed) AS sumraseed, SUM(dofa) AS sumdofa, SUM(sul_tot) AS sumsul_tot')
           ->groupBy('bank', 'bank_name')
           ->whereBetween('sul_date', [$request->date1, $request->date2])
           ->orderby('bank')->get();
         $sul = main::on(Auth()->user()->company)->whereBetween('sul_date', [$request->date1, $request->date2])->sum('sul');
         $pay = main::on(Auth()->user()->company)->whereBetween('sul_date', [$request->date1, $request->date2])->sum('sul_pay');
         $raseed = main::on(Auth()->user()->company)->whereBetween('sul_date', [$request->date1, $request->date2])->sum('raseed');
         $count = main::on(Auth()->user()->company)->whereBetween('sul_date', [$request->date1, $request->date2])->count();
         $reportHtml = view('PrnView.aksat.pdf-bank-sum2',
           ['RepTable'=>$res,'date1'=>$request->date1,'date2'=>$request->date2,'cus'=>$cus
             ,'sul'=>$sul,'pay'=>$pay,'raseed'=>$raseed,'count'=>$count])->render();
       } else
       {
         $res=rep_banks::on(Auth()->user()->company)
           ->orderby('bank')->get();
         $sul=main::on(Auth()->user()->company)->sum('sul');
         $pay=main::on(Auth()->user()->company)->sum('sul_pay');
         $raseed=main::on(Auth()->user()->company)->sum('raseed');
         $count=main::on(Auth()->user()->company)->count();
         $reportHtml = view('PrnView.aksat.pdf-bank-sum',
           ['RepTable'=>$res,'RepDate'=>$RepDate,'cus'=>$cus
             ,'sul'=>$sul,'pay'=>$pay,'raseed'=>$raseed,'count'=>$count])->render();
       }


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
