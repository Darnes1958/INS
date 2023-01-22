<?php

namespace App\Http\Livewire\Jeha;

use App\Models\buy\buy_tran;
use App\Models\buy\buys;
use App\Models\jeha\jeha;
use App\Models\jeha\jeha_type;
use App\Models\sell\sells;
use App\Models\trans\trans;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AddSupp extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';
  public $jeha_no;
  public $jehaname;
  public $address;
  public $libyana;
  public $mdar;
  public $others;
  public $jeha_type=2;

  public $jeha_type_name;

  public $UpdateMod=false;

  protected $listeners = [
    'refreshComponent' => '$refresh','WithJehaType','TakeJehaSearch','TextIsUpdate','TakeTheJehaNo'
  ];
  public function TextIsUpdate($jeha_name){
    $this->jehaname=$jeha_name;

  }
  public function TakeTheJehaNo(){

    $this->emit('gotonext','address');
  }
  public function TakeJehaSearch(){

    $this->emit('gotonext','address');
  }
  public function WithJehaType($jeha_type)
  {
    $this->jeha_type=$jeha_type;
  }

  public function SendSearch(){
    $this->emitTo('jeha.search-jeha','TakeSearch',$this->jehaname);
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




    if ($this->UpdateMod)
    DB::connection(Auth()->user()->company)->table('jeha')->where('jeha_no',$this->jeha_no)->update([
      'jeha_name' => $this->jehaname,
      'address' => $this->address,
      'libyana' => $this->libyana,
      'mdar' => $this->mdar,
      'others' => $this->others,
      'emp'=>auth::user()->empno,
    ]);
    else {
      $this->jeha_no = jeha::max('jeha_no') + 1;
      DB::connection(Auth()->user()->company)->table('jeha')->insert([
        'jeha_no' => $this->jeha_no,
        'jeha_name' => $this->jehaname,
        'address' => $this->address,
        'libyana' => $this->libyana,
        'mdar' => $this->mdar,
        'others' => $this->others,
        'charge_by' => 0,
        'emp' => auth::user()->empno,
        'available' => 1,
        'jeha_type' => $this->jeha_type,
      ]);
    }
    $this->UpdateMod=false;
    $this->emit('jehaadded',$this->jeha_no);
    $this->emitTo('jeha.search-jeha','TakeSearch','');
    $this->resetModal();
    $this->dispatchBrowserEvent('CloseModal');

  }
  public function selectItem($jeha_no,$action){
    $this->jeha_no=$jeha_no;
    if ($action=='delete') {$this->UpdateMod=false; $this->dispatchBrowserEvent('OpenMyDelete');}
    if ($action=='update') {

      $res=jeha::on(Auth()->user()->company)->where('jeha_no',$this->jeha_no)->first();

      $this->jehaname=$res->jeha_name;
      $this->address=$res->address;
      $this->libyana=$res->libyana;
      $this->mdar=$res->mdar;
      $this->others=$res->others;
      $this->UpdateMod=true;
      $this->emitTo('jeha.search-jeha','TakeSearchToEdit',$this->jehaname);}
  }
  public function CloseDeleteDialog(){$this->dispatchBrowserEvent('CloseMyDelete');}


  public function delete(){
    $this->CloseDeleteDialog();
    if (buys::on(Auth()->user()->company)->where('jeha',$this->jeha_no)->exists() ||
        sells::on(Auth()->user()->company)->where('jeha',$this->jeha_no)->exists()  ||
        trans::on(Auth()->user()->company)->where('jeha',$this->jeha_no)->exists()) {
      $this->dispatchBrowserEvent('mmsg', 'هذا العميل مستخدم مسبقا ولا يمكن الغاءه');
      return false;
    }
    jeha::on(Auth()->user()->company)->where('jeha_no',$this->jeha_no)->delete();
    $this->render();
  }

    public function mount($jeha_type=1){


     $this->resetModal();
     $this->jeha_type=$jeha_type;
     $this->jeha_type_name=jeha_type::on(Auth()->user()->company)->where('type_no',$this->jeha_type)->first()->type_name;

    }
    public function render()
    {
        return view('livewire.jeha.add-Supp',[
          'JehaTable'=>jeha::on(Auth()->user()->company)->where('jeha_type',$this->jeha_type)
            ->orderBy('jeha_no','desc')
            ->paginate(15),
        ]);
    }
}
