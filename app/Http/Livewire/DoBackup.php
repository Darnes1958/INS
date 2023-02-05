<?php

namespace App\Http\Livewire;

use App\Models\DownModel;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Illuminate\Support\Facades\Response;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\MediaStream;
use ZipStream\Option\Archive;

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
    public function DoDel(){
        DownModel::all()->each->delete();
    }

    public function DoDownLoad(){
      $zip_file = Auth()->user()->company.'_'.date('Ymd').'.zip'; // Name of our archive to download
      $zip = new \ZipArchive();
      $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
      $invoice_file = Auth()->user()->company.'_'.date('Ymd').'.bak';
      $res=$zip->addFile(storage_path(). "/app/".$invoice_file, $invoice_file);

      if ($res) info('yes');else info('no');

      $zip->close();
      return response()->download($zip_file);

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

      Storage::download($this->filename);


    }
    public function DoCopy(){
       Media::truncate();

        $path=storage_path().'\app\\'.Auth()->user()->company.'_'.date('Ymd').'.bak';

         DownModel::create()
            ->addMedia($path)
            ->toMediaCollection();

        $d=DownModel::last();

         $this->download($d);
      //  $fname=Auth()->user()->company.'_'.date('Ymd').'.bak';
        //storage::copy($fname, 'backup/'.$fname);
        //return Storage::download($fname);
    }
    public function download(DownModel $yourModel)
    {
        // Let's get some media.
        $downloads = $yourModel->getMedia('default');
        $zipOptions=new Archive();
        // Download the files associated with the media in a streamed way.
        // No prob if your files are very large.
        return MediaStream::create('my-files.zip')
            ->useZipOptions(function(Archive $zipOptions) {
                $zipOptions->setZeroHeader(true);
            })
            ->addMedia($downloads);
    }
    public function render()
    {
        return view('livewire.do-backup');
    }
}
