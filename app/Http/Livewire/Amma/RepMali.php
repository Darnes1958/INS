<?php

namespace App\Http\Livewire\Amma;

use App\Models\aksat\kst_trans;
use App\Models\aksat\main;
use App\Models\buy\buys;
use App\Models\masr\Masrofat;
use App\Models\OverTar\over_kst;
use App\Models\OverTar\tar_kst;
use App\Models\OverTar\wrong_Kst;
use App\Models\sell\sells;
use App\Models\trans\trans;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RepMali extends Component
{
  public $buys=0;
  public $sells=0;
  public $sellnakdy=0;
  public $selltak=0;
  public $sellcash=0;
  public $sellnotcash=0;
  public $trans;
  public $transimp=0;
  public $transexp=0;
  public $transtak=0;
  public $okod=0;
  public $aksat=0;
  public $over=0;
  public $tar=0;
  public $wrong=0;
  public $wrongtar=0;
  public $masrofat=0;
  public $rebh=0;

  public $date1;
  public $date2;

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
    $this->mas_date1 = $this->date1;
    $this->mas_date2 = $this->date2;
    $this->buys=buys::on(Auth()->user()->company)->whereBetween('order_date',[$this->mas_date1,$this->mas_date2])->sum('tot');

    $this->sells=sells::on(Auth()->user()->company)->whereBetween('order_date',[$this->mas_date1,$this->mas_date2])->sum('tot');
    $this->sellnakdy=sells::on(Auth()->user()->company)->where('price_type','!=',2)->whereBetween('order_date',[$this->mas_date1,$this->mas_date2])->sum('tot');
    $this->selltak=sells::on(Auth()->user()->company)->where('price_type',2)->whereBetween('order_date',[$this->mas_date1,$this->mas_date2])->sum('tot');
    $this->sellcash=sells::on(Auth()->user()->company)->whereBetween('order_date',[$this->mas_date1,$this->mas_date2])->sum('cash');
    $this->sellnotcash=sells::on(Auth()->user()->company)->whereBetween('order_date',[$this->mas_date1,$this->mas_date2])->sum('not_cash');

    $this->okod=main::on(Auth()->user()->company)->whereBetween('sul_date',[$this->mas_date1,$this->mas_date2])->sum('sul');
    $this->aksat=kst_trans::on(Auth()->user()->company)->where('ksm','!=',null)
      ->where('ksm','!=',0)->whereBetween('ksm_date',[$this->mas_date1,$this->mas_date2])->sum('ksm');

    $this->transexp=trans::on(Auth()->user()->company)->where('imp_exp',2)->whereBetween('tran_date',[$this->mas_date1,$this->mas_date2])->sum('val');
    $this->transimp=trans::on(Auth()->user()->company)->where('imp_exp',1)->whereBetween('tran_date',[$this->mas_date1,$this->mas_date2])->sum('val');
    $this->trans=$this->transimp+$this->aksat-$this->transexp;

    $mainno=DB::connection(Auth()->user()->company)->table('main')->select('no');
    $this->over=over_kst::on(Auth()->user()->company)->whereIn('no',$mainno)->whereBetween('tar_date',[$this->mas_date1,$this->mas_date2])->sum('kst');

    $this->tar=tar_kst::on(Auth()->user()->company)->where('no','!=',0)->whereBetween('tar_date',[$this->mas_date1,$this->mas_date2])->sum('kst');

    $this->wrong=wrong_Kst::on(Auth()->user()->company)->whereBetween('tar_date',[$this->mas_date1,$this->mas_date2])->sum('kst');
    $this->wrongtar=tar_kst::on(Auth()->user()->company)->where('no',0)->whereBetween('tar_date',[$this->mas_date1,$this->mas_date2])->sum('kst');

    $this->masrofat=Masrofat::on(Auth()->user()->company)->whereBetween('MasDate',[$this->mas_date1,$this->mas_date2])->sum('Val');
    $this->rebh=sells::on(Auth()->user()->company)->whereBetween('order_date',[$this->mas_date1,$this->mas_date2])->sum('rebh');

  }
  public function paginate($items, $perPage = 15, $page = null, $options = [])
  {
    $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
    $items = $items instanceof Collection ? $items : Collection::make($items);
    return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
  }
    public function render()
    {
      $page = 1;
      $paginate = 15;
      $collection = collect(DB::connection(Auth()->user()->company)->
      select('Select * from dbo.frep_mali (?,?) as result  '
        ,array($this->date1,$this->date2)));
      $RepTable= $this->paginate($collection);

        return view('livewire.amma.rep-mali',['RepTable'=> $RepTable]);
    }
}
