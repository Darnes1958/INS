<?php

namespace App\Http\Livewire\Haf;



use App\Models\aksat\main;
use App\Models\aksat\hafitha;
use App\Models\aksat\hafitha_tran;
use App\Models\aksat\MainArc;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;

class HafInputDetail extends Component
{
    public $no;
    public $hafitha=0;
    public $bank=0;
    public $acc;
    public $name;
    public $sul_tot;
    public $dofa;
    public $sul;
    public $sul_pay;
    public $raseed;
    public $kst_count;
    public $kst;
    public $notes;
    public $ksm_date;
    public $ksm;

    public $kst_type;

    Public $SumKst;
    public $TheNoListIsSelectd;
    public $NoGeted=false;
    public $BankGeted=false;

  protected $listeners = [
        'TakeHafithaDetail','Take_ManyAcc_No','OpenWrong',
        'ResetFromWrong','ResetFromUpdate','BankIsUpdating','TakeTheNo',
    ];
  public function TakeTheNo($no){
      $this->no=$no;
      $this->ChkNoAndGo();
  }
  public function BankIsUpdating(){
    $this->BankGeted=false;
  }
  public function ResetFromWrong(){
      $this->CloseWrong();
      $this->emit('RefreshHead');
      $this->Resetdetail();
  }
    public function ResetFromUpdate(){

        $this->emit('RefreshHead');
        $this->Resetdetail();
    }

  public $TheBankListIsSelectd;

  public function updatedTheNoListIsSelectd(){
    $this->TheNoListIsSelectd=0;
    $this->ChkNoAndGo();
  }
  public function updatedNo(){
    $this->NoGeted=false;
  }
  public function updatedAcc(){
    $this->NoGeted=false;
  }

  public function ChkNoAndGo(){

    if ($this->no!=null) {
      $result = main::on(Auth()->user()->company)->where('no',$this->no)-> first();
      if ($result) {
        $ser=DB::connection(Auth()->user()->company)->table('kst_trans')
          ->where('no',$this->no)
          ->where('ksm','!=',null)
          ->where('ksm','!=','0')->max('ser');
        if ($ser==null) {$kst=$result->kst; }
        else {$res=DB::connection(Auth()->user()->company)->table('kst_trans')->where('no',$this->no)->where('ser',$ser)->first();
              $kst=$res->ksm; }
        $sumkst=hafitha_tran::select(DB::connection(Auth()->user()->company)->raw('sum(kst + baky) as total'))
                              ->where('hafitha',$this->hafitha)->where('no',$this->no)->first();
        if ($sumkst->total != null)
         {$this->SumKst=$sumkst->total;}
        else {$this->SumKst=0;}

        if ($result->raseed<=0 || $this->SumKst>=$result->raseed )
           { $this->kst_type=2; session()->flash('message', 'بالفائض .. ');}
        else { $this->kst_type=1;}

        $this->FillDetail($result,$kst);
        $this->NoGeted=true;
        $this->emit('kstdetail_goto','ksm');
      }

      else

      {
        $result = MainArc::on(Auth()->user()->company)->where('no',$this->no)->first();
        if ($result) {
          $this->kst_type=5;
          $ser=DB::connection(Auth()->user()->company)->table('TransArc')
            ->where('no',$this->no)
            ->where('ksm','!=',null)
            ->where('ksm','!=','0')->max('ser');

          if ($ser==null) {$kst=$result->kst;}
          else {
            $res=DB::connection(Auth()->user()->company)->table('TransArc')->where('no',$this->no)->where('ser',$ser)->first();
            $kst=$res->ksm;
          }

          $this->FillDetail($result,$kst);
          $this->NoGeted=true;
          $this->emit('kstdetail_goto','ksm_date');
          session()->flash('message', 'بالفائض .. من الارشيف');
        }
        else {session()->flash('message', 'هذا الرقم غير موجود');}
      }
    }
  }
    public function FillDetail($res,$kst){
     $this->acc=$res->acc;
     $this->name=$res->name;
     $this->sul=$res->sul;
     $this->sul_tot=$res->sul_tot;
     $this->sul_pay=$res->sul_pay;
     $this->raseed=$res->raseed;
     $this->kst_count=$res->kst_count;
     $this->kst=$res->kst;
     $this->ksm=$kst;
    }

