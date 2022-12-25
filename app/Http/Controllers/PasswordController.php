<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    function EditPass (){

        return view('admin.admin_change_password');

    }
}
