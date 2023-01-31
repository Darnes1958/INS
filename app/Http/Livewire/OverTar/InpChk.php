<?php

namespace App\Http\Livewire\OverTar;

use App\Models\aksat\chk_tasleem;
use App\Models\bank\bank;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class InpChk extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';

   public $Proc;
   public $OpenDetail=false;
   public $bankno;
   public $bank_name;
   public $acc;
   public $no;
   public $name;

   public $MainOrArc='main';

   public $chk_in;
   public $chk_out;
   public $chk_count;
   public $chk_to_delete;
   public $wdate;
   public $rec_no;
   protected $listeners = [
    'TakeData'
  ];
  public function CloseDeleteDialog(){$this->dispatchBrowserEvent('CloseMyDelete');}
  public function selectItem($rec_no,$count){
    $this->rec_no=$rec_no;
    $this->chk_to_delete=$count;
    $this->dispatchBrowserEvent('OpenMyDelete');
  }
  public function delete(){
    $this->CloseDeleteDialog();
    DB::connection(Auth()->user()->company)->beginTransaction();
    try {
    chk_tasleem::on(Auth()->user()->company)->where('rec_no',$this->rec_no)->delete();
    DB::connection(Auth()->user()->company)->table($this->MainOrArc)->
     where('no',$this->no)->decrement('chk_out',$this->chk_to_delete);
    DB::connection(Auth()->user()->company)->commit();
    } catch (\Exception $e) {

     DB::connection(Auth()->user()->company)->rollback();
     $this->dispatchBrowserEvent('mmsg', 'حدث خطأ');

      }


    $this->render();
    $this->emitTo('over-tar.get-no-and-acc','gotoyou','bankno');

  }
   public function TakeData($bankno,$acc,$no,$name){
     $this->bankno=$bankno;
     $this->bank_name=bank::on(auth()->user()->company)->find($bankno)->bank_name;
     $this->acc=$acc;
     $this->no=$no;
     $this->name=$name;
     $res=DB::connection(Auth()->user()->company)->table($this->MainOrArc)->where('no',$no)->first();
     $this->chk_in=$res->chk_in;
     $this->chk_out=$res->chk_out;
     $this->OpenDetail=true;
     $this->emit('gotodet','chk_count');
   }
  protected function rules()
  {
    return [
      'wdate' => ['required','date'],
      'chk_count' => ['required','int','gt:0'],
    ];
  }
  protected $messages = [
    'required' => 'لا يجوز ترك فراغ',
    'wdate.required' => 'تاريخ خطأ',

  ];

   public function DoSave(){
     $this->validate();
     if ($this->chk_count>($this->chk_in-$this->chk_out))
     {
       $this->dispatchBrowserEvent('mmsg', 'يجب أن لا يتجاوز العدد '.($this->chk_in-$this->chk_out));
       return;
     }
     DB::connection(Auth()->user()->company)->beginTransaction();
     try {


     chk_tasleem::on(auth()->user()->company)->insert([
       'no'=>$this->no,
       'chk_count'=>$this->chk_count,
       'wdate'=>$this->wdate,
       'emp'=>Auth()->user()->empno,
     ]);
     DB::connection(Auth()->user()->company)->table($this->MainOrArc)->
      where('no',$this->no)->increment('chk_out',$this->chk_count);

       DB::connection(Auth()->user()->company)->commit();
       $this->chk_in='';
       $this->chk_out='';
       $this->chk_count='';
       $this->wdate='';
       $this->OpenDetail=false;
       $this->emitTo('over-tar.get-no-and-acc','gotoyou','bankno');


   } catch (\Exception $e) {

     DB::connection(Auth()->user()->company)->rollback();
       $this->dispatchBrowserEvent('mmsg', 'حدث خطأ');

   }


   }
    public function mount(){


    }
    public function render()
    {
      $this->wdate=date('Y-m-d');
        return view('livewire.over-tar.inp-chk',[
          'TableList'=>chk_tasleem::on(Auth::user()->company)->where('no',$this->no)->paginate(10)
        ]);
    }
}
