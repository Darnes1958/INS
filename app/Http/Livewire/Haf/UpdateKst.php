<?php

namespace App\Http\Livewire\Haf;

use App\Models\aksat\hafitha_tran;
use App\Models\aksat\kst_type;
use App\Models\aksat\main;
use Illuminate\Queue\Listener;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class UpdateKst extends Component
{
  public $updatedate;
  public $updatekst;
  public $hafithano;
  public $hafno;
  public $hafacc;
  public $hafser;
  public $hafkst_type;
  public $hafraseed=0;
  protected $listeners = ['ParamToUpdate',];

  public function ParamToUpdate($haf,$ser)
  {

    $res=hafitha_tran::on(Auth()->user()->company)->where('hafitha',$haf)->where('ser_in_hafitha',$ser)->first();
    $this->updatedate = $res->ksm_date;
    $this->updatekst = $res->kst;
    $this->hafithano = $haf;
    $this->hafser=$ser;
    $this->hafno = $res->no;
    $this->hafacc = $res->acc;
    $this->hafkst_type=$res->kst_type;
  }

  protected function rules()
  {
    return [
      'updatedate' => ['required', 'date'],
      'updatekst' => ['required', 'numeric', 'gt:0'],
    ];
  }

  protected $messages = [
    'required' => 'لا يجوز ترك فراغ',
  ];

  public function UpdateSave()
  {
    $this->validate();


      if ($this->hafkst_type==1 || $this->hafkst_type==3)
       { $res=main::on(Auth()->user()->company)->find($this->hafno)->first();
          $raseed=$res->raseed;
          if ($this->updatekst>$raseed)
          {if ($raseed==0) {$kst=$this->updatekst;$baky=0;$type=2;}
          else {$kst=$raseed;$baky=$this->updatekst-$raseed;$type=3;}
          }
          else {$kst=$this->updatekst;$baky=0;$type=1;}
       }
      else {$kst=$this->updatekst;$baky=0;$type=$this->hafkst_type;}



    DB::connection(Auth()->user()->company)->beginTransaction();
    try {
      DB::connection(Auth()->user()->company)->table('hafitha_tran')
        ->where('hafitha',$this->hafithano)-> where('ser_in_hafitha',$this->hafser)->update([
        'ksm_date' => $this->updatedate,
        'kst' => $kst,
        'baky' => $baky,
        'kst_type' => $type,
        'emp' => auth::user()->empno,
      ]);

        $summorahel=hafitha_tran::on(Auth()->user()->company)->where('hafitha',$this->hafithano)->where('kst_type',1)->sum('kst');
        $sumover1=hafitha_tran::on(Auth()->user()->company)->where('hafitha',$this->hafithano)->where('kst_type',2)->sum('kst');
        $sumover2=hafitha_tran::on(Auth()->user()->company)->where('hafitha',$this->hafithano)->where('kst_type',5)->sum('kst');
        $sumover3=hafitha_tran::on(Auth()->user()->company)->where('hafitha',$this->hafithano)->where('kst_type',3)->sum('baky');
        if ($sumover1==null) {$sumover1=0;}
        if ($sumover2==null) {$sumover2=0;}
        if ($sumover3==null) {$sumover3=0;}
        $sumover=$sumover1+$sumover2+$sumover3;
        $sumhalfover=hafitha_tran::on(Auth()->user()->company)->where('hafitha',$this->hafithano)->where('kst_type',3)->sum('kst');
        $sumwrong=hafitha_tran::on(Auth()->user()->company)->where('hafitha',$this->hafithano)->where('kst_type',4)->sum('kst');
        DB::connection(Auth()->user()->company)->table('hafitha')->where('hafitha_no',$this->hafithano)->update([
            'kst_morahel'=>$summorahel,'kst_over'=>$sumover,'kst_half_over'=>$sumhalfover,'kst_wrong'=>$sumwrong,
        ]);



      DB::connection(Auth()->user()->company)->commit();
      $this->emit('CloseUpdate');
      $this->emit('ResetFromUpdate');
    } catch (\Exception $e) {
      DB::connection(Auth()->user()->company)->rollback();

      $this->dispatchBrowserEvent('mmsg', 'حدث خطأ');
    }

  }

  public function render()
  {
    return view('livewire.haf.update-kst');
  }
}


