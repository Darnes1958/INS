<?php

namespace App\Http\Livewire\OverTar;

use App\Models\aksat\main;
use App\Models\OverTar\stop_kst;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class StopTable extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $no=0;
    public $acc;
    public $bank;
    public $stop_date;
    public $wrec_no;
    public $Proc;
    public $mychecked=[];

    protected $listeners = [
        'TakeNo','closeandrefresh','TakeBankNo','TakeDate'
    ];


    public function TakeNo($no){
        $this->no=$no;
    }
    public function TakeDate($date){
        $this->stop_date=$date;
    }

    public function TakeBankNo($bank){
        $this->bank=$bank;
    }
    public function selectItem($wrec_no,$action){
      $this->wrec_no=$wrec_no;
      if ($action=='delete') {$this->dispatchBrowserEvent('OpenMyDelete');}

    }
    public function CloseDeleteDialog(){$this->dispatchBrowserEvent('CloseMyDelete');}


    public function delete(){
      $this->CloseDeleteDialog();

      stop_kst::on(Auth()->user()->company)->where('rec_no',$this->wrec_no)->delete();

      $this->render();
    }

public function SaveStops(){
 DB::connection(Auth()->user()->company)->beginTransaction();
 try {
  foreach ($this->mychecked as $key=>$value)   {
   if ($value==1) {
    $res=main::on(Auth()->user()->company)->where('no',$key)->first();
    DB::connection(Auth()->user()->company)->table('stop_kst')->insert([
        'no' => $key,
        'name' => $res->name,
        'bank' => $res->bank,
        'acc' => $res->acc,
        'stop_type'=>1,
        'stop_date'=>$this->stop_date,
        'letters'=>0,
        'emp'=>auth::user()->empno,
    ]);


    }
    }
    DB::connection(Auth()->user()->company)->commit();
    $this->mychecked=[];
    $this->render();

    } catch (\Exception $e) {

    DB::connection(Auth()->user()->company)->rollback();
    $this->dispatchBrowserEvent('mmsg', 'حدث خطأ');
    }


}
   public function mount(){
        $this->stop_date=date('Y-m-d');
}
    public function render()
    {
     $stoplist=stop_kst::on(Auth()->user()->company)->select('no')->where('bank',$this->bank)->get();
     return view('livewire.over-tar.stop-table',[
        'TableList'=>DB::connection(Auth()->user()->company)->table('stop_kst')
            ->where('no',$this->no)
            ->orderBy('rec_no','asc')
            ->paginate(10),
         'TableList2'=>DB::connection(Auth()->user()->company)->table('main')
             ->where('bank',$this->bank)
             ->where('raseed','<=',0)
             ->whereNotIn('no',$stoplist)

             ->orderBy('no','asc')
             ->paginate(15),
    ]);

    }
}
