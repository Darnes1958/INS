<?php

namespace App\Http\Livewire\OverTar;

use App\Models\bank\bank;
use App\Models\OverTar\stop_kst;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class InpStop2 extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';

   public $OpenDetail=false;
   public $bankno;
   public $acc;
   public $wrec_no;
   public $name;


   public $bankname;


   public $stop_date;
  public $TheBankListIsSelected;


  public function updatedTheBankListIsSelected(){
    $this->TheBankListIsSelected=0;
    $this->ChkBankAndGo();
  }
  public function ChkBankAndGo(){
    $this->bankname='';
    if ($this->bankno!=null) {
      $result = bank::where('bank_no',$this->bankno)->first();
      if ($result) {
        $this->emitTo('bank.bank-select','TakeBankNo',$this->bankno);
        $this->emitTo('over-tar.stop-table','TakeBankNo',$this->bankno);
        $this->bankname=$result->bankname;
        $this->emit('goto','acc');
      }}
  }
  public function selectItem($wrec_no,$action){
    $this->wrec_no=$wrec_no;
    if ($action=='delete') {$this->dispatchBrowserEvent('OpenMyDelete');}

  }
  public function CloseDeleteDialog(){$this->dispatchBrowserEvent('CloseMyDelete');}


  public function delete(){
    $this->CloseDeleteDialog();

    stop_kst::where('rec_no',$this->wrec_no)->delete();

    $this->render();
    $this->emit('goto','bankno');
  }

  protected function rules()
  {
       Config::set('database.connections.other.database', Auth::user()->company);
    return [
      'stop_date' => ['required','date'],
      'bankno' => ['required','integer','gt:0', 'exists:other.bank,bank_no'],
      'name' => 'required',
      'acc' => 'required',
    ];
  }
  protected $messages = [
    'required' => 'لا يجوز ترك فراغ',
  ];

   public function DoSave(){
     $this->validate();
      stop_kst::insert([
        'no'=>0,'name'=>$this->name,'bank'=>$this->bankno,'acc'=>$this->acc,
        'stop_type'=>2,'stop_date'=>$this->stop_date,'letters'=>0,'emp'=>auth::user()->empno,
       ]);
     $this->resetme();
     $this->emit('goto','bankno');
   }
  public function resetme(){
    $this->acc='';
    $this->name='';
    $this->stop_date=date('Y-m-d');
  }

    public function mount(){
     $this->resetme();
    }
    public function render()
    {
        return view('livewire.over-tar.inp-stop2',[
         'TableList'=>DB::connection(Auth()->user()->company)->table('stop_kst')
           ->join('bank','stop_kst.bank','=','bank.bank_no')
           ->select('stop_kst.*','bank.bank_tajmeeh')
          ->where('stop_type',2)
          ->where('bank',$this->bankno)
          ->orderBy('rec_no','asc')
          ->paginate(10),]);
    }
}
