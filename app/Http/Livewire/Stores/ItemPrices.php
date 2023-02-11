<?php

namespace App\Http\Livewire\Stores;

use App\Models\stores\item_price_sell;
use App\Models\stores\items;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class ItemPrices extends Component
{
    public $item_no;
    public $price_nakdy;
    public $price_tak;

    public $ItemGeted=false;
    public $TheItemIsSelected;

    public function updatedTheItemIsSelected(){
        $this->TheItemIsSelected=0;
        $this->ChkItemAndGo();
    }
    public function ChkItemAndGo(){
        $this->price_nakdy='';
        $this->price_tak='';

        $this->ItemGeted=false;

        if ($this->item_no!=null) {
            $result=items::on(Auth()->user()->company)
                ->where('item_no', $this->item_no)->first();
            if ($result) {

                $this->price_nakdy=number_format($result->price_sell, 2, '.', '')  ;

                $res=item_price_sell::on(Auth()->user()->company)
                    ->where('item_no',$this->item_no)
                    ->where('price_type',2)->first();
                if ($res) $this->price_tak=number_format($res->price, 2, '.', '');
                else $this->price_tak=0;


                $this->ItemGeted=true;
                $this->emitTo('stores.item-select','TakeItemNo',$this->item_no);
                $this->emit('gotonext','price_nakdy');
            }}
    }
    protected function rules()
    {
        Config::set('database.connections.other.database', Auth::user()->company);
        return [
            'item_no' => ['required','integer','gt:0', 'exists:other.items,item_no'],
            'price_nakdy' =>   ['required','numeric','gt:0'],
            'price_tak' =>   ['required','numeric'  ,'gt:0'],
        ];
    }
    protected $messages = [
        'required' => 'لا يجوز ترك فراغ',
        'exists' => 'هذا الرقم غير مخزون مسبقا',


    ];
    public function Save(){
        $this->validate();
        items::on(Auth()->user()->company)
            ->where('item_no', $this->item_no)->update([
                'price_sell'=>$this->price_nakdy
            ]);
        item_price_sell::on(Auth()->user()->company)
            ->where('item_no', $this->item_no)
            ->where('price_type',1)
            ->update([
                'price'=>$this->price_nakdy
            ]);
        item_price_sell::on(Auth()->user()->company)
            ->where('item_no', $this->item_no)
            ->where('price_type',2)
            ->update([
                'price'=>$this->price_tak
            ]);
        $this->item_no='';
        $this->price_nakdy='';
        $this->price_tak='';
        $this->ItemGeted-false;
        $this->emit('gotonext','item_no');
    }
    public function render()
    {
        return view('livewire.stores.item-prices');
    }
}
