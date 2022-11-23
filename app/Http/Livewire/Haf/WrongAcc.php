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
  protected $Listeners=[ 'ParamToWrong',  ];

  public function ParamToWrong($h,$a,$d){
    $this->hafno=$h;
    $this->hafdate=$d;
    $this->hafacc=$a;
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
   Config::set('database.connections.other.database', Auth::user()->company);
   $serinhafitha= hafitha_tran::where('hafitha',$this->hafitha)->max('ser_in_hafitha')+1;
   DB::connection('other')->beginTransaction();
   try {
     DB::connection('other')->table('hafitha_tran')->insert([
       'hafitha'=>$this->hafno,
       'ser_in_hafitha'=>$serinhafitha,
       'ser'=>0,
       'no'=>0,
       'acc'=>$this->hafacc,
       'name'=>$this->wrongname,
       'ksm_date'=>$this->hafdate,
       'kst'=>$this->wrongkst,
       'baky'=>0,
       'kst_type'=>3,
       'page_no'=>1,
       'emp'=>auth::user()->empno,
     ]);
     $sumwrong=hafitha_tran::where('hafitha',$this->hafno)->where('kst_type',3)->sum('kst');
     DB::connection('other')->table('hafitha')->where('hafitha_no',$this->hafno)->update([
       'kst_wrong'=>$sumwrong,
     ]);
     DB::connection('other')->commit();

   } catch (\Exception $e) {
     DB::connection('other')->rollback();
     $this->dispatchBrowserEvent('mmsg', 'حدث خطأ');
   }

 }
  public function render()
    {
        return view('livewire.haf.wrong-acc');
    }
}
