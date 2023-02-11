<?php

namespace App\Http\Controllers\email;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Mail;

class EmailPdf extends Controller
{
    public function KlasaPdf (){
        $data["email"] = "abdel_ati_m@yahoo.com";
        $data["title"] = "From Alwaseetlibya.ly";
        $data["body"] = "تقرير الخلاصة";

        $files = [

            storage_path('app/public/upload/invoice.pdf'),
        ];

        Mail::send('emails.myTestMail', $data, function($message)use($data, $files) {
            $message->to($data["email"], $data["email"])
                ->subject($data["title"]);

            foreach ($files as $file){
                $message->attach($file);
            }

        });
    }
}
