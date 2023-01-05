<?php

namespace App\Http\Livewire\Trans;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class RepTrans extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';
  public $date1;
  public $date2;
  public $tran_date1;
  public $tran_date2;
  public $RepRadio=0;
  public $Supp_Only=false;
  public $search;

  protected function rules()
  {

    return [
      'date1' => ['required','date'],
      'date2' => ['required','date'],
    ];
  }

  protected $messages = [
    'required' => 'لا يجوز',

    'required.date1' => 'يجب ادخال تاريخ صحيح',
    'required.date2' => 'يجب ادخال تاريخ صحيح',

  ];
  public function Date2Chk(){
    $this->validate();
    $this->tran_date1=$this->date1;
    $this->tran_date2=$this->date2;
  }
  public function render()
    {
     if ($this->RepRadio==0)
        return view('livewire.trans.rep-trans',[
          'RepTable'=>DB::connection(Auth()->user()->company)->table('tran_view')
            ->whereBetween('tran_date',[$this->tran_date1,$this->tran_date2])
            ->where(function ($query) {
              $query->where('jeha_name', 'like', '%' . $this->search . '%')
                ->orWhere('tran_date', 'like', '%'.$this->search.'%')
                ->orWhere('val', 'like', '%'.$this->search.'%');})
            ->when($this->Supp_Only,function ($q) {
             return $q->where('jeha_type','=', 2);})
            ->paginate(15)

        ]);
     else         return view('livewire.trans.rep-trans',[
       'RepTable'=>DB::connection(Auth()->user()->company)->table('tran_view')
         ->whereBetween('tran_date',[$this->tran_date1,$this->tran_date2])
         ->where('imp_exp',$this->RepRadio)
         ->where(function ($query) {
           $query->where('jeha_name', 'like', '%' . $this->search . '%')
             ->orWhere('tran_date', 'like', '%'.$this->search.'%')
             ->orWhere('val', 'like', '%'.$this->search.'%');})
         ->when($this->Supp_Only,function ($q) {
           return $q->where('jeha_type','=', 2);})
         ->paginate(15)
     ]);

    }
}
