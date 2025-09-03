<?php

namespace App\Http\Livewire\Haf;

use App\Models\aksat\hafitha_tran;
use App\Models\aksat\ManyNo;
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
    'TakeHafithaTable','DoDelete','CloseUpdate',
      'CloseManyNoModal','DoNotWrite','refreshHafInputTable' => '$refresh',
  ];
  public $HaveManyNo=0;
  public $hafitha=0;

  public $NoToAction;
  public $AccToAction;
  public $SerToAction;
  public $search;
  public $DisRadio='DisAll';
  public $index='ser_in_hafitha';

    public function OpenManyNo() {


        $this->emitTo('haf.haf-many-no','TakeHafNo',$this->hafitha);

        $this->dispatchBrowserEvent('OpenManyNoModal');

    }


    public function DoIndex($index){
      $this->index=$index;
  }

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
    public function CloseManyNoModal(){
        $this->dispatchBrowserEvent('CloseManyNoModal');
    }

    public function SelectItem($no,$acc,$ser,$action){

    $this->NoToAction=$no;
    $this->AccToAction=$acc;
    $this->SerToAction=$ser;
    if ($action=='delete'){
      $this->dispatchBrowserEvent('delkst');
    }
    if ($action=='update'){
        if (hafitha_tran::where('hafitha',$this->hafitha)->where('no',$no)->where('acc',$acc)->count()>1)
        {
          $this->dispatchBrowserEvent('mmsg','لا يجوز التعديل في حالة اكثر من قسط لزبون');
          return false;
        }
        $this->emit('ParamToUpdate',$this->hafitha,$ser);
        $this->dispatchBrowserEvent('OpenUpdateModal');
    }
  }
  public function DoDelete(){


    DB::connection(Auth()->user()->company)->beginTransaction();

    try {

      if ($this->NoToAction!=0)
      {DB::connection(Auth()->user()->company)->table('hafitha_tran')
        ->where('hafitha',$this->hafitha)
        ->where('no',$this->NoToAction)->delete();}
      else
      {DB::connection(Auth()->user()->company)->table('hafitha_tran')
        ->where('hafitha',$this->hafitha)
        ->where('ser_in_hafitha',$this->SerToAction)->delete();}

      $summorahel=hafitha_tran::on(Auth()->user()->company)->where('hafitha',$this->hafitha)->where('kst_type',1)->sum('kst');
      if ($summorahel==null) {$summorahel=0;}
      $sumover1=hafitha_tran::on(Auth()->user()->company)->where('hafitha',$this->hafitha)->where('kst_type',2)->sum('kst');
      $sumover2=hafitha_tran::on(Auth()->user()->company)->where('hafitha',$this->hafitha)->where('kst_type',3)->sum('baky');
      $sumover3=hafitha_tran::on(Auth()->user()->company)->where('hafitha',$this->hafitha)->where('kst_type',5)->sum('kst');

      if ($sumover1==null) {$sumover1=0;}
      if ($sumover2==null) {$sumover2=0;}
      if ($sumover3==null) {$sumover3=0;}
      $sumover=$sumover1+$sumover2+$sumover3;
      $sumhalfover=hafitha_tran::on(Auth()->user()->company)->where('hafitha',$this->hafitha)->where('kst_type',3)->sum('kst');
      $sumwrong=hafitha_tran::on(Auth()->user()->company)->where('hafitha',$this->hafitha)->where('kst_type',4)->sum('kst');
      if ($sumwrong==null) {$sumwrong=0;}
      $sumwrong_after=hafitha_tran::on(Auth()->user()->company)->where('hafitha',$this->hafitha)->where('kst_type',6)->sum('kst');
      if ($sumwrong_after==null) {$sumwrong_after=0;}

      DB::connection(Auth()->user()->company)->table('hafitha')->where('hafitha_no',$this->hafitha)->update([
        'kst_morahel'=>$summorahel,'kst_over'=>$sumover,'kst_half_over'=>$sumhalfover,'kst_wrong'=>$sumwrong,'kst_wrong_after'=>$sumwrong_after,
      ]);

      DB::connection(Auth()->user()->company)->commit();
      $this->emit('RefreshHead');
      $this->emit('DoChkBankNo');


    } catch (\Exception $e) {

      DB::connection(Auth()->user()->company)->rollback();
      $this->dispatchBrowserEvent('mmsg', 'حدث خطأ');
    }

  }
  public function render()
    {
     $this->HaveManyNo=ManyNo::where('h_no',$this->hafitha)->count();
    return view('livewire.haf.haf-input-table',[
        'ManyNo'=>ManyNo::where('h_no',$this->hafitha)->paginate(10),
        'HafithaTable'=> hafitha_tran::
            join('kst_type','kst_type.kst_type_no','=','hafitha_tran.kst_type')
        ->where('hafitha',$this->hafitha)

           ->when($this->search , function($q)  {
                return $q->where('name', 'like', '%'.$this->search.'%')
                         ->orwhere('acc', 'like', '%'.$this->search.'%');
           })
            ->orderBy($this->index,'asc')
            ->paginate(15)]);
    }
}
