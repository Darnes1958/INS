<?php

namespace App\Http\Controllers\Salary;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
  function SalaryInp(){
    return view('backend.salary.salary_inp');
  }
  function IdrajSalary(){
    return view('backend.salary.salary_idraj');
  }
  function SalaryTrans(){
    return view('backend.salary.salary_trans');
  }
  function SalarySaheb(){
    return view('backend.salary.salary_saheb');
  }
  function RepSalary(){
    return view('backend.salary.rep-sal');
  }
    function RepSalTran(){
        return view('backend.salary.rep-sal-tran');
    }

}
