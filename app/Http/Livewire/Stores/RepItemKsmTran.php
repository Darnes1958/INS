<?php

namespace App\Http\Livewire\Stores;


use App\Models\stores\items;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class RepItemKsmTran extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';

  public $item_no;

  public $item_name;
  public $tran_date;

  public $itemno=0;
  public $trandate;
  protected $listeners = [
    'Take_Search_JehaNo',
  ];

  public $TheItemListSelected;

  public function updatedTheItemListSelected(){
    $this->TheItemListSelected=0;

    $this->ItemKeyDown();
  }

  public function ChkItem(){
    if ($this->item_no !=null ) {
      $this->item_name = '';
      $res = items::on(Auth()->user()->company)->find($this->item_no);
      if ($res) {
        $this->item_name = $res->item_name;


        return ('ok');
      } else {
        $this->dispatchBrowserEvent('mmsg', 'هذا الرقم غير مخزون ؟');
        return ('not');
      }
    } else {return ('empty');}
  }
  public function ItemKeyDown(){
    $this->validate();
    $res=$this->ChkItem();
    if ($res !='empty' && $res!='not')  {
      $this->emitTo('stores.item-select','TakeItemNo',$this->item_no);
      $this->itemno=$this->item_no;
      $this->emit('gotonext','tran_date');

    }

  }
  public function DateKeyDown(){

    $this->validate();
    $this->trandate=$this->tran_date;


  }
  protected function rules()
  {
    Config::set('database.connections.other.database', Auth::user()->company);

    return [

      'item_no' =>['required','integer','gt:0', 'exists:other.items,item_no'],
      'tran_date' => ['required','date'],


    ];
  }
  protected $messages = [
    'exists' => 'هذا الرقم غير مخزون',
    'required' => 'لا يجوز ترك فراغ',

    'tran_date.required'=>'يجب ادخال تاريخ صحيح',
  ];


  public function mount(){

    $date = Carbon::now()->subYear();

    $this->tran_date = $date->copy()->startOfYear();
    $this->tran_date=$this->tran_date->ToDateString();
    $this->trandate=$this->tran_date;

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
      $first=DB::connection(Auth()->user()->company)->table('main')
      ->join('kst_trans','main.no','=','kst_trans.no')
      ->join('sell_tran','main.order_no','=','sell_tran.order_no')
      ->selectRaw('main.no,acc,name,ksm_date,ksm,\'قائم\'as MainOrArc' )
      ->where('item_no',$this->itemno)
      ->where('ksm_date','>=',$this->trandate)
      ->where('kst_trans.ksm','!=',null)
      ->where('kst_trans.ksm','!=',0);

      $second=DB::connection(Auth()->user()->company)->table('mainarc')
      ->join('transarc','mainarc.no','=','transarc.no')
      ->join('sell_tran','mainarc.order_no','=','sell_tran.order_no')
      ->selectRaw('mainarc.no,acc,name,ksm_date,ksm,\'أرشيف\'as MainOrArc')
      ->where('item_no',$this->itemno)
      ->where('ksm_date','>=',$this->trandate)
      ->where('transarc.ksm','!=',null)
      ->where('transarc.ksm','!=',0)
      ->unionAll($first)
      ->orderBy('ksm_date')
      ->get();
      $data=$this->paginate($second);
      $SumKsm=$second->sum('ksm');

        return view('livewire.stores.rep-item-ksm-tran',[

          'RepTable'=>$data,'SumKsm'=>$SumKsm,

        ]);
    }
}
