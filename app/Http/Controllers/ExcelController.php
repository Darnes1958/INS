<?php

namespace App\Http\Controllers;

use App\Events\ExcelLoaded;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\FromExcelImport;

class ExcelController extends Controller
{
  public function ImportFromSheet($filename)
  {

    Excel::import(new FromExcelImport, $filename);


    return redirect('/home')->with('success', 'All good!');
  }
}
