<?php

namespace App\Http\Livewire\OverTar;

use App\Models\OverTar\over_kst;
use App\Models\OverTar\over_kst_a;
use Livewire\Component;

class EditOver extends Component
{
  public $editwrec_no;
  public $editkst;
  public $edittar_date;
  public $Proc='over_kst';

  protected $listeners = [
          'ToEditOver',
  ];
  public function ToEditOver($wrec_no,$proc){

    $this->editwrec_no=$wrec_no;
    if ($proc=='over_kst') $res=over_kst::on(Auth()->user()->company)->find($wrec_no);
    if ($proc=='over_kst_a') $res=over_kst_a::on(Auth()->user()->company)->find($wrec_no);
    $this->edittar_date=$res->tar_date;
    $this->editkst=$res->kst;

  }
  protected function rules()
  {
    return [
      'edittar_date' => ['required','date'],
      'editkst' =>['required','numeric','gt:0'],
    ];
  }
  protected $messages = [
    'required' => 'لا يجوز ترك فراغ',
    'edittran_date.required'=>'يجب ادخال تاريخ صحيح',
  ];
  public function SaveVal(){

    $this->validate();

    if ($this->Proc=='over_kst')
     over_kst::on(Auth()->user()->company)->where('wrec_no',$this->editwrec_no)->update(
      [
        'kst'=>$this->editkst,
        'tar_date'=>$this->edittar_date,
      ]
    );
      if ($this->Proc=='over_kst_a')
          over_kst_a::on(Auth()->user()->company)->where('wrec_no',$this->editwrec_no)->update(
              [
                  'kst'=>$this->editkst,
                  'tar_date'=>$this->edittar_date,
              ]
          );

    $this->emitTo('over-tar.over-table','closeandrefresh');
  }
  public function render()
    {

        return view('livewire.over-tar.edit-over');
    }
}
