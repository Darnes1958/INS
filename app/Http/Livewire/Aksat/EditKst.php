<?php

namespace App\Http\Livewire\Aksat;


use App\Models\aksat\kst_trans;
use App\Models\Operations;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EditKst extends Component
{
  public $Edit_No;
  public $Edit_Ser;
  public $EditKsm_Date;
  public $EditKsm;
  public $EditNotes;


  protected $listeners = [
    'GetTheId','GetTheMainNo'
  ];
  public function GetTheMainNo($no){
    $this->Edit_No=$no;
  }
  protected function rules()
  {
    Config::set('database.connections.other.database', Auth::user()->company);
    return [
      'EditKsm_Date' => ['required'],
      'EditKsm' =>['required','numeric','gt:0'],
    ];
  }
  public function CloseMyTableEdit_live(){
    $this->dispatchBrowserEvent('CloseMyTableEdit');
  }
  public function EditSaveKsm()
  {
    $this->validate();

    DB::connection(Auth()->user()->company)->table('kst_trans')->where('no',$this->Edit_No)->where('ser',$this->Edit_Ser)->update([
      'ksm'=>$this->EditKsm,
      'ksm_date'=>$this->EditKsm_Date,
      'kst_notes'=>$this->EditNotes,
      'emp'=>auth::user()->empno,
    ]);
    Operations::insert(['Proce'=>'قسط','Oper'=>'تعديل','no'=>$this->Edit_No,'created_at'=>Carbon::now(),'emp'=>auth::user()->empno,]);

    $this->reset();
    $this->dispatchBrowserEvent('CloseMyTableEdit');
    $this->emitTo('tools.my-table','refreshComponent');
    $this->emitTo('aksat.inp-kst-head','Ksthead_goto','no');
  }
  public function GetTheId($ser){

    $this->Edit_Ser=$ser;

    $res=DB::connection(Auth()->user()->company)->table('kst_trans')->where('no',$this->Edit_No)->where('ser',$this->Edit_Ser)->first();

    $this->EditKsm_Date=$res->ksm_date;
    $this->EditKsm=$res->ksm;
    $this->EditNotes=$res->kst_notes;

  }


    public function render()
    {
      Config::set('database.connections.other.database', Auth::user()->company);
        return view('livewire.aksat.edit-kst');
    }
}
