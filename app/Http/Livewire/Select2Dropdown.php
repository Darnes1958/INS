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

    protected $listeners = [
      'jehafound','jehaadded',
    ];
  public function jehaadded($wj){
    if(!is_null($wj)) {
      $this->select_no = $wj;
      $this->select_name = jeha::where('jeha_type', 2)->where('available', 1)->get();
    }
  }
  public function jehafound($wj,$wn){

    if(!is_null($wj)) {
      $this->select_no = $wj;
      $this->select_name = $wn;

    }
  }

    public function render()
    {
        Config::set('database.connections.other.database', Auth::user()->company);
        $this->select_name=jeha::where('jeha_type',2)->where('available',1)->get();
        return view('livewire.select2-dropdown');
    }
}
