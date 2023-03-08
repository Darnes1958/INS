<?php

namespace App\Http\Livewire\Haf;

use App\Models\aksat\hafitha_tran;
use App\Models\aksat\hafitha;
use App\Models\aksat\main;
use App\Models\bank\bank;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;


class HafInputHeader extends Component
{


 public $hafitha;
 public $bank;
 public $bank_l;
 public $hafitha_date;
 public $hafitha_date_new;

 public $hafitha_tot;
  public $hafitha_tot_new;
 public $hafitha_enter;
 public $hafitha_differ;
 public $HafHeadDetail;

 public $TheBankListIsSelectd;
 public $TheBankHafIsSelectd;
 public $ModalTitle;
 public $ShowHafNew=false;
 public $ShowHafDel=false;
 public $ShowHafUpd=false;
 public $ShowHafTarheel=false;

 public $HafUpload=false;
 public $HafProgress=0;
 public $HafCount=100;

  protected $listeners = [
    'RefreshHead','CloseMini','DoDeleteHafitha','DoTarheelHafitha','DoChkBankNo'
      ,'TheHafUpdated'=>'CloseEditDialog'
  ];

   public function CloseEditDialog(){$this->dispatchBrowserEvent('CloseMyEdit');}


  function DoChkBankNo(){
    $this->ChkBankAndGo();
  }
  function TarheelHafitha(){

    $this->dispatchBrowserEvent('TarHafitha');
  }
  function DoTarheelHafitha(){
    $this->HafUpload=true;
    $this->HafProgress=0;

    DB::connection(Auth()->user()->company)->beginTransaction();
    try {
      $this->HafCount=DB::connection(Auth()->user()->company)->table('hafitha_tran_view')->where('hafitha_no',$this->hafitha)->count();
      $res=DB::connection(Auth()->user()->company)->table('hafitha_tran_view')->where('hafitha_no',$this->hafitha)->get();

      foreach ($res as $item)
      {
        $no=$item->no; $acc=$item->acc; $kst=$item->kst; $ksm_date=$item->ksm_date; $baky=$item->baky;
        $ser_in_hafitha=$item->ser_in_hafitha; $emp=$item->emp; $name=$item->name;$bank=$item->bank;
        $sul_pay=$item->sul_pay+$item->kst;$raseed=$item->raseed-$item->kst;

        if ($item->kst_type==1 or $item->kst_type==3)
           { $min=DB::connection(Auth()->user()->company)->table('kst_trans')
             ->where([
               ['no', $no],
               ['ksm', null],])
             ->orwhere([
               ['no',  $no],
               ['ksm', 0],])
             ->min('ser');
             if ($min==null)
                  {$min=DB::connection(Auth()->user()->company)->table('kst_trans')->where('no',$no)->max('ser')+1;
                    DB::connection(Auth()->user()->company)->table('kst_trans')->insert([
                     'ser'=>$min,'no'=>$no,'kst_date'=>$ksm_date,'ksm_type'=>2,'chk_no'=>0,'kst'=>$kst,'ksm_date'=>$ksm_date,'ksm'=>$kst,'emp'=>$emp,
                      'h_no'=>$this->hafitha,'inp_date'=>date('Y-m-d'),]);
                  }
             else {
                   DB::connection(Auth()->user()->company)->table('kst_trans')->where('no',$no)->where('ser',$min)->update([
                   'h_no'=>$this->hafitha,'ksm'=>$kst,'ksm_date'=>$ksm_date,'emp'=>$emp,'inp_date'=>date('Y-m-d'),'ksm_type'=>2,]);
                  }
             if ($baky!=0)
                 {
                  DB::connection(Auth()->user()->company)->table('over_kst')->insert([
                    'no'=>$no,'name'=>$name,'bank'=>$bank,'acc'=>$acc,'kst'=>$baky,'tar_type'=>1,'tar_date'=>$ksm_date,'letters'=>0,'emp'=>$emp,'h_no'=>$this->hafitha,]);
                 }

             DB::connection(Auth()->user()->company)->table('main')->where('no',$no)->
             update(['sul_pay'=>$sul_pay,'raseed'=>$raseed]);
           }
       if ($item->kst_type==2)
       {
         DB::connection(Auth()->user()->company)->table('over_kst')->insert([
           'no'=>$no,'name'=>$name,'bank'=>$bank,'acc'=>$acc,'kst'=>$kst,'tar_type'=>1,'tar_date'=>$ksm_date,'letters'=>0,'emp'=>$emp,'h_no'=>$this->hafitha,]);
       }
        if ($item->kst_type==5)
        {
          DB::connection(Auth()->user()->company)->table('over_kst_a')->insert([
            'no'=>$no,'name'=>$name,'bank'=>$bank,'acc'=>$acc,'kst'=>$kst,'tar_type'=>1,'tar_date'=>$ksm_date,'letters'=>0,'emp'=>$emp,'h_no'=>$this->hafitha,]);
        }
        if ($item->kst_type==4)
        {
          $wrong=DB::connection(Auth()->user()->company)->table('wrong_kst')->max('wrong_no')+1;
          DB::connection(Auth()->user()->company)->table('wrong_kst')->insert([
            'wrong_no'=>$no,'name'=>$name,'bank'=>$bank,'acc'=>$acc,'kst'=>$kst,'tar_date'=>$ksm_date,'morahel'=>0,'emp'=>$emp,'h_no'=>$this->hafitha,]);
        }
        $this->HafProgress++;

      }
      DB::connection(Auth()->user()->company)->table('hafitha')->where('hafitha_no',$this->hafitha)->update(['hafitha_state'=>1]);
      $haflist=DB::connection(Auth()->user()->company)->table('hafitha_tran')
          ->where('hafitha',$this->hafitha)->select('no');
        DB::connection(Auth()->user()->company)->table('main')
            ->where('bank',$this->bank)
            ->whereIn('no',$haflist)
            ->update(['main.sul_pay'=>
                DB::connection(Auth()->user()->company)->
                raw('(select sum(ksm) from kst_trans where main.no=kst_trans.no and ksm is not null)')]);
        DB::connection(Auth()->user()->company)->table('main')
            ->where('bank',$this->bank)
            ->whereIn('no',$haflist)
            ->update(['main.raseed'=>
                DB::connection(Auth()->user()->company)->
                raw('sul-sul_pay')]);

      DB::connection(Auth()->user()->company)->commit();
      $this->HafHeadDetail=null;
      $this->bank=null;
      $this->HafUpload=false;
      $this->ChkBankAndGo();
      $this->emit('refreshBankHafSelect');
      $this->emit('refreshHafInputTable');
      $this->ShowHafDel=false;
      $this->ShowHafUpd=false;
      $this->ShowHafTarheel=false;
      $this->dispatchBrowserEvent('mmsg', 'تم ترحيل الحافظة');

    } catch (\Exception $e) {

      DB::connection(Auth()->user()->company)->rollback();
      $this->dispatchBrowserEvent('mmsg', 'حدث خطأ');

    }
  }

