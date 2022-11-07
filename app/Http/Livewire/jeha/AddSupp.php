<?php

namespace App\Http\Livewire\Jeha;

use App\Models\jeha\jeha;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AddSupp extends Component
{
  public $jeha_no;
  public $jeha_name;
  public $address;
  public $libyana;
  public $mdar;
  public $others;



  protected function rules()
  {
    Config::set('database.connections.other.database', Auth::user()->company);
    return [

      'jeha_name' => ['required'],
    ];
  }
  public function SaveJeha()
  {
    $this->validate();

    Config::set('database.connections.other.database', Auth::user()->company);
    $this->jeha_no = jeha::max('jeha_no')+1;
    DB::connection('other')->table('jeha')->insert([

      'jeha_no' => $this->jeha_no,
      'jeha_name' => $this->jeha_name,
      'address' => $this->address,
      'libyana' => $this->libyana,
      'mdar' => $this->mdar,
      'others' => $this->others,
      'charge_by'=>1,
      'emp'=>auth::user()->empno,
      'available'=>1,
      'jeha_type'=>2,

    ]);
    $this->emit('jehaadded',$this->jeha_no);
    $this->dispatchBrowserEvent('CloseModal');

  }
    public function render()
    {
        return view('livewire.jeha.add-Supp');
    }
}
