<?php

namespace App\Http\Livewire\Haf;

use App\Models\bank\bank;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;


class HafInputHeader extends Component
{


 public $hafitha;
 public $bank;
 public $hafitha_date;
 public $hafitha_tot;
 public $hafitha_enter;
 public $hafitha_differ;
 public $HafHeadDetail;

 public $TheBankListIsSelectd;

  public function updatedTheBankListIsSelectd(){
    $this->TheBankListIsSelectd=0;
    $this->ChkBankAndGo();
  }

 public function ChkBankAndGo(){
   Config::set('database.connections.other.database', Auth::user()->company);

   if ($this->bank!=null) {
     $result=DB::connection('other')->
     table('hafitha_view')->where('hafitha_state','=',0)
       ->where('bank',$this->bank)
       ->first();

     if ($result) {
       $this->hafitha=$result->hafitha_no;
       $this->hafitha_date=$result->hafitha_date;
       $this->hafitha_tot=number_format($result->hafitha_tot,2, '.', '');
       $this->hafitha_enter=number_format($result->kst_morahel+$result->kst_half_over+$result->kst_over+$result->kst_wrong,2, '.', '');
       $this->hafitha_differ=number_format($this->hafitha_tot-$this->hafitha_enter,2, '.', '');
       $this->HafHeadDetail=DB::connection('other')
         ->table('hafitha_tran')
         ->join('kst_type', 'hafitha_tran.kst_type', '=', 'kst_type_no')
         ->where('hafitha','=',$this->hafitha)
         ->selectRaw('hafitha_tran.kst_type,kst_type.kst_type_name,count(*) as  wcount,sum(kst) as sumkst')
         ->groupby('hafitha_tran.kst_type','kst_type.kst_type_name')
         ->get();
         $this->emit('TakeHafithaTable',$this->hafitha);
         $this->emit('TakeHafithaDetail',$this->hafitha,$this->bank);

     }}

}
    public function render()
    {
        return view('livewire.haf.haf-input-header');
    }
}
