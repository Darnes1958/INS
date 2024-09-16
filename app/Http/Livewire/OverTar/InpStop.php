<?php

namespace App\Http\Livewire\OverTar;

use App\Models\OverTar\stop_kst;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class InpStop extends Component
{
   public $OpenDetail=false;
   public $bankno;
   public $acc;
   public $no;
   public $name;

   public $kst;
   public $stop_date;
   protected $listeners = [
    'TakeData'
  ];

   public function TakeData($bankno,$acc,$no,$name){
     $this->bankno=$bankno;
     $this->acc=$acc;
     $this->no=$no;
     $this->name=$name;
     $this->OpenDetail=true;
     $this->emit('gotodet','stop_date');
   }
  public function storDate(){
       $this->validate();
       $this->emitTo('over-tar.stop-table','TakeDate',$this->stop_date);
       $this->emit('gotodet','SaveBtn');
  }
  protected function rules()
  {
    return [
      'stop_date' => ['required','date'],

    ];
  }
  protected $messages = [
    'required' => 'تاريخ خطأ',

  ];

   public function DoSave(){
     $this->validate();
      stop_kst::on(Auth()->user()->company)->insert([
        'no'=>$this->no,'name'=>$this->name,'bank'=>$this->bankno,'acc'=>$this->acc,
        'stop_type'=>1,'stop_date'=>$this->stop_date,'letters'=>0,'emp'=>auth::user()->empno,
       ]);

     $this->OpenDetail=false;
     $this->emit('TakeNo',$this->no);
     $this->emit('goto','no');
   }
    public function mount(){

      $this->stop_date=date('Y-m-d');
    }
    public function render()
    {
        return view('livewire.over-tar.inp-stop');
    }
}
