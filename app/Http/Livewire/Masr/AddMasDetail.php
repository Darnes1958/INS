<?php

namespace App\Http\Livewire\Masr;


use App\Models\masr\Masrofat;
use App\Models\masr\MasTypeDetails;
use App\Models\masr\MasTypes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AddMasDetail extends Component
{
    use WithPagination;
    public $DetailNameAdd;
    public $DetailNoAdd;
    public $Modify_ModAdd=false;
    public $MasTypeAdd=0;

    protected $listeners = [
       'DoDeleteDetail','TakeMasTypeAdd'
    ];

    public function TakeMasTypeAdd($TakeMasTypeAdd){
        $this->MasTypeAdd=$TakeMasTypeAdd;
    }
    protected function rules()
    {

        return [
            'DetailNameAdd' => ['required'],
        ];
    }

    protected $messages = [
        'required' => 'يجب ملء البيان',
    ];

    public function selectItem($DetailNo,$action){
        $this->DetailNoAdd=$DetailNo;

        if ($action=='delete') {
            if (Masrofat::on(Auth()->user()->company)->where('MasType',$DetailNo)->first()){
                $this->dispatchBrowserEvent('mmsg', 'هذا النوع مستخدم مسبقا ولا يمكن الغاءه');
            } else { $this->dispatchBrowserEvent('deldetail');}
        }
        if ($action=='update') {
            $this->Modify_ModAdd=True;
            $this->DetailNameAdd=MasTypeDetails::on(Auth()->user()->company)->find($DetailNo)->DetailName;
            $this->emit('gotonext','DetailNameAdd');}
    }
    public function DoDeleteDetail(){

        MasTypeDetails::on(Auth()->user()->company)->find($this->DetailNoAdd)->delete();
    }
    public function SaveOne(){
        $this->validate();

        $no=MasTypeDetails::on(Auth()->user()->company)->max('DetailNo')+1;
        if ( ! $this->Modify_ModAdd)
            DB::connection(Auth()->user()->company)->table('MasTypeDetails')->insert([
                'DetailNo' => $no,
                'DetailName' => $this->DetailNameAdd,
                'MasType'=>$this->MasTypeAdd,
            ]);
        else
            DB::connection(Auth()->user()->company)->table('MasTypeDetails')
                ->where('DetailNo',$this->DetailNoAdd)->update([

                'DetailName' => $this->DetailNameAdd,
            ]);
        $this->Modify_ModAdd=false;
        $this->DetailNameAdd='';


        session()->flash('message', 'تم تخزين البيانات');

    }
    public function mount(){
        $this->DetailNameAdd='';

    }
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        return view('livewire.masr.add-mas-detail',[
            'itemtypes' =>MasTypeDetails::on(Auth()->user()->company)
                ->where('MasType',$this->MasTypeAdd)->paginate(10),
        ]);
    }
}
