<?php

namespace App\Http\Livewire\Aksat;


use App\Models\aksat\main;
use App\Models\aksat\MainArc;
use App\Models\aksat\place;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AddPlace extends Component
{
  use WithPagination;
  public $place_name;
  public $EditMod=false;
  public $place_no;

  protected function rules()
  {

    return [
      'place_name' => ['required'],
    ];
  }

  protected $messages = [
    'required' => 'يجب ملء البيان',
  ];

  public function EditOne($place_no,$place_name){
    $this->place_no=$place_no;
    $this->place_name=$place_name;
    $this->EditMod=true;
    $this->emit('gotoedit','place_name');
  }
  public function DeleteOne($place_no){
    $this->place_no=$place_no;
    if (main::on(Auth()->user()->company)->where('place',$this->place_no)->exists() ||
        MainArc::on(Auth()->user()->company)->where('place',$this->place_no)->exists()) {
      $this->dispatchBrowserEvent('mmsg', 'سبق استخدام جهة العمل هذه ولا يجوز الغاءها');
      return false;
    }
    place::on(Auth()->user()->company)->where('place_no',$this->place_no)->delete();
    $this->render();
  }
  public function SaveOne(){
    $this->validate();

    if ($this->EditMod){

      DB::connection(Auth()->user()->company)->table('place')
        ->where('place_no',$this->place_no)
        ->update([
        'place_name' => $this->place_name,
      ]);
      $this->EditMod=false;
    } else {
    $this->place_no=place::on(Auth()->user()->company)->max('place_no')+1;
    DB::connection(Auth()->user()->company)->table('place')->insert([
      'place_no' => $this->place_no,
      'place_name' => $this->place_name,
    ]);}
    $this->place_name='';
    $this->emit('placeadded',$this->place_no);

    session()->flash('message', 'تم تخزين البيانات');

  }
  public function mount(){
    $this->place_name='';

  }
  protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.aksat.add-place',[
        'place' => place::on(Auth()->user()->company)->paginate(10),
        ]);
    }
}
