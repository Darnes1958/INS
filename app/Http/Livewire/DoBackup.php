<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

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
        info($this->filename);
        Storage::delete($this->filename);
        //return response()->download(storage_path('app\\'.$this->filename));
      //  return Storage::download($this->filename);
    }
    public function DoBackup(){
        sqlsrv_configure('WarningsReturnAsErrors',0);

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

    SET @path = \'D:\INS\storage\app\\\'
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
    public function render()
    {
        return view('livewire.do-backup');
    }
}
