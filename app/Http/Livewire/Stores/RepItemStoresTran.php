<?php

namespace App\Http\Livewire\Stores;


use App\Models\stores\items;
use App\Models\stores\stores_item_tran;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class RepItemStoresTran extends Component
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

  public function OpenJehaSerachModal(){
    $this->dispatchBrowserEvent('OpenjehaModal');
  }
  public function CloseJehaSerachModal(){
    $this->dispatchBrowserEvent('ClosejehaModal');
  }
  public function mount(){

    $date = Carbon::now()->subYear(10);

    $this->tran_date = $date->copy()->startOfYear();
    $this->tran_date=$this->tran_date->ToDateString();
    $this->trandate=$this->tran_date;

  }

    public function render()
    {
        return view('livewire.stores.rep-item-stores-tran',[
          'RepTable'=>stores_item_tran::where('item_no',$this->itemno)
          ->where('tran_date','>=',$this->trandate)->paginate(15)

        ]);
    }
}
