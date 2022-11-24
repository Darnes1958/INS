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
  protected $listeners = ['ParamToWrong',];

  public function ParamToWrong($haf,$ser)
  {
    Config::set('database.connections.other.database', Auth::user()->company);
    $res=hafitha_tran::where('hafitha',$haf)->where('ser_in_hafitha',$ser)->first();
    $this->updatedate = $res->ksm_date;
    $this->updatekst = $res->kst;
    $this->hafithano = $haf;
    $this->hafno = $res->no;
    $this->hafacc = $res->acc;
    $this->hafkst_type=$res->kst_type;
    if ($this->hafkst_type!=4) {$res=main::find($this->hafno)->first();$this->hafraseed=$res->raseed;}

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
    if ($this->hafkst_type=4)
     {$kst=$this->updatekst;$baky=0;}
    else
     {
       if ($this->updatekst>$this->hafraseed) {$kst=$this->$this->hafraseed;$baky=$this->updatekst-$this->hafraseed;}
       else {$kst=$this->updatekst;$baky=0;}
     } //<!-- up to here -->
    Config::set('database.connections.other.database', Auth::user()->company);

    DB::connection('other')->beginTransaction();
    try {
      DB::connection('other')->table('hafitha_tran')
        ->where('ser_in_hafitha',$this->hafser)->update([

        'ksm_date' => $this->hafdate,
        'kst' => $this->wrongkst,
        'baky' => 0,
        'kst_type' => 4,
        'emp' => auth::user()->empno,
      ]);
      $sumwrong = hafitha_tran::where('hafitha', $this->hafno)->where('kst_type', 4)->sum('kst');
      DB::connection('other')->table('hafitha')->where('hafitha_no', $this->hafno)->update([
        'kst_wrong' => $sumwrong,
      ]);
      DB::connection('other')->commit();
      $this->emit('ResetFromWrong');
    } catch (\Exception $e) {
      DB::connection('other')->rollback();

      $this->dispatchBrowserEvent('mmsg', 'حدث خطأ');
    }

  }

  public function render()
  {
    return view('livewire.haf.update-kst');
  }
}


