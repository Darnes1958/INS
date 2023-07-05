<?php

namespace App\Http\Livewire\Haf;

use App\Models\aksat\hafitha_tran;
use Illuminate\Queue\Listener;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class WrongAcc extends Component
{
  public $wrongname;
  public $wrongkst;
  public $hafno;
  public $hafdate;
  public $hafacc;
  public $no=null;
  public $MainDeleted=false;
    protected $listeners = [  'ParamToWrong',  ];

  public function ParamToWrong($h,$a,$d,$no=null,$name='',$kst=0){

    $this->no=$no;
    $this->wrongname=$name;
    $this->wrongkst=$kst;
    $this->hafno=$h;
    $this->hafdate=$d;
    $this->hafacc=$a;
    $this->MainDeleted=$this->no!=null;

  }
  protected function rules()
  {
    return [
      'wrongname' => ['required','string'],
      'wrongkst' =>['required','numeric','gt:0'],
    ];
  }
  protected $messages = [
    'required' => 'لا يجوز ترك فراغ',
  ];
 public function WrongSave(){
   $this->validate();
   if ($this->no==null)
   {
     $no=0;
     $kst_type=4;
   }
   else
   {
     $no=$this->no;
     $kst_type=6;
   }


   $serinhafitha= hafitha_tran::on(Auth()->user()->company)->where('hafitha',$this->hafno)->max('ser_in_hafitha')+1;
   DB::connection(Auth()->user()->company)->beginTransaction();
   try {
     DB::connection(Auth()->user()->company)->table('hafitha_tran')->insert([
       'hafitha'=>$this->hafno,
       'ser_in_hafitha'=>$serinhafitha,
       'ser'=>0,

       'acc'=>$this->hafacc,
       'name'=>$this->wrongname,
       'ksm_date'=>$this->hafdate,
       'kst'=>$this->wrongkst,
       'baky'=>0,
       'kst_type'=>$kst_type,
       'page_no'=>1,
       'emp'=>auth::user()->empno,
       'no'=>$no,
     ]);
     $sumwrong=hafitha_tran::on(Auth()->user()->company)->where('hafitha',$this->hafno)->where('kst_type',4)->sum('kst');
     $sumwrong_after=hafitha_tran::on(Auth()->user()->company)->where('hafitha',$this->hafno)->where('kst_type',6)->sum('kst');
     DB::connection(Auth()->user()->company)->table('hafitha')->where('hafitha_no',$this->hafno)->update([
       'kst_wrong'=>$sumwrong,'kst_wrong_after'=>$sumwrong_after,
     ]);
     DB::connection(Auth()->user()->company)->commit();
     $this->emit('ResetFromWrong');
   } catch (\Exception $e) {
     DB::connection(Auth()->user()->company)->rollback();

     $this->dispatchBrowserEvent('mmsg', 'حدث خطأ');
   }

 }
  public function render()
    {
        return view('livewire.haf.wrong-acc');
    }
}
