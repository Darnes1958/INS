<?php

namespace App\Http\Livewire\Amma;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Klasa extends Component
{
  public $date1;
  public $date2;
  public $klasa_date1;
  public $klasa_date2;


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
    $this->klasa_date1 = $this->date1;
    $this->klasa_date2 = $this->date2;
  }
    public function render()
    {

        return view('livewire.amma.klasa',[
          'BuyTable'=>DB::connection(Auth()->user()->company)->table('buys')
            ->join('price_type','buys.price_type','=','price_type.type_no')
            ->join('stores_names','buys.place_no','=','stores_names.st_no')
            ->whereBetween('order_date',[$this->klasa_date1,$this->klasa_date2])
            ->selectRaw('stores_names.st_no place_no,st_name as place_name,type_no,type_name,
                                 sum(tot1) as tot1,sum(ksm) as ksm,sum(tot) as tot,sum(cash) as cash,sum(not_cash) as not_cash')
            ->groupBy('stores_names.st_no','st_name','type_no','type_name')
            ->orderBy('st_no')->get(),
          'SellTableMak'=>DB::connection(Auth()->user()->company)->table('sells')
            ->join('price_type','sells.price_type','=','price_type.type_no')
            ->join('stores_names','sells.place_no','=','stores_names.st_no')
            ->where('sell_type',1)
            ->whereBetween('order_date',[$this->klasa_date1,$this->klasa_date2])
            ->selectRaw('stores_names.st_no place_no,st_name as place_name,type_no,type_name,
                                 sum(tot1) as tot1,sum(ksm) as ksm,sum(tot) as tot,sum(cash) as cash,sum(not_cash) as not_cash')
            ->groupBy('stores_names.st_no','st_name','type_no','type_name')
            ->orderBy('st_no')->get(),
          'SellTableSalat'=>DB::connection(Auth()->user()->company)->table('sells')
          ->join('price_type','sells.price_type','=','price_type.type_no')
          ->join('halls_names','sells.place_no','=','halls_names.hall_no')
          ->where('sell_type',2)
          ->whereBetween('order_date',[$this->klasa_date1,$this->klasa_date2])
          ->selectRaw('halls_names.hall_no place_no,hall_name as place_name,type_no,type_name,
                                     sum(tot1) as tot1,sum(ksm) as ksm,sum(tot) as tot,sum(cash) as cash,sum(not_cash) as not_cash')
          ->groupBy('halls_names.hall_no','hall_name','type_no','type_name')
            ->orderBy('hall_no')->get(),
          'TransTableImp'=>DB::connection(Auth()->user()->company)->table('trans')
          ->join('price_type','trans.tran_type','=','price_type.type_no')
          ->join('tran_who','trans.tran_who','=','tran_who.who_no')
          ->where('imp_exp',1)
          ->whereBetween('tran_date',[$this->klasa_date1,$this->klasa_date2])
          ->selectRaw('imp_exp,who_no,who_name,type_no,type_name,sum(val) as val')
          ->groupBy('imp_exp','who_no','who_name','type_no','type_name')->orderBy('who_no')->get(),
          'TransTableExp'=>DB::connection(Auth()->user()->company)->table('trans')
            ->join('price_type','trans.tran_type','=','price_type.type_no')
            ->join('tran_who','trans.tran_who','=','tran_who.who_no')
            ->where('imp_exp',2)
            ->whereBetween('tran_date',[$this->klasa_date1,$this->klasa_date2])
            ->selectRaw('imp_exp,who_no,who_name,type_no,type_name,sum(val) as val')
            ->groupBy('imp_exp','who_no','who_name','type_no','type_name')->orderBy('who_no')->get()]);

    }
}
