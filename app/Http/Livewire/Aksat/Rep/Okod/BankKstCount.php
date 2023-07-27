<?php

namespace App\Http\Livewire\Aksat\Rep\Okod;

use App\Models\aksat\main;
use App\Models\aksat\main_kst_count;
use App\Models\aksat\main_sells_bank_view;
use App\Models\aksat\main_view;
use App\Models\bank\rep_banks;
use App\Models\OverTar\over_kst;
use App\Models\stores\halls_names;
use App\Models\stores\stores_names;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class BankKstCount extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';
  public $search;
  public $date1;
  public $date2;
  public $RepChk=false;
  public $RepRadio='ByBank';
  public $place_name;
  public $place_type=0;

  public $place_no=0;
  public $PlaceGeted=false;
  public $Table='Makazen';
  public $PlaceChk=false;

  public $ThePlaceListIsSelected=0;

  public function updatingSearch()
  {
    $this->resetPage();
  }
  public function updatedThePlaceListIsSelected(){
    info('updated');
    $this->ThePlaceListIsSelected=0;
    $this->ChkPlaceAndGo();
  }
  public function updatingPlacetype()
  {
    $this->place_no=0;
    $this->resetPage();
    if ($this->place_type==1) $this->Table='Makazen';
    if ($this->place_type==0) $this->Table='Salat';
    $this->emitTo('stores.store-select3','ResetYou',$this->Table);
  }
  public function updatingPlaceChk()
  {
    if ($this->PlaceChk) $this->emitTo('stores.store-select3','ResetYou',$this->Table);
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

  public function mount(){
    $this->date1=Carbon::now()->startOfMonth()->toDateString();
    $this->date2=Carbon::now()->endOfMonth()->toDateString();
    $this->emitTo('stores.store-select3','ResetYou',$this->Table);

  }
  public function render()
  {

    return view('livewire.aksat.rep.okod.bank-kst-count',[
      'ssul'=>main::on(Auth()->user()->company)->sum('sul'),
      'ppay'=>main::on(Auth()->user()->company)->sum('sul_pay'),
      'rraseed'=>main::on(Auth()->user()->company)->sum('raseed'),
      'ccount'=>main::on(Auth()->user()->company)->count(),


      'PlaceTable'=>main_kst_count::on(Auth()->user()->company)

        ->selectRaw('place_no,place_name,bank, bank_name, COUNT(*) AS WCOUNT, SUM(sul) AS sumsul, SUM(sul_pay) AS sumpay,
                            SUM(raseed) AS sumraseed,sum(kst_count) as kst_count,sum(kst_count_not) as kst_count_not ')
        ->when($this->place_no !=0,function ($q) {
          return $q->where('place_name','=', $this->place_name) ;     })
        ->groupBy('place_no','place_name','bank','bank_name')
        ->orderBy('place_no')

        ->paginate(15),
      'RepTable'=>DB::connection(Auth()->user()->company)->table('main_view')
      ->selectRaw('bank, bank_name, COUNT(*) AS WCOUNT, SUM(sul) AS sumsul, SUM(sul_pay) AS sumpay,
                            SUM(raseed) AS sumraseed,
                             (SELECT       count(*) AS Expr1
                               FROM             dbo.kst_trans
                               WHERE         (no in (select no from main where main.bank=main_view.bank) ) and (ksm is null or ksm=0)) AS kst_count
                             
                 ')
      ->groupBy('bank','bank_name')
      ->orderby('bank')

      ->paginate(15, ['*'], 'ByPlaceTable'),

    ]);


  }
}
