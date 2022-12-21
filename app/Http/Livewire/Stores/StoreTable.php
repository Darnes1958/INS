<?php

namespace App\Http\Livewire\Stores;

use Livewire\Component;

class StoreTable extends Component
{
  public $perdetail=[];


  protected $listeners = [
    'putdata',
  ];

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
  public function mount(){
    $this->perdetail=[
      ['item_no'=>'0','item_name'=>'',
        'quant'=>'0' ]
    ];
  }

    public function render()
    {
        return view('livewire.stores.store-table');
    }
}
