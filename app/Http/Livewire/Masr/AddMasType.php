<?php

namespace App\Http\Livewire\Masr;


use App\Models\masr\Masrofat;
use App\Models\masr\MasTypes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AddMasType extends Component
{
    use WithPagination;
    public $MasTypeNameAdd;
    public $MasTypeNoAdd;
    public $Modify_ModAdd=false;

    protected $listeners = [
       'DoDelete',
    ];

    protected function rules()
    {

        return [
            'MasTypeNameAdd' => ['required'],
        ];
    }

    protected $messages = [
        'required' => 'يجب ملء البيان',
    ];

    public function selectItem($MasTypeNo,$action){
        $this->MasTypeNoAdd=$MasTypeNo;

        if ($action=='delete') {
            if (Masrofat::on(Auth()->user()->company)->where('MasType',$MasTypeNo)->first()){
                $this->dispatchBrowserEvent('mmsg', 'هذا النوع مستخدم مسبقا ولا يمكن الغاءه');
            } else { $this->dispatchBrowserEvent('delone');}
        }
        if ($action=='update') {
            $this->Modify_ModAdd=True;
            $this->MasTypeNameAdd=MasTypes::on(Auth()->user()->company)->find($MasTypeNo)->MasTypeName;
            $this->emit('gotonext','MasTypeName');}
    }
    public function DoDelete(){

        MasTypes::on(Auth()->user()->company)->find($this->MasTypeNoAdd)->delete();
    }
    public function SaveOne(){
        $this->validate();

        $no=MasTypes::on(Auth()->user()->company)->max('MasTypeNo')+1;
        if ( ! $this->Modify_ModAdd)
            DB::connection(Auth()->user()->company)->table('MasTypes')->insert([
                'MasTypeNo' => $no,
                'MasTypeName' => $this->MasTypeNameAdd,
            ]);
        else
            DB::connection(Auth()->user()->company)->table('MasTypes')
                ->where('MasTypeNo',$this->MasTypeNoAdd)->update([

                'MasTypeName' => $this->MasTypeNameAdd,
            ]);
        $this->Modify_ModAdd=false;
        $this->MasTypeNameAdd='';


        session()->flash('message', 'تم تخزين البيانات');

    }
    public function mount(){
        $this->MasTypeNameAdd='';

    }
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        return view('livewire.masr.add-mas-type',[
            'itemtypes' =>MasTypes::on(Auth()->user()->company)->paginate(10),
        ]);
    }
}