  function DeleteHafitha(){
    $this->dispatchBrowserEvent('DelHafitha');
  }
    function UpdateHafitha(){
        $this->emit('ToEditHaf',$this->hafitha,$this->hafitha_date,$this->hafitha_tot);
        $this->dispatchBrowserEvent('OpenMyEdit');
    }
  function DoDeleteHafitha(){


    DB::connection(Auth()->user()->company)->beginTransaction();
    try {
      DB::connection(Auth()->user()->company)->table('hafitha_tran')->where('hafitha',$this->hafitha)->delete();
      DB::connection(Auth()->user()->company)->table('pages')->where('hafitha',$this->hafitha)->delete();
      DB::connection(Auth()->user()->company)->table('hafitha')->where('hafitha_no',$this->hafitha)->delete();
      DB::connection(Auth()->user()->company)->commit();

      $this->bank=null;
      $this->render();



    } catch (\Exception $e) {
      DB::connection(Auth()->user()->company)->rollback();

    }
  }
  function mount(){
    $this->hafitha_date_new=date('Y-m-d');
  }
    public function CloseMini(){

        $this->dispatchBrowserEvent('CloseMiniModal');
    }
    public function OpenMini($ktno,$kstname) {

        $this->ModalTitle=$kstname;
        $this->emit('TakeKstTypeName',$ktno,$this->bank);

        $this->dispatchBrowserEvent('OpenMiniModal');

    }

  public function updatedbank(){

    $this->hafitha=0;
    $this->hafitha_date='';
    $this->hafitha_tot=0;
    $this->hafitha_enter=0;
    $this->hafitha_differ=0;
    $this->ShowHafDel=false;
    $this->ShowHafUpd=false;
    $this->ShowHafTarheel=false;
    $this->HafHeadDetail=DB::connection(Auth()->user()->company)
      ->table('hafitha_tran')
      ->join('kst_type', 'hafitha_tran.kst_type', '=', 'kst_type_no')
      ->where('hafitha','=',$this->hafitha)
      ->selectRaw('hafitha_tran.kst_type,kst_type.kst_type_name,count(*) as  wcount,sum(kst) as sumkst')
      ->groupby('hafitha_tran.kst_type','kst_type.kst_type_name')
      ->get();
    $this->emit('BankIsUpdating');
    $this->emit('banknotfound');
  }
  public function RefreshHead(){
    $result=DB::connection(Auth()->user()->company)->
    table('hafitha_view')->where('hafitha_state','=',0)
      ->where('bank',$this->bank)
      ->first();
    $this->FillHead($result);
  }

  public function updatedTheBankHafIsSelectd(){
    $this->TheBankHafIsSelectd=0;
    $this->ChkBankAndGo();
  }
  public function updatedTheBankListIsSelectd(){
    $this->TheBankListIsSelectd=0;
    $this->ChkBankList();
  }

