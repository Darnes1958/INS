<?php

namespace App\Http\Controllers\Salary;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
  function SalaryInp(){
    return view('backend.salary.salary_inp');
  }
}
