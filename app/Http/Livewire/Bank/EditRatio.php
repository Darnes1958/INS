<?php

namespace App\Http\Livewire\Bank;

use App\Models\bank\BankTajmeehy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class EditRatio extends Component

{
    public BankTajmeehy $tajmeehy;
    protected $listeners = [
        'TakeTaj',
    ];
    protected function rules()
    {
        Config::set('database.connections.other.database', Auth::user()->company);
        return [

            'tajmeehy.ratio_type' =>['required'],
            'tajmeehy.ratio_val' =>['required','integer','gt:0','lt:11']  ,
        ];
    }
    public function TakeTaj($tajno){
        $this->tajmeehy=BankTajmeehy::on(Auth()->user()->company)->find($tajno);
    }
    protected $messages = [
        'required' => 'لا يجوز ترك فراغ',
        'exists' => 'هذا الرقم غير مخزون مسبقا',
    ];
    public function SaveTaj(){
        $this->validate();
        $this->tajmeehy->save();
        $this->dispatchBrowserEvent('CloseTajEdit');
    }
    public function render()
    {
        return view('livewire.bank.edit-ratio');
    }
}