    public function TakeHafithaDetail($h,$b){
        $this->hafitha=$h;
        $this->bank=$b;
        $this->BankGeted=true;
        $this->emit('bankfound',$this->bank,'');
    }
    public function ChkAccAndGo(){

      $result = main::on(Auth()->user()->company)->where('bank',$this->bank)->where('acc',$this->acc)->get();
      if (count($result)!=0) {
        if (count($result)>1){
          $this->emit('GotoManyAcc',$this->bank,$this->acc);
          $this->dispatchBrowserEvent('OpenKstManyModal');}
        else {
          $result = main::on(Auth()->user()->company)->where('bank',$this->bank)->where('acc',$this->acc)->first();
          $this->name=$result->name;
          $this->no=$result->no;
          $this->ChkNoAndGo();
        }
      }
      else
      {
          $res= mainarc::on(Auth()->user()->company)
              ->where('bank',$this->bank)->where('acc',$this->acc)->first();
          if ($res) {
              $this->no=$res->no;
              $this->ChkNoAndGo();
          } else {
              $this->emit('ParamToWrong', $this->hafitha, $this->acc, $this->ksm_date);
              $this->dispatchBrowserEvent('kstwrong');
          }
      }

    }
    public function ChkKsm(){
      $this->validate();
      $baky=0;
      if ($this->kst_type==1)
      { if ($this->SumKst+$this->kst>$this->raseed){
          $baky=$this->SumKst+$this->kst-$this->raseed;
          $this->kst_type=3; }
        }
      $this->StoreRec($baky);
      $this->emit('RefreshHead');
      $this->Resetdetail();
      $this->emitTo('haf.search-acc','take_goto','search_box');
    }

    function mount(){
      $this->ksm_date=date('Y-m-d');
    }
   public function Resetdetail(){
    $this->NoGeted=false;

    $this->name='';
    $this->sul_pay='';
    $this->sul='';
    $this->kst='';
    $this->ksm='';
    $this->sul_tot='';
    $this->raseed='';
    $this->kst_count='';

   }
   public function StoreRec($baky){

    $serinhafitha= hafitha_tran::on(Auth()->user()->company)->where('hafitha',$this->hafitha)->max('ser_in_hafitha')+1;
     DB::connection(Auth()->user()->company)->beginTransaction();
     try {
        DB::connection(Auth()->user()->company)->table('hafitha_tran')->insert([
          'hafitha'=>$this->hafitha,
          'ser_in_hafitha'=>$serinhafitha,
          'ser'=>0,
          'no'=>$this->no,
          'acc'=>$this->acc,
          'name'=>$this->name,
          'ksm_date'=>$this->ksm_date,
          'kst'=>$this->ksm-$baky,
          'baky'=>$baky,
          'kst_type'=>$this->kst_type,
          'page_no'=>1,
          'emp'=>auth::user()->empno,
        ]);
        $summorahel=hafitha_tran::on(Auth()->user()->company)->where('hafitha',$this->hafitha)->where('kst_type',1)->sum('kst');
        $sumover1=hafitha_tran::on(Auth()->user()->company)->where('hafitha',$this->hafitha)->where('kst_type',2)->sum('kst');
        $sumover2=hafitha_tran::on(Auth()->user()->company)->where('hafitha',$this->hafitha)->where('kst_type',5)->sum('kst');
        $sumover3=hafitha_tran::on(Auth()->user()->company)->where('hafitha',$this->hafitha)->where('kst_type',3)->sum('baky');
        if ($sumover1==null) {$sumover1=0;}
        if ($sumover2==null) {$sumover2=0;}
        if ($sumover3==null) {$sumover3=0;}
        $sumover=$sumover1+$sumover2+$sumover3;
        $sumhalfover=hafitha_tran::on(Auth()->user()->company)->where('hafitha',$this->hafitha)->where('kst_type',3)->sum('kst');
         DB::connection(Auth()->user()->company)->table('hafitha')->where('hafitha_no',$this->hafitha)->update([
           'kst_morahel'=>$summorahel,'kst_over'=>$sumover,'kst_half_over'=>$sumhalfover,
         ]);

       DB::connection(Auth()->user()->company)->commit();
       $this->emit('DoChkBankNo');

     } catch (\Exception $e) {
info($e);
       DB::connection(Auth()->user()->company)->rollback();
       $this->dispatchBrowserEvent('mmsg', 'حدث خطأ');
     }
   }

  public function OpenMany(){
    $this->dispatchBrowserEvent('OpenKstManyModal');
  }
  public function CloseMany(){
    $this->dispatchBrowserEvent('CloseKstManyModal');
  }
  public function OpenWrong(){
    $this->emit('ParamToWrong',$this->hafitha,$this->acc,$this->ksm_date);
    $this->dispatchBrowserEvent('OpenWrongModal');
  }
  public function CloseWrong(){
    $this->dispatchBrowserEvent('CloseWrongModal');
  }

  public function Take_ManyAcc_No($The_no){
    $this->no=$The_no;
    $this->ChkNoAndGo();
  }
  protected function rules()
  {
    return [
      'acc' => ['required','string',],
      'no' => ['required','integer','gt:0',],
      'ksm_date' =>['required','date'],
    ];
  }

  protected $messages = [
    'required' => 'لا يجوز ترك فراغ',
    'exists' => 'هذا الرقم غير مخزون',
  ];

    public function render()
    {
        return view('livewire.haf.haf-input-detail');
    }
}
