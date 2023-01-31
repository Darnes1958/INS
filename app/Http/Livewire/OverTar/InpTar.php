<?php

namespace App\Http\Livewire\OverTar;

use App\Models\bank\bank;
use Livewire\Component;

class InpTar extends Component
{
  public $bankno;
  public $tar_date;
  public $ksm_type=2;
  public $BankGet=false;
  public $TheBankListIsSelectd;
  public $Proc='over_kst';

  protected $listeners =['TakeBankGet',];

  public function TakeBankGet($bankget){
    $this->BankGet=$bankget;
  }
  public function updatedProc(){
    $this->emitTo('over-tar.tar-table','TakeProc',$this->Proc);
  }
  public function updatedTheBankListIsSelectd(){
    $this->TheBankListIsSelectd=0;
    $this->ChkBankAndGo();
  }

  public function ChkBankAndGo(){


    if ($this->bankno!=null) {
      $result = bank::on(Auth()->user()->company)->where('bank_no',$this->bankno)->first();
      if ($result) {

        $this->emitTo('over-tar.tar-table','TakeBank',$this->bankno);
        $this->emit('goto','no');
      }}

  }
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
 public function SaveTar(){
   $this->validate();
   $this->emitTo('over-tar.tar-table','SaveTar',$this->tar_date,$this->ksm_type);
 }
 public function mount(){
   $this->tar_date=date('Y-m-d');
 }

    public function render()
    {

        return view('livewire.over-tar.inp-tar');
    }
}
