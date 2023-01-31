<?php

namespace App\Http\Livewire\OverTar;

use App\Models\aksat\kst_trans;
use App\Models\aksat\main;
use App\Models\OverTar\tar_kst;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Tar2Detail extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';
  public $no=0;
  public $bank=0;
  public $acc='0';
  public $ksm_date;
  public $kst_date;
  public $ksm;
  public $ser;
  public $name;
  public $tar_date;
  public $ksm_type=2;

  public $wrec_no;

  public $NoGet=false;
  public $TarGet=false;
  public $SomeThing;

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
    if (!$this->tar_date) $this->tar_date=date('Y-m-d');
    $this->NoGet=DB::connection(Auth()->user()->company)->table('kst_trans')
      ->where('no',$this->no)
      ->whereNotNull('ksm_date')!=null;
    $this->TarGet=DB::connection(Auth()->user()->company)->table('tar_kst')
      ->where('no',$this->no)
      ->where('bank',$this->bank)
      ->where('acc',$this->acc)
      ->where('ser','!=',0)!=null;
}

  public function selectItem($ser,$ksm){
    $this->ser=$ser;
    $this->ksm=$ksm;
    $res=kst_trans::on(Auth()->user()->company)->where('no',$this->no)->where('ser',$ser)->first();
    $this->kst_date=$res->kst_date;
    $this->ksm_date=$res->ksm_date;
    $this->SomeThing='inp';
    $this->dispatchBrowserEvent('OpenMyDelete');
  }
    public function selectItem2($rec){
        $this->wrec_no=$rec;
        $this->SomeThing='del';
        $this->dispatchBrowserEvent('OpenMyDelete');
    }
  public function CloseDeleteDialog(){$this->dispatchBrowserEvent('CloseMyDelete');}

    protected function rules()
    {
        return [
            'tar_date' => ['required','date'],

        ];
    }
    protected $messages = [
        'required' => 'لا يجوز ترك فراغ',
        'ksm_date.required' => 'تاريخ خطأ',
    ];
  public function DoSomeThing(){
     if ($this->SomeThing=='inp') $this->InpTar();
     else $this->DelTar();
  }
    public function DelTar(){

        $this->CloseDeleteDialog();

        DB::connection(Auth()->user()->company)->beginTransaction();

        try {
            $res=tar_kst::on(Auth()->user()->company)->find($this->wrec_no);
                $this->kst_date=$res->kst_date;
                $this->ksm_date=$res->ksm_date;
                $this->ser=$res->ser;
                $this->ksm=$res->kst;
            $res=main::on(Auth()->user()->company)->where('no',$this->no)->first();
                $kst=$res->kst;
                $sul_pay=$res->sul_pay;
                $raseed=$res->raseed;

            kst_trans::on(Auth()->user()->company)->insert([
                'ser'=>$this->ser,
                'no'=>$this->no,
                'kst_date'=>$this->kst_date,
                'ksm_type'=>2,
                'chk_no'=>0,
                'kst'=>$kst,
                'ksm_date'=>$this->ksm_date,
                'ksm'=>$this->ksm,
                'kst_notes'=>null,
                'inp_date'=>date('Y-m-d'),
                'emp'=>auth::user()->empno,
            ]);

            DB::connection(Auth()->user()->company)->table('main')->where('no',$this->no)->update([
                'sul_pay'=>$sul_pay+$this->ksm,
                'raseed'=>$raseed-$this->ksm,
            ]);

            tar_kst::on(Auth()->user()->company)->where('wrec_no',$this->wrec_no)->delete();

            DB::connection(Auth()->user()->company)->commit();
            $this->render();
        } catch (\Exception $e) {
            DB::connection(Auth()->user()->company)->rollback();

            $this->dispatchBrowserEvent('mmsg', 'حدث خطأ');
        }
    }
  public function InpTar(){
    $this->validate();
    $this->CloseDeleteDialog();

      DB::connection(Auth()->user()->company)->beginTransaction();

      try {

            kst_trans::on(Auth()->user()->company)->where('no',$this->no)->where('ser',$this->ser)->delete();
            $maxdate=kst_trans::on(Auth()->user()->company)->where('no',$this->no)->max('kst_date');
            $newdate=Carbon::parse($maxdate)->addMonth();

            $maxser=kst_trans::on(Auth()->user()->company)->where('no',$this->no)->max('ser')+1;

            $res=main::on(Auth()->user()->company)->where('no',$this->no)->first();
            $kst=$res->kst;
            $sul_pay=$res->sul_pay;
            $raseed=$res->raseed;

            kst_trans::on(Auth()->user()->company)->insert([
              'ser'=>$maxser,
              'no'=>$this->no,
              'kst_date'=>$newdate,
              'ksm_type'=>0,
              'chk_no'=>0,
              'kst'=>$kst,
              'ksm_date'=>null,
              'ksm'=>0,
              'kst_notes'=>null,
              'inp_date'=>null,
              'emp'=>auth::user()->empno,
            ]);

            DB::connection(Auth()->user()->company)->table('main')->where('no',$this->no)->update([
              'sul_pay'=>$sul_pay-$this->ksm,
              'raseed'=>$raseed+$this->ksm,
            ]);

            DB::connection(Auth()->user()->company)->table('tar_kst')->insert([
              'no' => $this->no,
              'name' => $this->name,
              'bank' => $this->bank,
              'acc' => $this->acc,
              'kst' => $this->ksm,
              'tar_type' => 3,
              'tar_date' => $this->tar_date,
              'ksm_date' => $this->ksm_date,
              'ser' => $this->ser,
              'kst_date' => $this->kst_date,
              'emp' => Auth::user()->empno,
              'ksm_type' => $this->ksm_type,
            ]);

         DB::connection(Auth()->user()->company)->commit();
         $this->render();
      } catch (\Exception $e) {
          DB::connection(Auth()->user()->company)->rollback();

          $this->dispatchBrowserEvent('mmsg', 'حدث خطأ');
      }
  }
    public function render()
    {

        return view('livewire.over-tar.tar2-detail',[
          'TableList'=>DB::connection(Auth()->user()->company)->table('kst_trans')
            ->where('no',$this->no)
            ->whereNotNull('ksm_date')
            ->orderBy('ser','asc')
            ->paginate(10),
          'TableList2'=>DB::connection(Auth()->user()->company)->table('tar_kst')
            ->where('no',$this->no)
            ->where('bank',$this->bank)
            ->where('acc',$this->acc)
            ->where('ser','!=',0)
            ->orderBy('ser','asc')
            ->paginate(10)
        ]);
    }
}
