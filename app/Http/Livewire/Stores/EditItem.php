<?php

namespace App\Http\Livewire\Stores;

use App\Models\stores\item_price_buy;
use App\Models\stores\item_type;
use App\Models\stores\items;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class EditItem extends Component
{
  public $item_no;
  public $item_name;
  public $item_type;
  public $price_buy;
  public $price_sell;


  protected $listeners = [
    'GetTheId',
  ];
  protected function rules()
  {
    Config::set('database.connections.other.database', Auth::user()->company);
    return [
      'item_name' => ['required'],
      'item_type' =>['required','integer','gt:0','exists:other.item_type,type_no'],
      'price_buy' =>['required','numeric','gt:0'],
      'price_sell' =>['required','numeric','gt:0'],
    ];
  }
  public function CloseMyTableEdit_live(){
    $this->dispatchBrowserEvent('CloseMyTableEdit');
  }
  public function EditSaveItem()
  {
    $this->validate();
    Config::set('database.connections.other.database', Auth::user()->company);
    items::findorfail($this->item_no)->update([
      'item_name'=>$this->item_name,
      'item_type'=>$this->item_type,
      'price_buy'=>$this->price_buy,
      'price_sell'=>$this->price_sell,
    ]);
    $this->reset();
    $this->dispatchBrowserEvent('CloseMyTableEdit');
  }
  public function GetTheId($TheId){
    $this->item_no=$TheId;
    Config::set('database.connections.other.database', Auth::user()->company);
    $items= items::find($this->item_no);
    $this->item_name=$items->item_name;
    $this->item_type=$items->item_type;
    $this->price_buy=$items->price_buy;
    $this->price_sell=$items->price_sell;
  }

  public function render()
  {
    Config::set('database.connections.other.database', Auth::user()->company);
    return view('livewire.stores.edit-item',['item_types'=>item_type::all(),]);
  }
}
