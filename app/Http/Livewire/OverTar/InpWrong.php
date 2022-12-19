<?php

namespace App\Http\Livewire\OverTar;

use App\Models\bank\bank;
use App\Models\OverTar\wrong_Kst;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class InpWrong extends Component
{
  public $bankno;
  public $tar_date;

  public $kst;
  public $acc;
  public $name;
  public $BankGet=false;
  public $TheBankListIsSelectd;

  public function updatedTheBankListIsSelectd(){
    $this->TheBankListIsSelectd=0;
    $this->ChkBankAndGo();
  }
  public function updatedBankno(){
    $this->BankGet=false;
  }
  public function ChkBankAndGo(){
    Config::set('database.connections.other.database', Auth::user()->company);
    if ($this->bankno!=null) {
      $result = bank::where('bank_no',$this->bankno)->first();
      if ($result) {
        $this->BankGet=true;
        $this->emitTo('over-tar.wrong-table','TakeBank',$this->bankno);
        $this->emit('goto','acc');
      }}
  }
  public function SaveWrong(){
    Config::set('database.connections.other.database', Auth::user()->company);
    $wrong_no=wrong_Kst::max('wrong_no')+1;
    wrong_Kst::insert([
      'wrong_no'=>$wrong_no,
      'name'=>$this->name,
      'bank'=>$this->bankno,
      'acc'=>$this->acc,
      'kst'=>$this->kst,
      'tar_date'=>$this->tar_date,
      'morahel'=>0,
      'emp'=>Auth::user()->empno,
    ]);
    $this->kst='';
    $this->emit('goto','acc');
  }
  protected function rules()
  {
    return [
      'tar_date' => ['required','date'],
      'kst' => ['required','numeric'],
      'acc' => ['required','string'],
      'name' => ['required','string'],
    ];
  }
  protected $messages = [
    'required' => 'لا يجوز ترك فراغ',
    'ksm_date.required' => 'تاريخ خطأ',
  ];
 public function mount(){
    $this->tar_date=date('Y-m-d');
 }
    public function render()
    {
        return view('livewire.over-tar.inp-wrong');
    }
}