  public function ChkBankList(){
    if ($this->bank_l!=null) {
      $result=DB::connection(Auth()->user()->company)->
      table('bank')->where('bank_no',$this->bank_l)
        ->first();

      if ($result) {
         $have=DB::connection(Auth()->user()->company)->
          table('hafitha')->where('bank',$this->bank_l)
           ->where('hafitha_state',0)
           ->first();
        if ($have) {$this->dispatchBrowserEvent('mmsg', 'توجد حافظة قائمة لهذا المصرف');}
        else $this->emit('goto','hafitha_date_new');
      } else {$this->dispatchBrowserEvent('mmsg', 'هذا الرقم غير مخزون');}
    }
  }
  protected function rules()
  {
    Config::set('database.connections.other.database', Auth::user()->company);
    return [
      'bank_l' => ['required','integer','gt:0','exists:other.bank,bank_no'],
      'hafitha_tot_new' =>['required','numeric','gt:0'],
      'hafitha_date_new' =>['required','date'],
    ];
  }
  protected $messages = [
    'required' => 'لا يجوز ترك فراغ',
  ];

 public function SaveNewBtn(){
   $this->validate();

   $have=DB::connection(Auth()->user()->company)->
   table('hafitha')->where('bank',$this->bank_l)
     ->where('hafitha_state',0)
     ->first();
   if ($have) {$this->dispatchBrowserEvent('mmsg', 'توجد حافظة قائمة لهذا المصرف'); return(false);}
   DB::connection(Auth()->user()->company)->beginTransaction();
   try {
       $hafmax=hafitha::on(Auth()->user()->company)->max('hafitha_no')+1;
       DB::connection(Auth()->user()->company)->table('hafitha')->insert([
         'hafitha_no'=>$hafmax,
         'bank'=>$this->bank_l,
         'hafitha_date'=>$this->hafitha_date_new,
         'hafitha_tot'=>$this->hafitha_tot_new,
         'hafitha_state'=>0,
         'kst_morahel'=>0,
         'kst_over'=>0,
         'kst_half_over'=>0,
         'kst_wrong'=>0,
       ]);
       DB::connection(Auth()->user()->company)->table('pages')->insert([
       'hafitha'=>$hafmax,
       'page_no'=>1,
       'page_tot'=>$this->hafitha_tot_new,
       'page_enter'=>0,
       'page_differ'=>0,
        ]);
     DB::connection(Auth()->user()->company)->commit();
     $this->ShowHafNew=false;
     $this->bank=$this->bank_l;
     $this->emit('goto','bank');
     $this->ChkBankAndGo();

   } catch (\Exception $e) {
     DB::connection(Auth()->user()->company)->rollback();
   }


}
 public function ChkBankAndGo(){

   if ($this->bank!=null) {
     $result=DB::connection(Auth()->user()->company)->
     table('hafitha_view')->where('hafitha_state','=',0)
       ->where('bank',$this->bank)
       ->first();

     if ($result) {
       $this->FillHead($result);
       $this->ShowHafDel=true;
       $this->ShowHafUpd=true;

       $this->emit('TakeHafithaDetail',$this->hafitha,$this->bank);
       $this->emit('TakeHafBankNo',$this->bank,$result->bank_name);
       $this->emitTo('haf.search-acc','TakeBank',$this->bank);

       if ($this->hafitha_differ==0) {$this->ShowHafTarheel=True;}
       else {$this->ShowHafTarheel=false;}

     } else {$this->dispatchBrowserEvent('mmsg', 'هذا الرقم غير مخزون');$this->ShowHafDel=false;$this->ShowHafTarheel=false;}
   } else {     $this->hafitha=0;
                $this->hafitha_date='';
                $this->hafitha_tot=0;
                $this->hafitha_enter=0;
                $this->hafitha_differ=0;

                $this->emit('BankIsUpdating');
                $this->emit('banknotfound');
          }

}
public function FillHead($res){
  $this->hafitha=$res->hafitha_no;
  $this->hafitha_date=$res->hafitha_date;
  $this->hafitha_tot=number_format($res->hafitha_tot,2, '.', '');
  $this->hafitha_enter=number_format($res->kst_morahel+$res->kst_half_over+$res->kst_over+$res->kst_wrong,2, '.', '');
  $this->hafitha_differ=number_format($this->hafitha_tot-$this->hafitha_enter,2, '.', '');

  $this->HafHeadDetail=DB::connection(Auth()->user()->company)
    ->table('hafitha_tran')
    ->join('kst_type', 'hafitha_tran.kst_type', '=', 'kst_type_no')
    ->where('hafitha','=',$this->hafitha)
    ->selectRaw('hafitha_tran.kst_type,kst_type.kst_type_name,count(*) as  wcount,sum(kst) as sumkst')
    ->groupby('hafitha_tran.kst_type','kst_type.kst_type_name')
    ->get();
  $this->emit('TakeHafithaTable',$this->hafitha);
  $this->emit('TakeHafithaMini',$this->hafitha);

}
    public function render()
    {

      if ($this->bank!=null) {
        $result=DB::connection(Auth()->user()->company)->
        table('hafitha_view')->where('hafitha_state','=',0)
          ->where('bank',$this->bank)
          ->first();

        if ($result) {
          $this->FillHead($result);

        }
      }
        return view('livewire.haf.haf-input-header');
    }
}
