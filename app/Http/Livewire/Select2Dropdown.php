<?php

namespace App\Http\Livewire;

use App\Models\jeha\jeha;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class Select2Dropdown extends Component
{
    public $select_no = '';

    public $select_name ;

    public function render()
    {
        Config::set('database.connections.other.database', Auth::user()->company);
        $this->select_name=jeha::where('jeha_type',2)->where('available',1)->get();
        return view('livewire.select2-dropdown');
    }
}
