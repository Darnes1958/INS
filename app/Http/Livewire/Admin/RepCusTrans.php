<?php

namespace App\Http\Livewire\Admin;

use App\Models\Customers;
use App\Models\CusTrans;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class RepCusTrans extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $CusNo;
    public $search;
    public $TransDate;
    public $date1,$date2;
    public $ValType;
    public $RepRadio=0;
    public $RepRadio2=1;
    public function selectItem($cusno,$valtype){
        $this->CusNo=$cusno;
        $this->ValType=$valtype;
    }
    public function mount(){
        $this->TransDate=Carbon::now()->firstOfYear()->format('Y-m-d');
        $this->date1=Carbon::now()->firstOfYear()->format('Y-m-d');
        $this->date2=Carbon::now()->endOfYear()->format('Y-m-d');
    }
    public function render()
    {
        return view('livewire.admin.rep-cus-trans',[
            'RepCusSum'=>DB::table('Customers')
                ->join('CusTrans', 'Customers.id', '=', 'CusTrans.CusNo')
                ->join('CusValType', 'CusTrans.ValType', '=', 'CusValType.ValTypeNo')
                ->whereBetween('TransDate',[$this->date1,$this->date2])
                ->when($this->RepRadio!=0,function($q){
                    return $q->where('ValType',$this->RepRadio);
                })
                ->selectRaw('Company,CompanyName,CusTrans.CusNo,
                SUM(ValNext) AS ValNext, SUM(Val) AS Val, ValType,ValTypeName
')
                ->groupby('Company','CompanyName','CusNo','ValType','ValTypeName')
                ->paginate(15,['*'],'RepSum'),
            'RepCusTrans'=>CusTrans::where('CusNo',$this->CusNo)->
                when($this->RepRadio2==1,function($q){
                    return $q->where('ValType',$this->ValType);
            })->paginate(15),
        ]);
    }
}
