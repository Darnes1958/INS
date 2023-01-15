<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\buy\buys;
use App\Models\buy\rep_buy_tran;
use App\Models\Customers;
use App\Models\jeha\jeha;
use App\Models\stores\stores_names;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\PDO;



use ArPHP\I18N\Arabic;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class pdfController extends Controller
{

  function DoBackup(){

  //  DB::unprepared(DB::raw("BACKUP DATABASE Daibany TO DISK = 'c:\backup\backup.bak'"));
    sqlsrv_configure('WarningsReturnAsErrors',0);

    $serverName = ".";
    $connectionInfo = array( "Database"=>"master","TrustServerCertificate"=>"True","UID"=>"hameed",
      "PWD"=>"Medo_2003", "CharacterSet" => "UTF-8");
    $conn = sqlsrv_connect( $serverName, $connectionInfo);
    $connectionInfo = array(
      "UID"=>"user",
      "PWD"=>"password",
      "Database"=>"ProdDB"
    );
  if( $conn === false )
  {
    info("Could not connect.");

  }
 else {info('connect');}
$comp=Auth()->user()->company;
    $filename=$comp.'_'.date('Ymd').'.bak';
    Storage::download($filename);
    info($filename);

    Storage::put('file.sql', 'declare 
    @path varchar(100),
    @fileDate varchar(20),
    @fileName varchar(140)

    SET @path = \'D:\INS\storage\app\ \'   
    SELECT @fileDate = CONVERT(VARCHAR(20), GETDATE(), 112)  
    SET @fileName = @path + \''.$filename.'\'  
    BACKUP DATABASE '.$comp.' TO DISK=@fileName');


    $strSQL = Storage::get('file.sql');
 //   $strSQL = file_get_contents("c:\backup\arch.sql");
    if (!empty($strSQL)) {
      $query = sqlsrv_query($conn, $strSQL);
      if ($query === false) {
        die(var_export(sqlsrv_errors(), true));
      } else {
        sleep(5);
        echo "Success";
      }
    }
    sleep(5);
  return  Storage::download($filename);
  //  Storage::delete($filename);

  }
   function RepOrderPdf(Request $request){
    $order_no=$request->order_no;
    $res=buys::on(Auth()->user()->company)->where('order_no',$order_no)->first();
    if ($order_no==null || $order_no==0 || !$res) return(false);
    $cus=Customers::where('Company',Auth::user()->company)->first();
    $jeha_name=$request->jeha_name;
    $place_name=$request->place_name;
    $orderdetail=rep_buy_tran::on(Auth()->user()->company)->where('order_no',$order_no)->get();
    $res=buys::on(Auth()->user()->company)->where('order_no',$order_no)->first();


  //  return view('PrnView.buy.rep-order-buy',compact('orderdetail','res'));
   //   $pdf = Pdf::loadView('PrnView.buy.rep-order-buy',
     //     ['orderdetail'=>$orderdetail,'res'=>$res,'cus'=>$cus,'jeha_name'=>$jeha_name,'place_name'=>$place_name]);

     // return $pdf->download('invoice.pdf');

      $reportHtml = view('PrnView.buy.rep-order-buy',
          ['orderdetail'=>$orderdetail,'res'=>$res,'cus'=>$cus,'jeha_name'=>$jeha_name,'place_name'=>$place_name])->render();
      $arabic = new Arabic();
      $p = $arabic->arIdentify($reportHtml);

      for ($i = count($p)-1; $i >= 0; $i-=2) {
          $utf8ar = $arabic->utf8Glyphs(substr($reportHtml, $p[$i-1], $p[$i] - $p[$i-1]));
          $reportHtml = substr_replace($reportHtml, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
      }

      $pdf = PDF::loadHTML($reportHtml);
      return $pdf->download('invoice.pdf');

  }
    public function PdfMosdada(Request $request){

        $RepDate=date('Y-m-d');
        $cus=Customers::where('Company',Auth::user()->company)->first();
        $res=DB::connection(Auth()->user()->company)->table('main_view')
            ->where('bank',  $request->bank_no)
            ->where('raseed','<=',$request->baky)
            ->get();
        $sum=DB::connection(Auth()->user()->company)->table('main')
            ->selectRaw('sum(sul_tot) as sul_tot,sum(dofa) as dofa,sum(sul) as sul,
             sum(sul_pay) as sul_pay,sum(raseed) as raseed')
            ->where('bank',  $request->bank_no)
            ->where('raseed','<=',$request->baky)
            ->first();
        $reportHtml = view('PrnView.aksat.pdf-mosdada',
            ['pdfdetail'=>$res,'cus'=>$cus,'bank_name'=>$request->bank_name,'sum'=>$sum,'RepDate'=>$RepDate])->render();
        $arabic = new Arabic();
        $p = $arabic->arIdentify($reportHtml);

        for ($i = count($p)-1; $i >= 0; $i-=2) {
            $utf8ar = $arabic->utf8Glyphs(substr($reportHtml, $p[$i-1], $p[$i] - $p[$i-1]));
            $reportHtml = substr_replace($reportHtml, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
        }

        $pdf = PDF::loadHTML($reportHtml);
        return $pdf->download('report.pdf');

      //  $pdf = Pdf::loadView('PrnView.aksat.pdf-mosdada',
       //     ['pdfdetail'=>$res,'cus'=>$cus,'bank_name'=>$request->bank_name]);

      //  return $pdf->download('mosdada.pdf');

    }
}
