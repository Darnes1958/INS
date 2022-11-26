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
    'TakeHafithaTable','DoDelete','CloseUpdate'
  ];
  public $hafitha=0;

  public $NoToAction;
  public $AccToAction;
  public $search;
  public $DisRadio='DisAll';
  public function updatingSearch()
    {
        $this->resetPage();
    }
  public function TakeHafithaTable($h){
    $this->hafitha=$h;
  }

    public function CloseUpdate(){
        $this->dispatchBrowserEvent('CloseUpdateModal');
    }

    public function SelectItem($no,$acc,$ser,$action){

    $this->NoToAction=$no;
    $this->AccToAction=$acc;
    if ($action=='delete'){
      $this->dispatchBrowserEvent('delkst');
    }
    if ($action=='update'){
        $this->emit('ParamToUpdate',$this->hafitha,$ser);
        $this->dispatchBrowserEvent('OpenUpdateModal');
    }
  }
  public function DoDelete(){
    Config::set('database.connections.other.database', Auth::user()->company);
    DB::connection('other')->beginTransaction();

    try {
       
      DB::connection('other')->table('hafitha_tran')
        ->where('hafitha',$this->hafitha)
        ->where('no',$this->NoToAction)
        ->where('acc',strval($this->AccToAction))->delete();

      $summorahel=hafitha_tran::where('hafitha',$this->hafitha)->where('kst_type',1)->sum('kst');
      if ($summorahel==null) {$summorahel=0;}
      $sumover1=hafitha_tran::where('hafitha',$this->hafitha)->where('kst_type',2)->sum('kst');
      $sumover2=hafitha_tran::where('hafitha',$this->hafitha)->where('kst_type',3)->sum('baky');
      $sumover3=hafitha_tran::where('hafitha',$this->hafitha)->where('kst_type',5)->sum('kst');

      if ($sumover1==null) {$sumover1=0;}
      if ($sumover2==null) {$sumover2=0;}
      if ($sumover3==null) {$sumover3=0;}
      $sumover=$sumover1+$sumover2+$sumover3;
      $sumhalfover=hafitha_tran::where('hafitha',$this->hafitha)->where('kst_type',3)->sum('kst');
      $sumwrong=hafitha_tran::where('hafitha',$this->hafitha)->where('kst_type',4)->sum('kst');
      if ($sumwrong==null) {$sumwrong=0;}

      DB::connection('other')->table('hafitha')->where('hafitha_no',$this->hafitha)->update([
        'kst_morahel'=>$summorahel,'kst_over'=>$sumover,'kst_half_over'=>$sumhalfover,'kst_wrong'=>$sumwrong,
      ]);

      DB::connection('other')->commit();
      $this->emit('RefreshHead');

    } catch (\Exception $e) {
        info($e);
      DB::connection('other')->rollback();
      $this->dispatchBrowserEvent('mmsg', 'حدث خطأ');
    }

  }
  public function render()
    {
    return view('livewire.haf.haf-input-table',[
        'HafithaTable' =>DB::connection('other')
            ->table('hafitha_tran_view')
            ->when($this->search || $this->DisRadio=='DisAll', function($q)  {
                return $q->where([
                            ['hafitha_no', '=', $this->hafitha],
                            ['name', 'like', '%'.$this->search.'%'],])
                         ->orwhere([
                            ['hafitha_no', '=', $this->hafitha],
                            ['acc', 'like', '%'.$this->search.'%'],]);       })
            ->when($this->search || $this->DisRadio=='DisMe', function($q)  {
                return $q->where([
                    ['hafitha_no', '=', $this->hafitha],
                    ['emp','=',Auth::user()->empno],
                    ['name', 'like', '%'.$this->search.'%'],])
                    ->orwhere([
                        ['hafitha_no', '=', $this->hafitha],
                        ['acc', 'like', '%'.$this->search.'%'],]);       })



            ->when(!$this->search || $this->DisRadio=='DisAll', function($q)  {
                return $q->where([
                    ['hafitha_no', '=', $this->hafitha],]);       })
            ->when(!$this->search || $this->DisRadio=='DisMe', function($q)  {
                return $q->where([
                    ['hafitha_no', '=', $this->hafitha],
                    ['emp','=',Auth::user()->empno], ]);       })

            ->orderBy('acc','asc')
            ->orderBy('ser_in_hafitha','asc')
            ->paginate(15)]);
    }
}
