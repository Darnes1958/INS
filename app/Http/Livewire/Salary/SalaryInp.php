<?php

namespace App\Http\Livewire\Salary;

use App\Models\masr\MasCenters;
use App\Models\masr\Masrofat;
use App\Models\masr\MasTypeDetails;
use App\Models\masr\MasTypes;
use App\Models\Operations;
use App\Models\Salary\Salarys;
use Carbon\Carbon;
use Carbon\Exceptions\NotACarbonClassException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Rule;
use Livewire\Component;

class SalaryInp extends Component
{

    public $Name;

    public $CenterNo;
    public $Sal;
    public $SalaryId;
    public $Modify_Mod=false;


    public $TheCenterListIsSelected;

    public $IsSave=false;

    protected $listeners = [
        'TakeSalNo','refreshType','refreshDetail',
    ];

    public function TakeSalNo($salaryid){
        $this->SalaryId=$salaryid;
        $this->Modify_Mod=true;
        $res=Salarys::find($salaryid);
        $this->MasNo=$salaryid;
        $this->CenterNo=$res->MasCenter;
        $this->Sal=$res->Sal;
        $this->Name=$res->Name;
        $this->emit('gotonext','Name');

    }


    public function updatedTheCenterListIsSelected(){
        $this->TheCenterListIsSelected=0;
        $this->ChkCenter();
    }


    public function ChkCenter(){
        if ($this->CenterNo){
            if (MasCenters::find($this->CenterNo)){
                $this->emitTo('masr.masr-center-select','TakeCenterNo',$this->CenterNo);
                $this->emit('gotonext','Sal');
                $this->IsSave=false;
            } else $this->dispatchBrowserEvent('mmsg', 'هذا الرقم غير مخزون');
        }

    }

    public function mount(){

      $this->IsSave=false;
    }
    protected function rules()
    {
        Config::set('database.connections.other.database', Auth::user()->company);
        return [

            'CenterNo' => ['required','integer','gt:0','exists:other.MasCenters,CenterNo'],
            'Sal' => ['required','numeric','gt:0',],
            'Name' =>['required',],

        ];
    }

    protected $messages = [
        'required' => 'لا يجوز ترك فراغ',
        'exists' => 'هذا الرقم غير مخزون',

    ];

    public function Save(){
      $created_at = Carbon::now();
      if ($this->IsSave) return;
        $this->validate();
        if (!$this->Modify_Mod)
            Salarys::insert([
                    'MasCenter'=>$this->CenterNo,
                    'Sal'=>$this->Sal,
                    'Name'=>$this->Name,
                    'created_at'=>$created_at,
            ]);
        else {
          Salarys::where('id', $this->SalaryId)->update([
            'MasCenter' => $this->CenterNo,
            'Sal' => $this->Sal,
            'Name' => $this->Name,
          ]);
          Operations::insert(['Proce'=>'مرتبات','Oper'=>'نعديل','no'=>$this->SalaryId,'created_at'=>Carbon::now(),'emp'=>auth::user()->empno,]);
        }
        $this->IsSave=true;
        $this->Modify_Mod=false;
        $this->Sal='';
        $this->Name='';
        $this->CenterNo='';
        $this->emitTo('salary.salary-table','refreshComponent');
        $this->emit('gotonext','Name');
    }
    public function render()
    {
        return view('livewire.salary.salary-inp');
    }
}
