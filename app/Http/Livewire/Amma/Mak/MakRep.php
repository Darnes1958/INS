<?php

namespace App\Http\Livewire\Amma\Mak;

use App\Models\stores\halls_names;
use App\Models\stores\stores_names;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;


class MakRep extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';
  public $search;
  public $RepChk=true;

  public $place_no=0;
  public $place_name;
  public $place_type=0;
  public $Table='Makazen';
  public $PlaceChk=false;
  public $PlaceGeted=false;
  public $ThePlaceListIsSelected;

  public function updatedThePlaceListIsSelected(){
    $this->ThePlaceListIsSelected=0;
    $this->ChkPlaceAndGo();
  }
  public function ChkPlaceAndGo(){


    if ($this->place_no!=null) {
      if ($this->place_type==0 )
        $result =stores_names::on(Auth()->user()->company)->where('st_no',$this->place_no)->first();
      if ($this->place_type==1 )
        $result =halls_names::on(Auth()->user()->company)->where('hall_no',$this->place_no)->first();
      if ($result) {
        $this->PlaceGeted=true;
        if ($this->place_type==0 )
          $this->place_name=$result->st_name;
        if ($this->place_type==1 )
          $this->place_name=$result->hall_name;
        $this->PlaceGeted=true;

      } else $this->dispatchBrowserEvent('mmsg','هذا الرقم غير مخزون');
    }
  }
  public function updatingSearch()
  {
    $this->resetPage();
  }
  public function updatingRepChk()
  {
    $this->resetPage();
  }
    public function updatingPlaceChk()
    {
        $this->resetPage();
    }
    public function updatingPlacetype()
    {
        info('here '.$this->place_type);

        $this->place_no=0;

        $this->resetPage();
        if ($this->place_type==1) $this->Table='Makazen';
        if ($this->place_type==0) $this->Table='Salat';
        $this->emitTo('stores.store-select1','ResetYou',$this->Table);
    }

    public function render()
    {

      if ($this->RepChk) {
       if ($this->PlaceChk) {
           return view('livewire.amma.mak.mak-rep',[
               'RepTable'=>DB::connection(Auth()->user()->company)->table('rep_makzoon')
                   ->where('place_type',$this->place_type)
                   ->where('place_no',$this->place_no)
                   ->where(function ($query) {
                       $query->where('item_name', 'like', '%' . $this->search . '%')
                           ->orWhere('item_no', 'like', '%'.$this->search.'%')
                           ->orWhere('type_name', 'like', '%'.$this->search.'%');
                   })

                   ->orderBy('item_type','asc')
                   ->orderBy('item_no','asc')->paginate(15)
           ]);
       } else
       return view('livewire.amma.mak.mak-rep',[
          'RepTable'=>DB::connection(Auth()->user()->company)->table('rep_makzoon')
            ->where('item_name', 'like', '%'.$this->search.'%')
            ->orwhere('item_no', 'like', '%'.$this->search.'%')
            ->orwhere('type_name', 'like', '%'.$this->search.'%')
            ->orderBy('item_type','asc')
            ->orderBy('item_no','asc')->paginate(15)
        ]);}
      else {
        return view('livewire.amma.mak.mak-rep',[
          'RepTable'=>DB::connection(Auth()->user()->company)->table('rep_makzoon')
            ->when($this->PlaceGeted,function ($q) {
              return $q->where('place_no','=', $this->place_no) ;     })
            ->when($this->place_type==1,function ($q) {
              return $q->where('place_type','=', 0) ;     })
            ->when($this->place_type==2,function ($q) {
              return $q->where('place_type','=', 1) ;     })
            ->where('raseed','!=',0)
            ->where('place_ras','!=',0)
            ->where([
              ['item_name', 'like', '%'.$this->search.'%'],
              ['item_no', 'like', '%'.$this->search.'%'],
              ['type_name', 'like', '%'.$this->search.'%'],
            ])
            ->orderBy('item_type','asc')
            ->orderBy('item_no','asc')->paginate(15)
        ]);
      }
    }
}
