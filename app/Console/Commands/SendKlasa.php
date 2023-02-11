<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;

class SendKlasa extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Daily Klasa Report via Email';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
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
