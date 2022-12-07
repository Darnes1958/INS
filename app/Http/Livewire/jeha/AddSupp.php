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
  public $jehaname;
  public $address;
  public $libyana;
  public $mdar;
  public $others;
  public $jeha_type=2;

  protected $listeners = [
    'refreshComponent' => '$refresh','WithJehaType'
  ];
  public function WithJehaType($jeha_type)
  {
    info($this->jeha_type);
    $this->jeha_type=$jeha_type;
  }

  protected function rules()
  {
    Config::set('database.connections.other.database', Auth::user()->company);
    return [

      'jehaname' => ['required']
    ];
  }

  public function resetModal(){
    $this->jehaname='';
    $this->address='';
    $this->libyana='';
    $this->mdar='';
    $this->others='';

  }
  public function SaveJeha()
  {
    $this->validate();

    Config::set('database.connections.other.database', Auth::user()->company);
    $this->jeha_no = jeha::max('jeha_no')+1;
    DB::connection('other')->table('jeha')->insert([

      'jeha_no' => $this->jeha_no,
      'jeha_name' => $this->jehaname,
      'address' => $this->address,
      'libyana' => $this->libyana,
      'mdar' => $this->mdar,
      'others' => $this->others,
      'charge_by'=>0,
      'emp'=>auth::user()->empno,
      'available'=>1,
      'jeha_type'=>$this->jeha_type,

    ]);

    $this->emit('jehaadded',$this->jeha_no);
    $this->resetModal();
    $this->dispatchBrowserEvent('CloseModal');

  }

    public function mount(){


     $this->resetModal();

    }
    public function render()
    {
        return view('livewire.jeha.add-Supp');
    }
}
