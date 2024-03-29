<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Imports\FromExcelImport;
use App\Imports\FromExcelImportS;
use App\Imports\FromExcelImportT;
use App\Imports\FromExcel2Import;
use App\Imports\KaemaModelImport;
use App\Imports\KaemaModelImportT;
use App\Imports\MahjozaModelImport;
use App\Models\excel\FromExcelModel;
use App\Models\excel\FromExcel2Model;
use App\Models\excel\KaemaModel;
use App\Models\excel\MahjozaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class ExcelController extends Controller
{
  public function ImportFromSheet(Request $request)
  {
      $filename=$request->filename;
      $TajNo=$request->TajNo;

    if ($request->BankRadio=='wahda')
     Excel::import(new FromExcelImport, $filename);
    if ($request->BankRadio=='tejary')
     Excel::import(new FromExcelImportT, $filename);
    if ($request->BankRadio=='sahary')
      Excel::import(new FromExcelImportS, $filename);
    if ($request->BankRadio=='jomhoria')
      Excel::import(new FromExcelImportS, $filename);

    FromExcelModel::on(Auth()->user()->company)->update([
        'hafitha_tajmeehy'=>$TajNo,
    ]);

    if (Auth::user()->company=='Boshlak')
    {
        FromExcelModel::on(Auth()->user()->company)->
            update([ 'ksm' => DB::raw('ksm-(.05*ksm)') ]);

    }

    return redirect('/home')->with('success', 'All good!');
  }
    public function ImportMahjoza(Request $request)
    {
        $filename=$request->filename;
        $TajNo=$request->TajNo;

        if ($request->BankRadio=='wahda')
            Excel::import(new MahjozaModelImport(), $filename);
        else
            Excel::import(new MahjozaModelImport2(), $filename);

      DB::connection(Auth()->user()->company)->statement( DB::raw("update Mahjoza set Taj='$TajNo' where Taj is null") );

      if (Auth::user()->company=='BokreahAli')
      {
        if ($TajNo==3)
         DB::connection(Auth()->user()->company)->statement( DB::raw("update Mahjoza set bankcode='061' where bankcode is null") );
        if ($TajNo==7)
         DB::connection(Auth()->user()->company)->statement( DB::raw("update Mahjoza set bankcode='069'  where bankcode is null") );
        if ($TajNo==11)
              DB::connection(Auth()->user()->company)->statement( DB::raw("update Mahjoza set bankcode='032'  where bankcode is null") );

      }
      else
        DB::connection(Auth()->user()->company)->statement( DB::raw("update Mahjoza set bankcode=substring(acc,1,3) ") );
      DB::connection(Auth()->user()->company)->statement( DB::raw("update Mahjoza set bank=bank_no from bank where Taj='$TajNo' and bank_tajmeeh='$TajNo' and bankcode=bank_code") );
        DB::connection(Auth()->user()->company)->statement( DB::raw("update Mahjoza set Mahjoza.no=main.no,MainOrArc=1 from main where main.bank=Mahjoza.bank and main.acc=Mahjoza.acc") );
        DB::connection(Auth()->user()->company)->statement( DB::raw("update Mahjoza set Mahjoza.no=mainarc.no,MainOrArc=2
             from mainarc where  mainarc.bank=Mahjoza.bank and mainarc.acc=Mahjoza.acc and Mahjoza.no is null") );
        return redirect('/home')->with('success', 'All good!');
    }
  public function ImportKaema(Request $request)
  {
    $filename=$request->filename;
    $TajNo=$request->TajNo;

    if ($request->BankRadio=='wahda')
      Excel::import(new KaemaModelImport(), $filename);
    else
      Excel::import(new KaemaModelImportT(), $filename);

    DB::connection(Auth()->user()->company)->statement( DB::raw("update Kaema set Taj='$TajNo' where Taj is null") );


    if (Auth::user()->company=='BokreahAli') {

      if ($TajNo == 3)
        DB::connection(Auth()->user()->company)->statement(DB::raw("update Kaema set bankcode='061',bank=61  where Taj='$TajNo'"));

      if ($TajNo == 7)
        DB::connection(Auth()->user()->company)->statement(DB::raw("update Kaema set bankcode='069',bank=69  where Taj='$TajNo'"));

      if ($TajNo == 11)
            DB::connection(Auth()->user()->company)->statement(DB::raw("update Kaema set bankcode='032',bank=32  where Taj='$TajNo'"));

    }

  if (Auth::user()->bank!='BokreahAli')  DB::connection(Auth()->user()->company)
    ->statement( DB::raw("update Kaema set bank=bank_no from bank where Taj='$TajNo' and bank_tajmeeh='$TajNo' and bankcode=bank_code") );
    DB::connection(Auth()->user()->company)->statement( DB::raw("update Kaema set Kaema.no=main.no,MainOrArc=1 from main where main.bank=Kaema.bank and main.acc=kaema.acc") );
    DB::connection(Auth()->user()->company)->statement( DB::raw("update Kaema set Kaema.no=mainarc.no,MainOrArc=2
             from mainarc where  mainarc.bank=Kaema.bank and mainarc.acc=kaema.acc and Kaema.no is null") );
    return redirect('/home')->with('success', 'All good!');
  }
  public function ImportFromSheet2(Request $request)
  {
    $filename=$request->filename;
    $TajNo=$request->TajNo;


    Excel::import(new FromExcel2Import, $filename);



    return redirect('/home')->with('success', 'All good!');
  }
}
