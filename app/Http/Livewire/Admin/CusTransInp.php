<?php

namespace App\Http\Livewire\Admin;

use App\Models\Customers;
use App\Models\CusTrans;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class CusTransInp extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

   public $CusNo;
   public $TranId;
   public $CompanyName;
   public $Val;
   Public $TransDate;
   public $DateNext;
   public $ValNext;
   public $Notes;
   public $ValType=1;

    public $UpdateMod=false;
    public $search;
    public $TheCusIsSelectd;

    protected $listeners = [

    ];
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedTheCusIsSelectd(){
        $this->TheCusIsSelectd=0;
        $this->CompanyName=Customers::find($this->CusNo)->CompanyName;
        $this->emit('gotonext','TransDate');

    }
    protected function rules()
    {

        return [
            'CusNo' => ['required','integer','gt:0','exists:Customers,id'],
            'TransDate' => ['required','date'],
            'DateNext' => ['required','date'],
            'Val' =>['required','integer','gt:0'],
            'ValNext' =>['required','integer','gte:0'],

        ];
    }
    protected $messages = [
        'CusNo.required' => 'يجب اختيار الشركة',
        'required' => 'لا يجوز ترك فراغ',
        'ValDate.required'=>'يجب ادخال تاريخ صحيح',
        'DateNext.required'=>'يجب ادخال تاريخ صحيح',
    ];
    public function ClearData(){


        $this->Val=0;
        $this->ValNext=0;
        $this->Notes='';
        $this->UpdateMod=false;

    }
    public function Save(){
     $this->validate();
     if (!$this->UpdateMod) {
         CusTrans::where('CusNo', $this->CusNo)->where('ValType',$this->ValType)->update(['last' => 0]);
         CusTrans::insert(['CusNo' => $this->CusNo, 'ValType' => $this->ValType, 'Val' => $this->Val,
             'TransDate' => $this->TransDate, 'DateNext' => $this->DateNext, 'ValNext' => $this->ValNext,
             'Notes' => $this->Notes]);
     }
     else
     {

         CusTrans::where('id',$this->TranId)->Update([ 'ValType' => $this->ValType, 'Val' => $this->Val,
             'TransDate' => $this->TransDate, 'DateNext' => $this->DateNext, 'ValNext' => $this->ValNext,
             'Notes' => $this->Notes]);
     }
     $this->ClearData();
     $this->emit('gotonext','Val');

    }
    public function CloseDeleteDialog(){$this->dispatchBrowserEvent('CloseMyDelete');}
    public function delete(){
        $this->CloseDeleteDialog();
        $res=CusTrans::where('id',$this->TranId)->first();
        $ValType=$res->ValType;
        $max=0;
     

        CusTrans::where('id',$this->TranId)->delete();

      if ($res->Last==1)
        $max = CusTrans::where('CusNo', $res->CusNo)->where('ValType', $ValType)->max('id');

        CusTrans::where('id', $max)->update(['Last' => 1]);


        $this->render();
    }

    public function selectItem($id,$action){
        $this->TranId=$id;
        if ($action=='delete') {$this->UpdateMod=false; $this->dispatchBrowserEvent('OpenMyDelete');}
        if ($action=='update') {

            $res=CusTrans::where('id',$id)->first();

            $this->Val=$res->Val;
            $this->TransDate=$res->TransDate;
            $this->DateNext=$res->DateNext;
            $this->ValNext=$res->ValNext;
            $this->ValType=$res->ValType;
            $this->Notes=$res->Notes;
            $this->UpdateMod=true;}

        $this->emit('gotonext','Val');

    }

    public function mount(){
        $this->UpdateMod=false;
        $this->TransDate=Carbon::now()->firstOfMonth()->format('Y-m-d');

        $DateNext=Carbon::now()->addMonth()->firstOfMonth();

        $this->DateNext=$DateNext->format('Y-m-d');
    }
    public function render()
    {
        return view('livewire.admin.cus-trans-inp',[
            'CusTable'=>CusTrans::where('CusNo',$this->CusNo)
                ->where('Val', 'like', '%'.$this->search.'%')
                ->orderBy('TransDate','desc')
                ->paginate(15),
        ]);
    }
}
