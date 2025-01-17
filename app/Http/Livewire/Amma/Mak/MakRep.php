<?php

namespace App\Http\Livewire\Amma\Mak;

use App\Models\stores\halls_names;
use App\Models\stores\item_type;
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
  public $RepChk=false;
  public $withzero=1;

  public $type_no=0;
  public $type_name;
  public $place_no=0;

  public $place_name;
  public $place_type=0;
  public $Table='Makazen';
  public $PlaceChk=false;
  public $TypeChk=false;
  public $TotChk=false;
  public $PlaceGeted=false;
  public $ThePlaceListIsSelected;
    public $TheTypeListIsSelected;

  public $orderColumn = "item_no";
  public $sortOrder = "asc";
  public $sortLink = '<i class="sorticon fas fa-angle-up"></i>';

  public function sortOrder($columnName=""){
    $caretOrder = "up";
    if($this->sortOrder == 'asc'){
      $this->sortOrder = 'desc';
      $caretOrder = "down";
    }else{
      $this->sortOrder = 'asc';
      $caretOrder = "up";
    }
    $this->sortLink = '<i class="sorticon fas fa-angle-'.$caretOrder.'"></i>';

    $this->orderColumn = $columnName;

  }

  public function updatedThePlaceListIsSelected(){
    $this->ThePlaceListIsSelected=0;
    $this->ChkPlaceAndGo();
  }
    public function updatedTheTypeListIsSelected(){
        $this->TheTypeListIsSelected=0;
        $this->ChkTypeAndGo();
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
    public function ChkTypeAndGo(){

        if ($this->type_no!=null) {
                $result =item_type::on(Auth()->user()->company)->where('type_no',$this->type_no)->first();
            if ($result) {
              $this->type_name=$result->type_name;

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
      $this->place_no=0;
      $this->resetPage();
    }
    public function updatingPlacetype()
    {
        $this->place_no=0;
        $this->resetPage();
        if ($this->place_type==1) $this->Table='Makazen';
        if ($this->place_type==0) $this->Table='Salat';
        $this->emitTo('stores.store-select1','ResetYou',$this->Table);
    }

    public function render()
    {
      if ($this->RepChk) $this->withzero=1; else $this->withzero=0;

        return view('livewire.amma.mak.mak-rep',[
          'RepTable'=>DB::connection(Auth()->user()->company)->table('rep_makzoon')
            ->when($this->place_no !=0,function ($q) {
              return $q->where('place_no','=', $this->place_no) ;     })
            ->when($this->place_no !=0,function ($q) {
              return $q->where('place_type','=', $this->place_type) ;     })
            ->when( ! $this->RepChk,function ($q) {
              return $q->where('raseed','!=', 0) ;     })
            ->when( ! $this->RepChk,function ($q) {
              return $q->where('place_ras','!=', 0) ;     })
            ->when(  $this->TypeChk,function ($q) {
                  return $q->where('item_type',$this->type_no) ;     })
            ->where('item_name', 'like', '%'.$this->search.'%' )
            ->orderBy('item_type','asc')
            ->orderby($this->orderColumn,$this->sortOrder)
            ->paginate(15),
          'TotTable'=>DB::connection(Auth()->user()->company)->table('rep_makzoon')
           ->selectRaw('place_type,place_no,place_name,sum(price_buy*place_ras) price_buy,
                                 sum(price_sell*place_ras) price_sell,sum(price_cost*place_ras) price_cost
                                 ,sum(dbo.ret_price_tak(item_no)*place_ras) price_tak')
           ->groupby('place_type','place_no','place_name')
           ->orderBy('place_type')
           ->orderBy('place_no')
           ->paginate(15),
        ]);

    }
}
