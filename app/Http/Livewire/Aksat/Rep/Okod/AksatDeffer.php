<?php

namespace App\Http\Livewire\Aksat\Rep\Okod;

use App\Models\bank\bank;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AksatDeffer extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';
  public $ByTajmeehy='Bank';
  public $bank_no=0;
  public $bank_name;
  public $TajNo=0;
  public $TajName;

  public $search;
  public $deffer=5;
  public $date1,$date2,$wrong_date1,$wrong_date2;
  protected $listeners = [
    'TakeBank','TakeTajNo',
  ];

  public function TakeBank($bank_no){

    $this->bank_no=$bank_no;
    $this->bank_name=bank::on(Auth()->user()->company)->where('bank_no',$this->bank_no)->first()->bank_name;

  }
  public function TakeTajNo($tajno){

    $this->TajNo=$tajno;

  }
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
  public function updatedDate2(){
    if ($this->isDate($this->date1 ) && $this->isDate($this->date2 )) {
      $this->Date2Chk();
    }
  }
  public function updatedDate1(){
    if ($this->isDate($this->date1 ) && $this->isDate($this->date2 )) {
      $this->Date2Chk();
    }
  }
  function isDate($value) {
    if (!$value) {
      return false;
    } else {
      $date = date_parse($value);
      if($date['error_count'] == 0 && $date['warning_count'] == 0){
        return checkdate($date['month'], $date['day'], $date['year']);
      } else {
        return false;
      }
    }
  }
  public function Date2Chk()
  {
    $this->validate();
    $this->wrong_date1 = $this->date1;
    $this->wrong_date2 = $this->date2;
  }
  public function Date1Chk()
  {
    $this->validate();
    $this->wrong_date1 = $this->date1;
    $this->wrong_date2 = $this->date2;
  }
  public function render()
  {
    return view('livewire.aksat.rep.okod.aksat-deffer',[
      'RepTable'=>DB::connection(Auth()->user()->company)->table('kst_deffer_view')
        ->when($this->ByTajmeehy=='Bank',function ($q){
          $q->where('bank', '=', $this->bank_no);
        })
        ->when($this->ByTajmeehy=='Taj',function ($qq){
         $qq->whereIn('bank', function($q){
            $q->select('bank_no')->from('bank')->where('bank_tajmeeh',$this->TajNo);});
        })

        ->where('deffer', '>', $this->deffer)
        ->where('name', 'like', '%'.$this->search.'%')
        ->orderBy('no')
        ->orderBy('ksm_date')
        ->paginate(15)
    ]);
  }
}
