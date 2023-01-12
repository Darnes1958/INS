<?php

namespace App\Http\Livewire\Bank;

use App\Models\bank\bank;
use App\Models\bank\BankTajmeehy;
use App\Models\bank\Companies;
use App\Models\OverTar\over_kst;
use App\Models\OverTar\over_kst_a;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;
use Livewire\WithPagination;

class InpTaj extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';
  public $TajNo;
  public $TajName;
  public $TajAcc;
  Public $CompNo;
  public $UpdateMod=false;

  public function updatedCompNo(){
    $this->emit('gotome','TajAcc');
  }
  protected function rules()
    {

      return [
        'CompNo' => ['required'],
        'TajAcc' =>   ['required'],
        'TajName' =>   ['required'],
      ];
    }
  protected $messages = [
    'required' => 'لا يجوز ترك فراغ',
    'unique' => 'هذا الاسم مخزون مسبقا',


  ];
  public function selectItem($taj_no,$action){
    $this->TajNo=$taj_no;
    if ($action=='delete') {$this->dispatchBrowserEvent('OpenMyDelete');}
    if ($action=='update') {

      $res=BankTajmeehy::on(Auth()->user()->company)->where('TajNo',$this->TajNo)->first();
      $this->TajAcc=$res->TajAcc;
      $this->TajName=$res->TajName;
      $this->CompNo=$res->CompNo;
      $this->UpdateMod=true;
    $this->emit('gotome','TajAcc');}
  }
  public function CloseDeleteDialog(){$this->dispatchBrowserEvent('CloseMyDelete');}
  public function CloseEditDialog(){$this->dispatchBrowserEvent('CloseMyEdit');}

  public function delete(){
    $this->CloseDeleteDialog();
    if (bank::on(Auth()->user()->company)->where('bank_tajmeeh',$this->TajNo)->exists()) {
      $this->dispatchBrowserEvent('mmsg', 'هذا المصرف مستخدم مسبقا ولا يمكن الغاءه');
      return false;
    }
    BankTajmeehy::on(Auth()->user()->company)->where('TajNo',$this->TajNo)->delete();
    $this->render();
  }
  public function Save(){
    $this->validate();
    if ($this->UpdateMod){
    BankTajmeehy::on(Auth()->user()->company)->where('TajNo',$this->TajNo)->update([
      'TajName'=>$this->TajName,
      'TajAcc'=>$this->TajAcc,
      'CompNo'=>$this->CompNo,
    ]);}
    else {
      BankTajmeehy::on(Auth()->user()->company)->insert([
        'TajName'=>$this->TajName,
        'TajAcc'=>$this->TajAcc,
        'CompNo'=>$this->CompNo,
      ]);}
    $this->CompNo='';
    $this->TajName='';
    $this->TajAcc='';
  }
    public function render()
    {
        return view('livewire.bank.inp-taj',[
        'CompTable'=>Companies::on(Auth()->user()->company)->get(),
        'TajTable'=>BankTajmeehy::on(Auth()->user()->company)->paginate(15)]);
    }
}
