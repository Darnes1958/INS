<?php

namespace App\Http\Livewire\Masr;

use App\Models\masr\MasCenters;
use App\Models\masr\Masrofat;
use App\Models\masr\MasTypeDetails;
use App\Models\masr\MasTypes;
use Carbon\Exceptions\NotACarbonClassException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Rule;
use Livewire\Component;

class MasrInp extends Component
{
    public $MasNo;
    public $MasTypeNo;
    public $DetailNo;
    public $CenterNo;
    public $Val;
    public $MasDate;
    public $Notes;
    public $Modify_Mod=false;

    public $MasTypeGeted=false;

    public $TheMasTypeListIsSelected;
    public $TheDetailListIsSelected;
    public $TheCenterListIsSelected;

    public $IsSave=false;

    protected $listeners = [
        'TakeMasNo','refreshType','refreshDetail',
    ];
    public function refreshType(){
        $this->emitTo('masr.masr-type-select','refreshComponent');
    }
    public function CloseAddType(){$this->dispatchBrowserEvent('CloseAddType');
        $this->emitTo('masr.masr-type-select','refreshComponent');}
    public function OpenAddType(){$this->dispatchBrowserEvent('OpenAddType');}

    public function CloseAddDetail(){$this->dispatchBrowserEvent('CloseAddDetail');
        $this->emitTo('masr.masr-detail-select','refreshComponent');}
    public function OpenAddDetail(){
        $this->emitTo('masr.add-mas-detail','TakeMasTypeAdd',$this->MasTypeNo);
        $this->dispatchBrowserEvent('OpenAddDetail');}

    public function TakeMasNo($masno){
        $this->Modify_Mod=true;
        $res=Masrofat::find($masno);
        $this->MasNo=$masno;
        $this->MasTypeNo=$res->MasType;
        $this->DetailNo=$res->MasTypeDetail;
        $this->CenterNo=$res->MasCenter;
        $this->Val=$res->Val;
        $this->MasDate=$res->MasDate;
        $this->Notes=$res->Notes;
        $this->ChkMasType();
        $this->emit('gotonext','MasTypeNo');

    }
    public function updatedMarTypeNo(){
        $this->MasTypeGeted=false;
    }

    public function updatedTheMasTypeListIsSelected(){
        $this->TheMasTypeListIsSelected=0;

        $this->ChkMasType();

    }
    public function updatedTheDetailListIsSelected(){
        $this->TheDetailListIsSelected=0;
        $this->ChkDetail();
    }
    public function updatedTheCenterListIsSelected(){
        $this->TheCenterListIsSelected=0;
        $this->ChkCenter();
    }

    public function ChkMasType(){
        if ($this->MasTypeNo){
            if (MasTypes::find($this->MasTypeNo)){
                $this->emitTo('masr.masr-type-select','TakeMasTypeNo',$this->MasTypeNo);
                $this->emitTo('masr.masr-detail-select','TakeMasType',$this->MasTypeNo);
                $this->emit('gotonext','DetailNo');
                $this->MasTypeGeted=true;
                $this->IsSave=false;
            } else $this->dispatchBrowserEvent('mmsg', 'هذا الرقم غير مخزون');
        }
     }
    public function ChkCenter(){
        if ($this->CenterNo){
            if (MasCenters::find($this->CenterNo)){
                $this->emitTo('masr.masr-center-select','TakeCenterNo',$this->CenterNo);

                $this->emit('gotonext','Val');
                $this->IsSave=false;
            } else $this->dispatchBrowserEvent('mmsg', 'هذا الرقم غير مخزون');
        }

    }
    public function ChkDetail(){
        if ($this->DetailNo){
            if (MasTypeDetails::where('MasType',$this->MasTypeNo)->find($this->DetailNo)){

                $this->emitTo('masr.masr-detail-select','TakeDetailNo',$this->DetailNo);

                $this->emit('gotonext','CenterNo');
              $this->IsSave=false;

            } else $this->dispatchBrowserEvent('mmsg', 'هذا الرقم غير مخزون');
        }

    }
    public function mount(){
      $this->MasDate=date('Y-m-d');
      $this->IsSave=false;
    }
    protected function rules()
    {
        Config::set('database.connections.other.database', Auth::user()->company);
        return [
            'MasTypeNo' => ['required','integer','gt:0','exists:other.MasTypes,MasTypeNo'],
            'DetailNo' => ['required','integer','gt:0',
                Rule::exists('other.MasTypeDetails')->where(function ($query) {
                $query->where('MasType', $this->MasTypeNo);
            }),],
            'CenterNo' => ['required','integer','gt:0','exists:other.MasCenters,CenterNo'],
            'Val' => ['required','numeric','gt:0',],
            'MasDate' =>['required','date'],

        ];
    }

    protected $messages = [
        'required' => 'لا يجوز ترك فراغ',
        'exists' => 'هذا الرقم غير مخزون',
        'MasDate.required'=>'يجب ادخال تاريخ صحيح',
    ];

    public function Save(){
      if ($this->IsSave) return;
        $this->validate();
        if (!$this->Modify_Mod)
            Masrofat::insert([
                    'MasType'=>$this->MasTypeNo,
                    'MasTypeDetail'=>$this->DetailNo,
                    'MasCenter'=>$this->CenterNo,
                    'Val'=>$this->Val,
                    'MasDate'=>$this->MasDate,
                    'Notes'=>$this->Notes,
                    'emp'=>Auth()->user()->empno,
            ]);
        else
            Masrofat::where('MasNo',$this->MasNo)->update([
                'MasType'=>$this->MasTypeNo,
                'MasTypeDetail'=>$this->DetailNo,
                'MasCenter'=>$this->CenterNo,
                'Val'=>$this->Val,
                'MasDate'=>$this->MasDate,
                'Notes'=>$this->Notes,
                'emp'=>Auth()->user()->empno,
            ]);
        $this->IsSave=true;
        $this->Modify_Mod=false;
        $this->Val='';
        $this->Notes='';
        $this->DetailNo='';
        $this->emitTo('masr.masr-table','TakeDate',$this->MasDate);
        $this->emit('gotonext','MasTypeNo');
    }
    public function render()
    {
        return view('livewire.masr.masr-inp');
    }
}
