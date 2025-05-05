<?php

namespace App\Http\Livewire\Bank;

use App\Models\aksat\main;
use App\Models\bank\bank;
use App\Models\bank\BankTajmeehy;
use Livewire\Component;
use Livewire\WithPagination;

class InpBank extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';
  public $bank_tajmeeh;
  public $bank_no;
  public $bank_name;
  public $search;
  public $bank_code;

  public $UpdateMod=false;

  public function updated($field){
    if ($field=='bank_tajmeeh')
     $this->emit('gotome','bank_code');
  }
  protected function rules()
  {

    return [
      'bank_tajmeeh' => ['required'],

      'bank_name' =>   ['required'],
      'bank_code' =>   ['required'],
    ];
  }
  protected $messages = [
    'required' => 'لا يجوز ترك فراغ',
  ];
  public function selectItem($bank_no,$action){
    $this->bank_no=$bank_no;
    if ($action=='delete') {$this->UpdateMod=false;$this->dispatchBrowserEvent('OpenMyDelete');}
    if ($action=='update') {

      $res=bank::on(Auth()->user()->company)->where('bank_no',$this->bank_no)->first();
      $this->bank_tajmeeh=$res->bank_tajmeeh;
      $this->bank_name=$res->bank_name;
      $this->bank_code=$res->bank_code;
      $this->UpdateMod=true;
      $this->emit('gotome','bank_code');}
  }
  public function CloseDeleteDialog(){$this->dispatchBrowserEvent('CloseMyDelete');}
  public function CloseEditDialog(){$this->dispatchBrowserEvent('CloseMyEdit');}

  public function delete(){
    $this->CloseDeleteDialog();
    if (main::on(Auth()->user()->company)->where('bank',$this->bank_no)->exists()) {
      $this->dispatchBrowserEvent('mmsg', 'هذا المصرف مستخدم مسبقا ولا يمكن الغاءه');
      return false;
    }
    bank::on(Auth()->user()->company)->where('bank_no',$this->bank_no)->delete();
    $this->render();
  }
  public function Save(){
    $this->validate();
    if ($this->UpdateMod){
      $tajacc=BankTajmeehy::on(Auth()->user()->company)->where('TajNo',$this->bank_tajmeeh)->first()->TajAcc;
      bank::on(Auth()->user()->company)->where('bank_no',$this->bank_no)->update([
        'bank_name'=>$this->bank_name,
        'bank_code'=>$this->bank_code,
        'bank_tajmeeh'=>$this->bank_tajmeeh,
        'acc_tajmeeh'=>$tajacc,
      ]);}
    else {
      $this->bank_no=bank::on(Auth()->user()->company)->max('bank_no')+1;
      $tajacc=BankTajmeehy::on(Auth()->user()->company)->where('TajNo',$this->bank_tajmeeh)->first()->TajAcc;
      bank::on(Auth()->user()->company)->insert([
        'bank_no'=>$this->bank_no,
        'bank_name'=>$this->bank_name,
        'bank_code'=>$this->bank_code,
        'bank_acc'=>0,
        'bank_tajmeeh'=>$this->bank_tajmeeh,
        'acc_tajmeeh'=>$tajacc,
      ]);}
    $this->UpdateMod=false;
    $this->bank_no='';
    $this->bank_name='';
    $this->bank_code='';
  }
    public function render()
    {
        return view('livewire.bank.inp-bank',[
          'TajTable'=>BankTajmeehy::on(Auth()->user()->company)->get(),
          'BankTable'=>bank::on(Auth()->user()->company)
          ->join('BankTajmeehy','bank.bank_tajmeeh','=','BankTajmeehy.TajNo')
          ->select('bank_no','bank_name','bank_code','TajName')
          ->where('bank_name', 'like', '%' . $this->search . '%')
          ->paginate(15)]);
    }
}
