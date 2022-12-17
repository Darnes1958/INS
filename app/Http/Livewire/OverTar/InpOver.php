<?php

namespace App\Http\Livewire\OverTar;

use App\Models\OverTar\over_kst;
use App\Models\OverTar\over_kst_a;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class InpOver extends Component
{

   public $Proc;
   public $OpenDetail=false;
   public $bankno;
   public $acc;
   public $no;
   public $name;

   public $kst;
   public $tar_date;
   protected $listeners = [
    'TakeData'
  ];

   public function TakeData($bankno,$acc,$no,$name){
     $this->bankno=$bankno;
     $this->acc=$acc;
     $this->no=$no;
     $this->name=$name;
     $this->OpenDetail=true;
     $this->emit('gotodet','kst');
   }
  protected function rules()
  {

    return [
      'tar_date' => ['required','date'],
      'kst' => ['required','numeric','gt:0'],
    ];
  }
  protected $messages = [
    'required' => 'لا يجوز ترك فراغ',
    'ksm_date.required' => 'تاريخ خطأ',
  ];

   public function DoSave(){
     $this->validate();
     Config::set('database.connections.other.database', Auth::user()->company);
     if ($this->Proc=='over_kst')
       over_kst::insert([
        'no'=>$this->no,'name'=>$this->name,'bank'=>$this->bankno,'acc'=>$this->acc,'kst'=>$this->kst,
        'tar_type'=>1,'tar_date'=>$this->tar_date,'letters'=>0,'emp'=>auth::user()->empno,
        'h_no'=>0,'inp_date'=>date('Y-m-d'),
       ]);
     if ($this->Proc=='over_kst_a')
       over_kst_a::insert([
         'no'=>$this->no,'name'=>$this->name,'bank'=>$this->bankno,'acc'=>$this->acc,'kst'=>$this->kst,
         'tar_type'=>1,'tar_date'=>$this->tar_date,'letters'=>0,'emp'=>auth::user()->empno,
         'h_no'=>0,'inp_date'=>date('Y-m-d'),
       ]);

     $this->kst='';
     $this->OpenDetail=false;
     $this->emit('goto','no');
   }
    public function mount($proc='over_kst'){
      $this->Proc=$proc;
      $this->tar_date=date('Y-m-d');
    }
    public function render()
    {
        return view('livewire.over-tar.inp-over');
    }
}
