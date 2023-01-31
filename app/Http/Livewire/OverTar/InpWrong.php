<?php

namespace App\Http\Livewire\OverTar;

use App\Models\bank\bank;
use App\Models\OverTar\wrong_Kst;
use Illuminate\Support\Facades\Auth;
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

    if ($this->bankno!=null) {
      $result = bank::on(Auth()->user()->company)->where('bank_no',$this->bankno)->first();
      if ($result) {
        $this->BankGet=true;
        $this->emitTo('over-tar.wrong-table','TakeBank',$this->bankno);
        $this->emit('goto','acc');
      }}
  }
  public function SaveWrong(){

    $wrong_no=wrong_Kst::on(Auth()->user()->company)->max('wrong_no')+1;
    wrong_Kst::on(Auth()->user()->company)->insert([
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
