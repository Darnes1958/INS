<?php

namespace App\Http\Livewire\OverTar;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class TarTable extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';
  public $bankno=0;
  public $search;
  public $mychecked=[];
  public $Proc='over_kst';
  public $tar_date;
  public $ksm_type;
  protected $listeners = [
    'TakeBank','TakeProc','SaveTar',
  ];

  public function TakeProc($proc){
    $this->Proc=$proc;
  }
  public function updatedMychecked(){
    $bankget=false;
    foreach ($this->mychecked as $key=>$value) {
      if ($value == 1) {
        $bankget=true;
        break;
      }
    }
    $this->emit('TakeBankGet',$bankget);
  }

  public function SaveTar($tar_date,$ksm_type){
    DB::connection(Auth()->user()->company)->beginTransaction();
    try {
    foreach ($this->mychecked as $key=>$value)
    {
     if ($value==1) {

       $res = DB::connection(Auth()->user()->company)->table($this->Proc)->where('wrec_no', $key)->first();
       if ($this->Proc == 'over_kst' || $this->Proc == 'over_kst_a') {
         $tar_type = 1;
         $field='letters';
         $no=$res->no;
       }
       if ($this->Proc == 'wrong_kst') {
         $tar_type = 2;
         $field='morahel';
         $no=0;
       }

       if ($res) {
         DB::connection(Auth()->user()->company)->table('tar_kst')->insert([
           'no' => $no,
           'name' => $res->name,
           'bank' => $res->bank,
           'acc' => $res->acc,
           'kst' => $res->kst,
           'tar_type' => $tar_type,
           'tar_date' => $tar_date,
           'ksm_date' => null,
           'ser' => 0,
           'kst_date' => null,
           'emp' => Auth::user()->empno,
           'ksm_type' => $ksm_type,
         ]);
         DB::connection(Auth()->user()->company)->table($this->Proc)->where('wrec_no',$key)->update([$field=>1]);

       }
     }}
        DB::connection(Auth()->user()->company)->commit();
        $this->mychecked=[];
        $this->render();

      } catch (\Exception $e) {

        DB::connection(Auth()->user()->company)->rollback();
        $this->dispatchBrowserEvent('mmsg', 'حدث خطأ');
      }


    }


  public function TakeBank($bankno){
    $this->bankno=$bankno;
  }

    public function render()
    {

      if ($this->Proc=='over_kst')
      $data=DB::connection(Auth()->user()->company)->table('over_kst')
        ->selectRaw('no,acc,name,letters as morahel,kst,tar_date,wrec_no')
        ->where([
          ['bank', $this->bankno],
          ['letters',0],
          ['name', 'like', '%'.$this->search.'%'],])->paginate(15);
      if ($this->Proc=='wrong_kst')
      $data=DB::connection(Auth()->user()->company)->table('wrong_kst')
        ->selectraw('0 as no,acc,name,morahel,kst,tar_date,wrec_no')
        ->where([
          ['bank', '=', $this->bankno],
          ['morahel',0],
          ['name', 'like', '%'.$this->search.'%'],])->paginate(15);
      if ($this->Proc=='over_kst_a')
          $data=DB::connection(Auth()->user()->company)->table('over_kst_a')
                ->selectRaw('no,acc,name,letters as morahel,kst,tar_date,wrec_no')
                ->where([
                    ['bank', $this->bankno],
                    ['letters',0],
                    ['name', 'like', '%'.$this->search.'%'],])->paginate(15);



      return view('livewire.over-tar.tar-table',['TableList'=>$data ]);
    }
}
