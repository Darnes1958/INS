<?php

namespace App\Http\Livewire\OverTar;

use App\Models\Operations;
use App\Models\OverTar\wrong_Kst;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EditWrong extends Component
{
  public $wrong_no;
  public $kst;
  public $tar_date;
  public $acc;
  public $name;

  protected $listeners = [
    'ToEditWrong',
  ];

  public function ToEditWrong($wrong_no){
    $this->wrong_no=$wrong_no;
    $res=wrong_Kst::on(Auth()->user()->company)->where('wrong_no',$this->wrong_no)->first();
    $this->name=$res->name;
    $this->kst=$res->kst;
    $this->acc=$res->acc;
    $this->tar_date=$res->tar_date;

  }
  protected function rules()
  {
   return [
        'tar_date' => ['required','date'],
        'kst' => ['required','numeric'],
        'acc' => ['required','string'],
        'name' => ['required','string'],
    ];
  }
  protected $messages = [
    'required' => 'لا يجوز ترك فراغ',
    'tar_date.required'=>'يجب ادخال تاريخ صحيح',
  ];
  public function SaveWrong(){
    $this->validate();

    wrong_Kst::on(Auth()->user()->company)->where('wrong_no',$this->wrong_no)->update(
      [
        'kst'=>$this->kst,
        'tar_date'=>$this->tar_date,
        'acc'=>$this->acc,
        'name'=>$this->name,
      ]
    );
    Operations::insert(['Proce'=>'بالخطأ','Oper'=>'نعديل','no'=>0,'created_at'=>Carbon::now(),'emp'=>auth::user()->empno,]);

    $this->emitTo('over-tar.wrong-table','closeandrefresh');
  }
  public function render()
    {
        return view('livewire.over-tar.edit-wrong');
    }
}
