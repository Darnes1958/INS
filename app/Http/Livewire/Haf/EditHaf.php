<?php

namespace App\Http\Livewire\Haf;

use App\Models\aksat\hafitha;
use Livewire\Component;

class EditHaf extends Component
{
    public $edithaf_no;
    public $edithaf_tot;
    public $edithaf_date;


    protected $listeners = [
        'ToEditHaf',
    ];
    public function ToEditHaf($hafitha){

        $this->edithaf_no=$hafitha;
        $res=hafitha::on(Auth()->user()->company)->find($hafitha);
        $this->edithaf_date=$res->hafitha_date;
        $this->edithaf_tot=$res->hafitha_tot;

    }
    protected function rules()
    {

        return [
            'edithaf_date' => ['required','date'],
            'edithaf_tot' =>['required','numeric','gt:0'],
        ];
    }
    protected $messages = [
        'required' => 'لا يجوز ترك فراغ',
        'edithaf_date.required'=>'يجب ادخال تاريخ صحيح',
    ];
    public function SaveEditHaf(){
        $this->validate();

        hafitha::on(Auth()->user()->company)->where('hafitha_no',$this->edithaf_no)->update(
            [
                'hafitha_tot'=>$this->edithaf_tot,
                'hafitha_date'=>$this->edithaf_date,

            ]
        );

        $this->emitTo('haf.haf-input-header','TheHafUpdated');
    }
    public function render()
    {
        return view('livewire.haf.edit-haf');
    }
}
