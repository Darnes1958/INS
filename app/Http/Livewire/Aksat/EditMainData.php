<?php

namespace App\Http\Livewire\Aksat;

use App\Models\aksat\kst_trans;
use App\Models\aksat\main;
use App\Models\aksat\main_items;
use App\Models\aksat\MainArc;
use App\Models\aksat\place;
use App\Models\bank\bank;
use App\Models\Operations;
use App\Models\OverTar\over_kst;
use App\Models\OverTar\over_kst_a;
use App\Models\OverTar\stop_kst;
use App\Models\OverTar\tar_kst;
use App\Models\OverTar\tar_kst_before;
use App\Models\sell\sell_tran;
use Carbon\Carbon;
use Illuminate\Queue\Listener;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;

class EditMainData extends Component
{
  public $no;
  public $acc;
  public $OldAcc;
  public $name;
  public $bankno;
  public $OldBank;
  public $bank_name;
  public $orderno;
  public $order_no;
  public $jeha;
  public $sul_tot;
  public $sul;
  public $sul_date;

  public $kstcount;
  public $kst;
  public $chk_in;
  public $notes;
  public $place;
  public $dofa;
  public $ref_no;
  public $raseed;
  public $sul_pay;

  public $OrderGet=false;
  public $OrderShow=false;
  public $BankGet=false;
  public $EditMe;
  public $DeleteMe;
  public $DeleteBtn=false;

  public $TheBankNoListIsSelectd;
  public $ThePlaceNoListIsSelectd;

  protected $listeners = ['GotoDetail',];

  public function GotoDetail($res){

    $this->no=$res['no'];
    $this->acc=$res['acc'];
    $this->OldAcc=$res['acc'];
    $this->orderno=$res['order_no'];
    $this->name=$res['name'];

    $this->jeha=$res['jeha'];
    $this->sul_tot=$res['sul_tot'];
    $this->sul=$res['sul'];
    $this->dofa=$res['dofa'];
    $this->sul_date=$res['sul_date'];
    $this->sul_pay=$res['sul_pay'];
    $this->raseed=$res['raseed'];
    $this->kstcount=$res['kst_count'];
    $this->kst=$res['kst'];
    $this->chk_in=$res['chk_in'];
    $this->notes=$res['notes'];
    $this->bankno=$res['bank'];
    $this->OldBank=$res['bank'];
    $this->place=$res['place'];

    if ($this->EditMe) $this->OrderGet=true;
    else {$this->OrderGet=false;$this->DeleteBtn=true;}
    $this->OrderShow=true;


    $this->emit('goto','bankno');

  }

  public function updatedTheBankNoListIsSelectd(){
    $this->TheBankNoListIsSelectd=0;
    $this->ChkBankAndGo();
  }
  public function updatedThePlaceNoListIsSelectd(){
    $this->ThePlaceNoListIsSelectd=0;
    $this->ChkPlaceAndGo();
  }

  public function updatedBankno(){
    $this->BankGet=false;

  }
  public function ChkPlaceAndGo(){

    if ($this->place!=null){
      $res=place::on(Auth()->user()->company)->find($this->place);
      if (!$res){$this->dispatchBrowserEvent('mmsg', 'هذا الرقم غير مخزون ');$this->emit('goto','place');}
      else {$this->emit('goto','notes'); $this->emit('TakePlaceNo',$res->place_no,$res->place_name);};}
  }
  public function ChkBankAndGo(){

    if ($this->bankno){
      $res=bank::on(Auth()->user()->company)->find($this->bankno);
      if (!$res ){$this->dispatchBrowserEvent('mmsg', 'هذا الرقم غير مخزون ');$this->emit('goto','bank_no');}
      else {$this->BankGet=true; $this->emit('goto','acc');$this->emit('TakeBankNo',$res->bank_no,$res->bank_name);};}
  }
  public function ChkAccAndGo(){

    if ($this->acc) {
      $res = main::on(Auth()->user()->company)->where('bank', $this->bankno)->where('acc', $this->acc)->first();

      if ($res && $this->jeha != $res->jeha) {
        session()->flash('message', 'انتبه .. هذا الحساب لنفس المصرف مخزون لزبون اخر .. ورقمه ( '.$res->jeha.')');
      }
      $this->emit('goto', 'place');
    }
  }

