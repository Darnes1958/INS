<?php

namespace App\Http\Livewire\Stores;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class RepStoresTrans extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';
  public $Report='imp';
  public $per_date;
  public $perdate;

  public function mount()
  {
    $this->per_date=date('Y-m-d');
    $this->perdate=date('Y-m-d');
  }

  public function ChkDate(){
    $this->validate();
    $this->perdate=$this->per_date;
  }
  protected function rules()
  {
    return [
      'per_date' => ['required','date'],
    ];
  }
  protected $messages = [
    'required' => 'لا يجوز ترك فراغ',
    'tran_date.required'=>'يجب ادخال تاريخ صحيح',
  ];
    public function render()
    {

      return view('livewire.stores.rep-stores-trans',[
        'ImpTable'=>DB::connection(Auth()->user()->company)->table('store_imp_view')
          ->where('imp_date',$this->perdate)->paginate(15),
        'ExpTable'=>DB::connection(Auth()->user()->company)->table('store_exp_view')
          ->where('exp_date',$this->perdate)->paginate(15),
        'ImpTotTable'=>DB::connection(Auth()->user()->company)->table('store_imp_view')
          ->selectRaw('sum(quant) as quant , st_name,item_no,item_name')
          ->groupBy('st_name','item_no','item_name')
          ->where('imp_date',$this->perdate)->paginate(15),
        'ExpTotTable'=>DB::connection(Auth()->user()->company)->table('store_exp_view')
          ->selectRaw('st_name,item_no,item_name,sum(quant) as quant')
          ->groupBy('st_name','item_no','item_name')
          ->where('exp_date',$this->perdate)->paginate(15),

      ]);

    }
}
