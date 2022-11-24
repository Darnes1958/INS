<?php

namespace App\Http\Livewire\Haf;

use App\Models\aksat\hafitha_tran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;


class HafInputTable extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';

  protected $listeners = [
    'TakeHafithaTable','DoDelete'
  ];
  public $hafitha=0;
  public $NoToAction;
  public $AccToAction;
  public function TakeHafithaTable($h){

    $this->hafitha=$h;
  }

  public function SelectItem($no,$acc,$action){

    $this->NoToAction=$no;
    $this->AccToAction=$acc;
    if ($action=='delete'){
      $this->dispatchBrowserEvent('delkst');
    }
  }
  public function DoDelete(){
    Config::set('database.connections.other.database', Auth::user()->company);
    DB::connection('other')->beginTransaction();

    try {
      DB::connection('other')->table('hafitha_tran')
        ->where('hafitha',$this->hafitha)
        ->where('no',$this->NoToAction)
        ->where('acc',$this->AccToAction)->delete();
      $summorahel=hafitha_tran::where('hafitha',$this->hafitha)->where('kst_type',1)->sum('kst');
      if ($summorahel==null) {$summorahel=0;}
      $sumover1=hafitha_tran::where('hafitha',$this->hafitha)->where('kst_type',2)->sum('kst');
      $sumover2=hafitha_tran::where('hafitha',$this->hafitha)->where('kst_type',2)->sum('kst');
      if ($sumover1==null) {$sumover1=0;}
      if ($sumover2==null) {$sumover2=0;}
      $sumover=$sumover1+$sumover2;
      $sumhalfover=hafitha_tran::where('hafitha',$this->hafitha)->where('kst_type',3)->sum('kst');
      $sumwrong=hafitha_tran::where('hafitha',$this->hafitha)->where('kst_type',4)->sum('kst');
      if ($sumwrong==null) {$sumwrong=0;}
      info($sumwrong);
      DB::connection('other')->table('hafitha')->where('hafitha_no',$this->hafitha)->update([
        'kst_morahel'=>$summorahel,'kst_over'=>$sumover,'kst_half_over'=>$sumhalfover,'kst_wrong'=>$sumwrong,
      ]);

      DB::connection('other')->commit();
      $this->emit('RefreshHead');
    } catch (\Exception $e) {
      DB::connection('other')->rollback();
      $this->dispatchBrowserEvent('mmsg', 'حدث خطأ');
    }

  }

  public function render()
    {

        return view('livewire.haf.haf-input-table',[
          'HafithaTable' =>DB::connection('other')
            ->table('hafitha_tran_view')
            ->where('hafitha_no',$this->hafitha)
            ->orderBy('acc','asc')
            ->orderBy('ser_in_hafitha','asc')
            ->paginate(15)]);
    }
}