  protected function rules()
  {
    Config::set('database.connections.other.database', Auth::user()->company);
    return [
      'sul_date' => ['required','date'],
      'bankno' =>['required','integer','gt:0','exists:other.bank,bank_no'],
      'place' =>['required','integer','gte:0','exists:other.place,place_no'],
      'acc' => ['required','string'],
    ];
  }
  protected $messages = [
    'exists' => 'هذا الرقم غير مخزون',
    'required' => 'لا يجوز ترك فراغ',
    'unique' => 'هذا الرقم مخزون مسبقا',

    'sul_date.required'=>'يجب ادخال تاريخ صحيح',
  ];

  public function SaveCont(){
    $this->validate();

    DB::connection(Auth()->user()->company)->beginTransaction();
    try {
      DB::connection(Auth()->user()->company)->table('main')->where('no',$this->no)->update([
        'bank'=>$this->bankno,'acc'=>$this->acc,
        'place'=>$this->place,'notes'=>$this->notes,'chk_in'=>$this->chk_in,'ref_no'=>$this->ref_no,
        'emp'=>auth::user()->empno,]);
      over_kst::on(Auth()->user()->company)->where('bank',$this->OldBank)->where('acc',$this->OldAcc)->update([
        'bank'=>$this->bankno,'acc'=>$this->acc,
      ]);
      over_kst_a::on(Auth()->user()->company)->where('bank',$this->OldBank)->where('acc',$this->OldAcc)->update([
        'bank'=>$this->bankno,'acc'=>$this->acc,
      ]);
      tar_kst::on(Auth()->user()->company)->where('bank',$this->OldBank)->where('acc',$this->OldAcc)->update([
        'bank'=>$this->bankno,'acc'=>$this->acc,
      ]);
      stop_kst::on(Auth()->user()->company)->where('bank',$this->OldBank)->where('acc',$this->OldAcc)->update([
        'bank'=>$this->bankno,'acc'=>$this->acc,
      ]);
      tar_kst_before::on(Auth()->user()->company)->where('bank',$this->OldBank)->where('acc',$this->OldAcc)->update([
        'bank'=>$this->bankno,'acc'=>$this->acc,
      ]);
      main::on(Auth()->user()->company)->where('jeha',$this->jeha)->update([
        'bank'=>$this->bankno,'acc'=>$this->acc,
      ]);
      MainArc::on(Auth()->user()->company)->where('jeha',$this->jeha)->update([
        'bank'=>$this->bankno,'acc'=>$this->acc,
      ]);

      Operations::insert(['Proce'=>'عقد','Oper'=>'تعديل','no'=>$this->no,'created_at'=>Carbon::now(),'emp'=>auth::user()->empno,]);
      DB::connection(Auth()->user()->company)->commit();
      $this->no=''; $this->orderno='';$this->name='';$this->bankno='';$this->acc='';$this->place='';
      $this->sul='';$this->sul_tot='';$this->dofa='';$this->kst='';
      $this->kstcount='';$this->notes='';$this->ref_no='';$this->chk_in='';
      $this->OrderGet=false;

      $this->emit('OpenTable');

    } catch (\Exception $e) {
      DB::connection(Auth()->user()->company)->rollback();

      $this->dispatchBrowserEvent('mmsg', 'حدث خطأ');
    }
  }

  public function DeleteCont(){
    $this->validate();

    DB::connection('other')->beginTransaction();
    try {
      tar_kst::on(Auth()->user()->company)->where('no',$this->no)->delete();
      over_kst::on(Auth()->user()->company)->where('no',$this->no)->delete();
      stop_kst::on(Auth()->user()->company)->where('no',$this->no)->delete();
      tar_kst_before::on(Auth()->user()->company)->where('no',$this->no)->delete();
      kst_trans::on(Auth()->user()->company)->where('no',$this->no)->delete();
      main::on(Auth()->user()->company)->where('no',$this->no)->delete();

      Operations::insert(['Proce'=>'عقد','Oper'=>'الغاء','no'=>$this->no,'created_at'=>Carbon::now(),'emp'=>auth::user()->empno,]);

      DB::connection(Auth()->user()->company)->commit();
      $this->no=''; $this->orderno='';$this->name='';$this->bankno='';$this->acc='';$this->place='';
      $this->sul='';$this->sul_tot='';$this->dofa='';$this->kst='';
      $this->kstcount='';$this->notes='';$this->ref_no='';$this->chk_in='';
      $this->OrderGet=false;
      $this->DeleteBtn=false;

      $this->emit('OpenTable');

    } catch (\Exception $e) {
      DB::connection(Auth()->user()->company)->rollback();

      $this->dispatchBrowserEvent('mmsg', 'حدث خطأ');
    }
  }

    public function mount($edit,$del){
     $this->EditMe=$edit;
     $this->DeleteMe=$del;

    }
    public function render()
    {
        return view('livewire.aksat.edit-main-data');
    }
}
