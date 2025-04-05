<?php

namespace App\Http\Livewire\Aksat\Rep\Okod;


use App\Models\aksat\main;
use App\Models\bank\bank;
use App\Models\bank\BankTajmeehy;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class KstGeted extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';
    public $ByTajmeehy='Bank';
    public $TajNo=0;
  public $bank_no=0;
  public $bank_name;
  public $search;
  public $date1,$date2,$rep_date1,$rep_date2;
  protected $listeners = [
      'TakeBank','TakeTajNo'

  ];

  public function TakeBank($bank_no){
    $this->bank_no=$bank_no;
    $this->bank_name=bank::on(Auth()->user()->company)->where('bank_no',$this->bank_no)->first()->bank_name;
      $this->resetPage();

  }
    public function TakeTajNo($tajno){

        $this->TajNo=$tajno;
        $this->bank_name=BankTajmeehy::find($this->TajNo)->TajName;

        $this->resetPage();

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
      return view('livewire.aksat.rep.okod.kst-geted',[
        'OkodTable'=>DB::connection(Auth()->user()->company)->table('main')
          ->join('sells','main.order_no','=','sells.order_no')
          ->join('place_view', function ($join) {
            $join->on('sells.place_no', '=', 'place_view.place_no')
              ->on('sells.sell_type', '=', 'place_view.place_type');
          })
          ->selectRaw('place_view.place_name,sum(main.sul_tot) sul_tot')
          ->groupBy('place_view.place_name')
          ->whereBetween('main.sul_date',[$this->rep_date1,$this->rep_date2])
            ->when($this->ByTajmeehy=='Bank',function($q){
                $q->where('main.bank', '=', $this->bank_no);
            })
            ->when($this->ByTajmeehy=='Taj',function($q){
                $q-> whereIn('main.bank', function($q){
                    $q->select('bank_no')->from('bank')->where('bank_tajmeeh',$this->TajNo);});
            })
          ->paginate(15),

        'AksatTable'=>DB::connection(Auth()->user()->company)->table('main')
          ->join('kst_trans','main.no','=','kst_trans.no')
          ->join('sells','main.order_no','=','sells.order_no')
          ->join('place_view', function ($join) {
            $join->on('sells.place_no', '=', 'place_view.place_no')
              ->on('sells.sell_type', '=', 'place_view.place_type');
          })
          ->selectRaw('place_view.place_name,sum(kst_trans.ksm) ksm')
          ->groupBy('place_view.place_name')
          ->whereBetween('kst_trans.ksm_date',[$this->rep_date1,$this->rep_date2])
          ->when($this->ByTajmeehy=='Bank',function($q){
                $q->where('main.bank', '=', $this->bank_no);
            })
            ->when($this->ByTajmeehy=='Taj',function($q){
                $q-> whereIn('main.bank', function($q){
                    $q->select('bank_no')->from('bank')->where('bank_tajmeeh',$this->TajNo);});
            })
          ->paginate(15),
        'SumAksat'=>DB::connection(Auth()->user()->company)->table('main')
          ->join('kst_trans','main.no','=','kst_trans.no')
          ->whereBetween('kst_trans.ksm_date',[$this->rep_date1,$this->rep_date2])
            ->when($this->ByTajmeehy=='Bank',function($q){
                $q->where('main.bank', '=', $this->bank_no);
            })
            ->when($this->ByTajmeehy=='Taj',function($q){

                $q-> whereIn('main.bank', function($q){
                    $q->select('bank_no')->from('bank')->where('bank_tajmeeh',$this->TajNo);});
            })
          ->sum('ksm'),
        'SumOkod'=>DB::connection(Auth()->user()->company)->table('main')
          ->whereBetween('sul_date',[$this->rep_date1,$this->rep_date2])
            ->when($this->ByTajmeehy=='Bank',function($q){
                $q->where('main.bank', '=', $this->bank_no);
            })
            ->when($this->ByTajmeehy=='Taj',function($q){
                $q-> whereIn('main.bank', function($q){
                    $q->select('bank_no')->from('bank')->where('bank_tajmeeh',$this->TajNo);});
            })
          ->sum('sul_tot'),


      ]);

    }
}
