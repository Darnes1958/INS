<?php

namespace App\Http\Livewire\Stores;

use App\Models\stores\halls;
use App\Models\stores\store_exp;
use App\Models\stores\stores;
use App\Models\trans\trans;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use \App\Http\Livewire\Traits\MyLib;

class StoreTable extends Component
{
  use MyLib;
  public $perdetail=[];
  public $place_no1;
  public $place_no2;
  public $FromTo;
  public $Table1;
  public $HasRaseed;

  protected $listeners = [
    'putdata','TakeParams'
  ];

  public function TakeParams($place_no1,$place_no2,$fromto,$table1){
    $this->place_no1=$place_no1;
    $this->place_no2=$place_no2;
    $this->FromTo=$fromto;
    $this->Table1=$table1;

  }
  public function putdata($value)
  {
    $One= array_column($this->perdetail, 'item_no');
    $index = array_search( $value['item_no'], $One);
    if  ($index) {
      $this->perdetail[$index]['item_no']=$value['item_no'];
      $this->perdetail[$index]['item_name']=$value['item_name'];
      $this->perdetail[$index]['quant']=$value['quant'];
    }
    else {
      $this->perdetail[] =
        ['item_no' => $value['item_no'], 'item_name' => $value['item_name'],
          'quant' => $value['quant'],];
    }
  }

  public function removeitem($value)    {
    unset($this->perdetail[$value]);
    array_values($this->perdetail);
  }
  public function edititem($value)
  {
    $this->emit( 'edititem',$this->perdetail[$value]) ;
  }

  public function mount(){
    $this->perdetail=[
      ['item_no'=>'0','item_name'=>'',
        'quant'=>'0' ]
    ];
  }

  public function store(){

    if (count($this->perdetail)==1){
      session()->flash('message', 'لم يتم ادخال اصناف بعد');

    }
    else {

      Config::set('database.connections.other.database', Auth::user()->company);
      $this->HasRaseed=true;
      DB::connection(Auth()->user()->company)->beginTransaction();
      try {
        if ($this->FromTo==11 or $this->FromTo==21) {$st_no2=$this->place_no2;$hall_no=0;}
        if ($this->FromTo==12 or $this->FromTo==22) {$st_no2=0;$hall_no=$this->place_no2;}
        if ($this->FromTo==11) $per_type=1;
        if ($this->FromTo==12) $per_type=2;
        if ($this->FromTo==21) $per_type=3;
        if ($this->FromTo==22) $per_type=4;
        $per_no=store_exp::on(Auth()->user()->company)->max('per_no')+1;

        foreach ($this->perdetail as $item) {
          if ($item['item_no'] == 0) {
            continue;
          }
          if ($this->RetPlaceRaseed($item['item_no'],$this->Table1,$this->place_no1)<(int)$item['quant'])
          {$this->dispatchBrowserEvent('mmsg', 'الصنف :'.$item['item_no'].' رصيده لا يكفي');
            $this->HasRaseed=false;
            break;
          }
          DB::connection(Auth()->user()->company)->table('store_exp')->insert([
            'st_no'=>$this->place_no1,
            'per_no'=>$per_no,
            'item_no' => $item['item_no'],
            'quant' => $item['quant'],
            'exp_date'=>date('Y-m-d'),
            'order_no'=>0,
            'per_type'=>$per_type,
            'st_no2'=>$st_no2,
            'hall_no'=>$hall_no,
            'emp'=>Auth::user()->empno,
          ]);
           if ($per_type==1) {
               $from = stores::where('st_no', $this->place_no1)->where('item_no',$item['item_no'])->first();
               $to = stores::where('st_no', $st_no2)->where('item_no', $item['item_no'])->first();
               if (!$to) {stores::insert(['st_no' => $st_no2, 'item_no' => $item['item_no'],'raseed'=>0]);
                   $to = stores::where('st_no', $st_no2)->where('item_no', $item['item_no'])->first();}
           }
            if ($per_type==2) {
                $from = stores::where('st_no', $this->place_no1)->where('item_no',$item['item_no'])->first();
                $to = halls::where('hall_no', $hall_no)->where('item_no', $item['item_no'])->first();
                if (!$to) {halls::insert(['hall_no' => $hall_no, 'item_no' => $item['item_no'],'raseed'=>0]);
                    $to = halls::where('hall_no', $hall_no)->where('item_no', $item['item_no'])->first();}
            }
            if ($per_type==3) {
                $from = halls::where('hall_no', $this->place_no1)->where('item_no',$item['item_no'])->first();
                $to = stores::where('st_no', $st_no2)->where('item_no', $item['item_no'])->first();
                if (!$to) {stores::insert(['st_no' => $st_no2, 'item_no' => $item['item_no'],'raseed'=>0]);
                    $to = stores::where('st_no', $st_no2)->where('item_no', $item['item_no'])->first();}
            }
            if ($per_type==4) {
                $from = halls::where('hall_no', $this->place_no1)->where('item_no',$item['item_no'])->first();
                $to = halls::where('hall_no', $hall_no)->where('item_no', $item['item_no'])->first();
                if (!$to) {halls::insert(['hall_no' => $hall_no, 'item_no' => $item['item_no'],'raseed'=>0]);
                           $to = halls::where('hall_no', $hall_no)->where('item_no', $item['item_no'])->first();}


            }
            $from->raseed -= $item['quant'];
            $from->save();
            $to->raseed += $item['quant'];
            $to->save();
          }

        if ($this->HasRaseed)
        {
          DB::connection(Auth()->user()->company)->commit();
          $this->mount();
          $this->emitTo('stores.store-head','mounthead');
          $this->emit('stores.store-detail','mountdetail');
        } else {DB::connection(Auth()->user()->company)->rollback();}



      } catch (\Exception $e) {
        DB::connection(Auth()->user()->company)->rollback();

        $this->dispatchBrowserEvent('mmsg', 'حدث خطأ');
      }


    }
  }
    public function render()
    {
        return view('livewire.stores.store-table');
    }
}
