<?php

namespace App\Http\Livewire\OverTar;

use App\Models\aksat\ksm_type;
use App\Models\aksat\kst_trans;
use App\Models\aksat\main;
use App\Models\OverTar\tar_kst;
use App\Models\OverTar\wrong_Kst;
use Illuminate\Queue\Listener;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class Tar2Detail extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';
  public $no=0;
  public $bank=0;
  public $acc='0';
  public $ksmdate;
  public $ksm;
  public $ser;
  public $name;
  public $tar_date;

  public $NoGet=false;
  public $TarGet=false;

  protected $listeners =['TakeData','ShowMe'];

  public function ShowMe($noget,$target){
    $this->NoGet=$noget;
    $this->TarGet=$target;
  }
  public function TakeData($bank,$acc,$no,$name){
    $this->no=$no;
    $this->acc=$acc;
    $this->bank=$bank;
    $this->name=$name;
    $this->NoGet=DB::connection('other')->table('kst_trans')
      ->where('no',$this->no)
      ->whereNotNull('ksm_date')!=null;
    $this->TarGet=DB::connection('other')->table('tar_kst')
      ->where('no',$this->no)
      ->where('bank',$this->bank)
      ->where('acc',$this->acc)
      ->where('ser','!=',0)!=null;
}

  public function selectItem($ser,$ksm){
    $this->ser=$ser;
    $this->ksm=$ksm;
    $this->dispatchBrowserEvent('OpenMyDelete');
  }
  public function CloseDeleteDialog(){$this->dispatchBrowserEvent('CloseMyDelete');}
  public function delete(){
    $this->CloseDeleteDialog();

    Config::set('database.connections.other.database', Auth::user()->company);
    kst_trans::where('no',$this->no)->where('ser',$this->ser)->delete();
    $maxdate=kst_trans::where('no',$this->no)->max('kst_date');
    $newdate=Carbon::parse($maxdate)->addMonth();
    $maxser=kst_trans::where('no',$this->no)->max('ser')+1;
    $kst=main::find('no')->kst;
    kst_trans::insert([
      'ser'=>$maxser,
      'no'=>$this->no,
      'kst_date'=>$maxdate,
      'ksm_type'=>0,
      'chk_no'=>0,
      'kst'=>$kst,
      'ksm_date'=>null,
      'ksm'=>0,
      'kst_notes'=>null,
      'inp_date'=>null,
      'emp'=>auth::user()->empno,
    ]);
    DB::connection('other')->table('main')->where('no',$this->D_no)->update([
      'sul_pay'=>$this->sul_pay+$this->ksm,
      'raseed'=>$this->raseed-$this->ksm,
    ]);
    DB::connection('other')->table('tar_kst')->insert([
      'no' => $this->no,
      'name' => $this->name,
      'bank' => $this->bank,
      'acc' => $this->acc,
      'kst' => $kst,
      'tar_type' => 3,
      'tar_date' => $this->tar_date,
      'ksm_date' => null,
      'ser' => $this->ser,
      'kst_date' => null,
      'emp' => Auth::user()->empno,
      'ksm_type' => $ksm_type,
    ]);
    $this->render();
  }
    public function render()
    {
      Config::set('database.connections.other.database', Auth::user()->company);
        return view('livewire.over-tar.tar2-detail',[
          'TableList'=>DB::connection('other')->table('kst_trans')
            ->where('no',$this->no)
            ->whereNotNull('ksm_date')
            ->orderBy('ser','asc')
            ->paginate(10),
          'TableList2'=>DB::connection('other')->table('tar_kst')
            ->where('no',$this->no)
            ->where('bank',$this->bank)
            ->where('acc',$this->acc)
            ->where('ser','!=',0)
            ->orderBy('ser','asc')
            ->paginate(10)
        ]);
    }
}
