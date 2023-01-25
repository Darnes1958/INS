<?php

namespace App\Http\Livewire\Aksat\Rep\Okod;


use App\Models\bank\bank;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Stop extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';

  public $bank_no=0;
  public $bank_name;
  public $search;
  public $date1,$date2,$stop_date1,$stop_date2;
  protected $listeners = [
    'TakeBank',
  ];

  public function TakeBank($bank_no){
    $this->bank_no=$bank_no;
    $this->bank_name=bank::on(Auth()->user()->company)->where('bank_no',$this->bank_no)->first()->bank_name;


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
    $this->stop_date1 = $this->date1;
    $this->stop_date2 = $this->date2;

  }
  public function Date1Chk()
  {
    $this->validate();
    $this->stop_date1 = $this->date1;
    $this->stop_date2 = $this->date2;

  }
    public function render()
    {

        return view('livewire.aksat.rep.okod.stop',[
          'RepTable'=>DB::connection(Auth()->user()->company)->table('stop_view')
            ->whereBetween('stop_date',[$this->stop_date1,$this->stop_date2])
            ->where('bank', '=', $this->bank_no)
            ->where('name', 'like', '%'.$this->search.'%')
            ->paginate(15)
        ]);
    }
}
