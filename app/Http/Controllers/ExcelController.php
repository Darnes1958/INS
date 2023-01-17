<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\excel\FromExcelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\FromExcelImport;

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
}
