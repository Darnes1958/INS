<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Imports\FromExcelImport;
use App\Imports\FromExcelImportT;
use App\Imports\FromExcel2Import;
use App\Imports\KaemaModelImport;
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
    else
     Excel::import(new FromExcelImportT, $filename);
    FromExcelModel::on(Auth()->user()->company)->update([
        'hafitha_tajmeehy'=>$TajNo,
    ]);


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
        MahjozaModel::on(Auth()->user()->company)->update([
            'Taj'=>$TajNo,
        ]);
        DB::connection(Auth()->user()->company)->statement( DB::raw("update Mahjoza set bankcode=substring(acc,1,3) ") );
        DB::connection(Auth()->user()->company)->statement( DB::raw("update Mahjoza set bank=bank_no from bank where bank_tajmeeh='$TajNo' and bankcode=bank_code") );
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
      Excel::import(new KaemaModel2(), $filename);
    KaemaModel::on(Auth()->user()->company)->update([
      'Taj'=>$TajNo,
    ]);

    DB::connection(Auth()->user()->company)->statement( DB::raw("update Kaema set bank=bank_no from bank where bank_tajmeeh='$TajNo' and bankcode=bank_code") );
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
