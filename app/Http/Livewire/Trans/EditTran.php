<?php

namespace App\Http\Livewire\Trans;

use App\Models\trans\trans;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class EditTran extends Component
{
  public $edittran_no;
  public $editval;
  public $edittran_date;
  public $editnotes;

  protected $listeners = [
    'ToEditTran',
  ];
  public function ToEditTran($tran_no){
    Config::set('database.connections.other.database', Auth::user()->company);
    $this->edittran_no=$tran_no;
    $res=trans::find($tran_no);
    $this->edittran_date=$res->tran_date;
    $this->editval=$res->val;
    $this->editnotes=$res->notes;
  }
  protected function rules()
  {

    return [
      'edittran_date' => ['required','date'],
      'editval' =>['required','numeric','gt:0'],
    ];
  }
  protected $messages = [
    'required' => 'لا يجوز ترك فراغ',
    'edittran_date.required'=>'يجب ادخال تاريخ صحيح',
  ];
  public function SaveVal(){
    $this->validate();
    Config::set('database.connections.other.database', Auth::user()->company);
    trans::where('tran_no',$this->edittran_no)->update(
      [
        'val'=>$this->editval,
        'tran_date'=>$this->edittran_date,
        'notes'=>$this->editnotes,
      ]
    );

    $this->emitTo('trans.trans-table','closeandrefresh');
  }
  public function render()
    {
        return view('livewire.trans.edit-tran');
    }
}
