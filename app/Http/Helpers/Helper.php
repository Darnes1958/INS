<?php
use Illuminate\Support\Facades\Auth;
 class Helper {
     public static function SetCompany(){

         return Auth::user()->company;
     }
 }

?>
