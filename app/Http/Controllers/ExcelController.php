<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Imports\FromExcelImport;
use App\Imports\FromExcel2Import;
use App\Models\excel\FromExcelModel;
use App\Models\excel\FromExcel2Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;


class ExcelController extends Controller
{
  public function ImportFromSheet(Request $request)
  {
      $filename=$request->filename;
      $TajNo=$request->TajNo;

    Excel::import(new FromExcelImport, $filename);
    FromExcelModel::on(Auth()->user()->company)->update([
        'hafitha_tajmeehy'=>$TajNo,
    ]);


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
