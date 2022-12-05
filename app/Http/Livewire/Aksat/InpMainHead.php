<?php

namespace App\Http\Livewire\Aksat;

use App\Models\aksat\main;
use App\Models\aksat\place;
use App\Models\sell\sells;
use App\Models\bank\bank;
use App\Models\sell\sells_view;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;

class InpMainHead extends Component
{

  public $no;
  public $acc;
  public $name;
  public $bankno;
  public $bank_name;
  public $orderno;
  public $order_no;
  public $jeha;
  public $sul_tot;
  public $sul;
  public $sul_date;

  public $kstcount;
  public $kst;
  public $chk_in=0;
  public $notes;
  public $place=1;
  public $dofa;
  public $ref_no;


  public $OrderGet=false;
  public $BankGet=false;
  public $CountGet=false;

  public $TheBankNoListIsSelectd;
  public $TheOrderNoListIsSelectd;
  public $ThePlaceNoListIsSelectd;
  public function updatedTheBankNoListIsSelectd(){
    $this->TheBankNoListIsSelectd=0;
    $this->ChkBankAndGo();
  }
  public function updatedTheOrderNoListIsSelectd(){
    $this->TheOrderNoListIsSelectd=0;
    $this->ChkOrderAndGo();
  }
  public function updatedThePlaceNoListIsSelectd(){
    $this->ThePlaceNoListIsSelectd=0;
    $this->ChkPlaceAndGo();
  }

  function updatedOrderno(){

    $this->OrderGet=false;
    $this->BankGet=false;
    $this->CountGet=false;
    $this->order_no=$this->orderno;
  }
  public function updatedBankno(){
    $this->BankGet=false;
    $this->acc='';
  }
  public function updatedKstcount(){
    $this->CountGet=false;
    $this->kst='';

  }
  public function ChkBankAndGo(){
    Config::set('database.connections.other.database', Auth::user()->company);
    if ($this->bankno){

      $res=bank::find($this->bankno);
      if (!$res ){$this->dispatchBrowserEvent('mmsg', 'هذا الرقم غير مخزون ');$this->emit('goto','bank_no');}
      else {$this->BankGet=true; $this->emit('goto','acc');$this->emit('TakeBankNo',$res->bank_no,$res->bank_name);};}
  }
  public function ChkAccAndGo(){
    Config::set('database.connections.other.database', Auth::user()->company);
    if ($this->acc) {
      $res = main::where('bank', $this->bankno)->where('acc', $this->acc)->first();

      if ($res && $this->jeha != $res->jeha) {
        session()->flash('message', 'انتبه .. هذا الحساب لنفس المصرف مخزون لزبون اخر .. ورقمه ( '.$res->jeha.')');
      }
      $this->emit('goto', 'place');
    }
  }
  public function ChkNoAndGo(){
    Config::set('database.connections.other.database', Auth::user()->company);
   if ($this->no){
    $res=main::find($this->no);
    if ($res){$this->dispatchBrowserEvent('mmsg', 'هذا الرقم مخزون مسبقا');$this->emit('goto','no');}
    else {$this->emit('goto','bankno');};}
  }
  public function ChkOrderAndGo(){

    Config::set('database.connections.other.database', Auth::user()->company);
   $res=sells_view::where('order_no',$this->orderno)
     ->whereNotIn('order_no', function($q){
       $q->select('order_no')->from('main');
     })
     ->whereNotIn('order_no', function($q){
       $q->select('order_no')->from('MainArc');
     })
     ->whereNotIn('order_no', function($q){
       $q->select('order_no')->from('MainRes');
     })->first();
   if ($res){
     $this->jeha=$res->jeha;

     $this->name=$res->jeha_name;
     $this->sul_tot=$res->tot;
     $this->dofa=$res->cash;
     $this->sul=$res->not_cash;
     $this->no=main::max('no')+1;
     $this->OrderGet=true;
     $this->order_no=$this->orderno;
     $this->emit('goto','no');
     $this->emit('TakeOrderNo',$res->order_no,$res->jeha_name);
   } else {$this->dispatchBrowserEvent('mmsg', 'هذا الرقم غير مخزون ');}
  }
  public function ChkPlaceAndGo(){
    Config::set('database.connections.other.database', Auth::user()->company);
    if ($this->place){
      $res=place::find($this->place);
      if (!$res){$this->dispatchBrowserEvent('mmsg', 'هذا الرقم غير مخزون ');$this->emit('goto','place');}
      else {$this->emit('goto','notes'); $this->emit('TakePlaceNo',$res->place_no,$res->place_name);};}
  }
  public function ChkKstCountAndGo(){
    if ($this->kstcount){
      $this->kst=$this->truncate( $this->sul/$this->kstcount);
      $this->CountGet=true;
      $this->emit('goto','kst');

    }
  }
  function truncate($val, $f="0")
  {
    if(($p = strpos($val, '.')) !== false) {
      $val = floatval(substr($val, 0, $p + 1 + $f));
    }
    return $val;
  }

  protected function rules()
  {
    Config::set('database.connections.other.database', Auth::user()->company);

    return [
      'order_no' => ['required','integer','gt:0', Rule::exists('other.sells')->where(function ($query) {
        $query->where('price_type', 2)
          ->whereNotIn('order_no', function($q){
            $q->select('order_no')->from('main');
          })
          ->whereNotIn('order_no', function($q){
            $q->select('order_no')->from('MainArc');
          })
          ->whereNotIn('order_no', function($q){
            $q->select('order_no')->from('MainRes');
          });
      })],
      'no' =>['required','integer','gt:0','unique:other.main,no','unique:other.MainArc,no'],
      'sul_date' => ['required','date'],
      'bankno' =>['required','integer','gt:0','exists:other.bank,bank_no'],
      'place' =>['required','integer','gt:0','exists:other.place,place_no'],
      'acc' => ['required','string'],
      'kstcount' => ['required','integer','gt:0'],
      'kst' => ['required','numeric','gt:0'],

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
  }
    public function render()
    {
      $this->sul_date=date('Y-m-d');

        return view('livewire.aksat.inp-main-head');
    }
}
