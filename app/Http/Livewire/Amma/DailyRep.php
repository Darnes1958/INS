<?php

namespace App\Http\Livewire\Amma;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class DailyRep extends Component
{
    public $RepRadio='sells_view';
    public $RepDate='order_date_input';
    public $RepSearch1='jeha_name';
    public $ByChk=false;
    public $By;

    public $DateVal;

    public function BackupBtn(){
        $dbpath='D:\backup\mybak33.bak';

       // DB::statement('BACKUP DATABASE '.Auth::user()->company.' TO DISK = \''.$dbpath.'\'  ');
       // DB::connection('other')->statement('use master; EXEC [DBbackup] \'Daibany\',\'c:\backup\mydb222.bak\'');
        return Storage::download('Elawamy_12122022071901.bak');
    }

    public function updatedRepRadio(){
        if ($this->RepRadio=='store_exp_view') {$this->RepSearch1='item_name';$this->RepDate='exp_date';}
        if ($this->RepRadio=='tar_buy_view') {$this->RepSearch1='item_name';$this->RepDate='created_at';}
        if ($this->RepRadio=='buys_view') {$this->RepSearch1='jeha_name';$this->RepDate='order_date_input';}
        if ($this->RepRadio=='sells_view') {$this->RepSearch1='jeha_name';$this->RepDate='order_date_input';}
        if ($this->RepRadio=='rep_sell_tran') {$this->RepSearch1='item_name';$this->RepDate='order_date';}
        if ($this->RepRadio=='tran_view') {$this->RepSearch1='jeha_name';$this->RepDate='inp_date';}
        if ($this->RepRadio=='main_view') {$this->RepSearch1='name';$this->RepDate='inp_date';}

      if ($this->RepRadio=='over_view') {$this->RepSearch1='name';$this->RepDate='inp_date';}
      if ($this->RepRadio=='wrong_view') {$this->RepSearch1='name';$this->RepDate='inp_date';}
      if ($this->RepRadio=='tar_view') {$this->RepSearch1='name';$this->RepDate='inp_date';}


        $this->emitTo('amma.daily-rep-table','TakeParams',
            $this->RepRadio,$this->RepDate,$this->RepSearch1);
    }
    public function updatedByChk()
    {

        $this->emitTo('amma.daily-rep-table','TakeBy',
            $this->ByChk,$this->By);
    }
    public function updatedBy()
    {

        $this->emitTo('amma.daily-rep-table','TakeBy',
            $this->ByChk,$this->By);
    }
    public function ChkDateAndGo(){
      $this->emitTo('amma.daily-rep-table','TakeDate',$this->DateVal);

    }
  public function updatedDateVal(){
    $this->emitTo('amma.daily-rep-table','TakeDate',$this->DateVal);
  }

 public function mount(){
      $this->DateVal=date('Y-m-d');
 }

    public function render()
    {

        return view('livewire.amma.daily-rep',[
            'UserName'=>User::where('company',Auth::user()->company)->get(),
        ]);
    }
}
