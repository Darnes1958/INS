<?php

namespace App\Http\Livewire\Buy;

use App\Models\stores\items;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ItemDropDown extends Component
{
    public $select_no = '';

    public $select_name ;
    public function render()
    {
        Config::set('database.connections.other.database', Auth::user()->company);
        $this->select_name=DB::connection('other')->select('select item_no,item_name from items ');

        return view('livewire.buy.item-drop-down');
    }
}
