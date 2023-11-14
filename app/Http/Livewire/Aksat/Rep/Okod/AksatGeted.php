<?php

namespace App\Http\Livewire\Aksat\Rep\Okod;


use App\Models\bank\bank;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AksatGeted extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';
  public $bank_no=0;
  public $bank_name;
  public $search;
  public $date1,$date2,$rep_date1,$rep_date2;
  public $RepRadio='Geted';
  public $baky=0;


  public $orderColumn = "no";
  public $sortOrder = "asc";
  public $sortLink = '<i class="sorticon fas fa-angle-up"></i>';
  protected $listeners = [
    'TakeBank',
  ];



  public function sortOrder($columnName=""){
    $caretOrder = "up";
    if($this->sortOrder == 'asc'){
      $this->sortOrder = 'desc';
      $caretOrder = "down";
    }else{
      $this->sortOrder = 'asc';
      $caretOrder = "up";
    }
    $this->sortLink = '<i class="sorticon fas fa-angle-'.$caretOrder.'"></i>';

    $this->orderColumn = $columnName;

  }

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
    $this->rep_date1 = $this->date1;
    $this->rep_date2 = $this->date2;
  }
  public function Date1Chk()
  {
    $this->validate();
    $this->rep_date1 = $this->date1;
    $this->rep_date2 = $this->date2;
  }
    public function render()
    {
      return view('livewire.aksat.rep.okod.aksat-geted',[
        'GetedTable'=>DB::connection(Auth()->user()->company)->table('main')
          ->join('kst_trans','main.no','=','kst_trans.no')
          ->selectRaw('main.*,kst_trans.ksm,Kst_trans.ksm_date')
          ->whereBetween('kst_trans.ksm_date',[$this->rep_date1,$this->rep_date2])
          ->where('ksm','!=',0)
          ->where('main.bank', '=', $this->bank_no)
          ->orderby($this->orderColumn,$this->sortOrder)
          ->paginate(15),
        'NotGetedTable'=>DB::connection(Auth()->user()->company)->table('main')
          ->join('kst_trans','main.no','=','kst_trans.no')
          ->selectRaw('main.no,name,sul_date,acc,sul,sul_pay,raseed,kst_count,main.kst,max(ksm_date) as ksm_date')
          ->whereNotIn('main.no',function($query){
                $query->select('no')->from('kst_trans')
                    ->where('main.bank', '=', $this->bank_no)
                    ->where('ksm','!=',0)
                    ->whereBetween('kst_trans.ksm_date',[$this->rep_date1,$this->rep_date2]);
            })
          ->when($this->baky,function($q){
              $q->where('raseed','>',$this->baky);
          })

          ->where('main.bank', '=', $this->bank_no)
          ->groupBy('main.no','name','sul_date','acc','sul','sul_pay','raseed','kst_count','main.kst')
          ->orderby($this->orderColumn,$this->sortOrder)
          ->paginate(15),
      ]);
    }
}
