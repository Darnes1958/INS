<?php

namespace App\Http\Livewire\Haf;

use App\Models\aksat\hafitha_tran;
use App\Models\aksat\hafitha;
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
 public $ShowHafTarheel=false;

  protected $listeners = [
    'RefreshHead','CloseMini',
  ];
  function DeleteHafitha(){
    $this->dispatchBrowserEvent('DelHafitha');
  }
  function DoDeleteHafitha(){
    info('I come');
    Config::set('database.connections.other.database', Auth::user()->company);
    DB::connection('other')->beginTransaction();
    try {
      DB::connection('other')->table('hafitha_tran')->where('hafitha',$this->hafitha)->delete();
      DB::connection('other')->table('pages')->where('hafitha',$this->hafitha)->delete();
      DB::connection('other')->table('hafitha')->delete($this->hafitha);
      DB::connection('other')->commit();
    } catch (\Exception $e) {
      DB::connection('other')->rollback();
      info($e);
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
        $this->emit('TakeKstTypeName',$ktno);

        $this->dispatchBrowserEvent('OpenMiniModal');

    }

  public function updatedbank(){
    Config::set('database.connections.other.database', Auth::user()->company);
    $this->hafitha=0;
    $this->ShowHafDel=false;
    $this->ShowHafTarheel=false;
    $this->HafHeadDetail=DB::connection('other')
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
    $result=DB::connection('other')->
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

    Config::set('database.connections.other.database', Auth::user()->company);

    if ($this->bank_l!=null) {
      $result=DB::connection('other')->
      table('bank')->where('bank_no',$this->bank_l)
        ->first();

      if ($result) {
         $have=DB::connection('other')->
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
   Config::set('database.connections.other.database', Auth::user()->company);
   $have=DB::connection('other')->
   table('hafitha')->where('bank',$this->bank_l)
     ->where('hafitha_state',0)
     ->first();
   if ($have) {$this->dispatchBrowserEvent('mmsg', 'توجد حافظة قائمة لهذا المصرف'); return(false);}
   DB::connection('other')->beginTransaction();
   try {
       $hafmax=hafitha::max('hafitha_no')+1;
       DB::connection('other')->table('hafitha')->insert([
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
       DB::connection('other')->table('pages')->insert([
       'hafitha'=>$hafmax,
       'page_no'=>1,
       'page_tot'=>$this->hafitha_tot_new,
       'page_enter'=>0,
       'page_differ'=>0,
        ]);
     DB::connection('other')->commit();
     $this->ShowHafNew=false;

   } catch (\Exception $e) {
     DB::connection('other')->rollback();
   }


}
 public function ChkBankAndGo(){
   Config::set('database.connections.other.database', Auth::user()->company);

   if ($this->bank!=null) {
     $result=DB::connection('other')->
     table('hafitha_view')->where('hafitha_state','=',0)
       ->where('bank',$this->bank)
       ->first();

     if ($result) {
       $this->FillHead($result);
       $this->ShowHafDel=true;

       $this->emit('TakeHafithaDetail',$this->hafitha,$this->bank);
       $this->emit('TakeHafBankNo',$this->bank,$result->bank_name);

       if ($this->hafitha_differ==0) {$this->ShowHafTarheel=True;}

     } else {$this->dispatchBrowserEvent('mmsg', 'هذا الرقم غير مخزون');$this->ShowHafDel=false;$this->ShowHafTarheel=false;}
   }

}
public function FillHead($res){
  $this->hafitha=$res->hafitha_no;
  $this->hafitha_date=$res->hafitha_date;
  $this->hafitha_tot=number_format($res->hafitha_tot,2, '.', '');
  $this->hafitha_enter=number_format($res->kst_morahel+$res->kst_half_over+$res->kst_over+$res->kst_wrong,2, '.', '');
  $this->hafitha_differ=number_format($this->hafitha_tot-$this->hafitha_enter,2, '.', '');

  $this->HafHeadDetail=DB::connection('other')
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
      Config::set('database.connections.other.database', Auth::user()->company);

      if ($this->bank!=null) {
        $result=DB::connection('other')->
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
