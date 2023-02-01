<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Illuminate\Support\Facades\Response;

class DoBackup extends Component
{
    public $filename;
    public $comp;
    public function mainfunction(){
        $this->comp=Auth()->user()->company;
        $this->filename=$this->comp.'_'.date('Ymd').'.bak';
        $this->DoBackup();
     //   $this->DeleteTheFile();
    }
    public function DeleteTheFile(){
        $zip_file = Auth()->user()->company.'_'.date('Ymd').'.zip'; // Name of our archive to download

// Initializing PHP class
        $zip = new \ZipArchive();
        $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        $invoice_file = Auth()->user()->company.'_'.date('Ymd').'.bak';

// Adding file: second parameter is what will the path inside of the archive
// So it will create another folder called "storage/" inside ZIP, and put the file there.
        $zip->addFile(storage_path(). "/app/".$invoice_file, $invoice_file);
        $zip->close();

        return response()->download($zip_file);

     //   $fname=Auth()->user()->company.'_'.date('Ymd').'.bak';
     //   Storage::delete($fname);
       // Storage::delete('backup/'.$fname);

   //     $fname=Auth()->user()->company.'_'.date('Ymd').'.bak';
  //      $file= storage_path(). "/app/backup/".$fname;
  //      $headers = [
        //    'Content-Type' => 'application/bak',
      //  ];
     //   return  Response::download($file, $fname, $headers);
    //  return redirect()->to('/home');
    }
    public function DoBackup(){
        sqlsrv_configure('WarningsReturnAsErrors',0);

        $path=storage_path().'\app';

        $serverName = ".";
        $connectionInfo = array( "Database"=>"master","TrustServerCertificate"=>"True","UID"=>"hameed",
            "PWD"=>"Medo_2003", "CharacterSet" => "UTF-8");
        $conn = sqlsrv_connect( $serverName, $connectionInfo);
        $this->comp=Auth()->user()->company;
        $this->filename=$this->comp.'_'.date('Ymd').'.bak';

       // $comp=Auth()->user()->company;
       // $this->filename=$comp.'_'.date('Ymd').'.bak';
        Storage::put('file.sql', 'declare
    @path varchar(100),
    @fileDate varchar(20),
    @fileName varchar(140)

    SET @path = \''.$path.'\\\'
    SELECT @fileDate = CONVERT(VARCHAR(20), GETDATE(), 112)
    SET @fileName = @path + \''.$this->filename.'\'
    BACKUP DATABASE '.$this->comp.' TO DISK=@fileName');



        $strSQL = Storage::get('file.sql');

        //   $strSQL = file_get_contents("c:\backup\arch.sql");
        if (!empty($strSQL)) {
            $query = sqlsrv_query($conn, $strSQL);
            if ($query === false) {
                die(var_export(sqlsrv_errors(), true));
            } else {


            }
        }
    //  $this->DownloadTheFile();

        // $this->DoDownload($filename);
        //   Storage::download($filename);

        return Storage::download($this->filename);
    }
    public function DoDownLoad(){

        $fname=Auth()->user()->company.'_'.date('Ymd').'.bak';
        $file= storage_path(). "/app/".$fname;
        $headers = [
            'Content-Type' => 'application/bak',
        ];
        return  Response::download($file, $fname, $headers);
     // return Storage::download('backup/'.$fname);
    }
    public function DoCopy(){

        $fname=Auth()->user()->company.'_'.date('Ymd').'.bak';
        storage::copy($fname, 'backup/'.$fname);
        //return Storage::download($fname);
    }
    public function render()
    {
        return view('livewire.do-backup');
    }
}
