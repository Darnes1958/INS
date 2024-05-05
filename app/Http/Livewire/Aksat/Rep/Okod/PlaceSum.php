<?php

namespace App\Http\Livewire\Aksat\Rep\Okod;

use App\Models\aksat\main;
use App\Models\bank\rep_banks;
use App\Models\OverTar\over_kst;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class PlaceSum extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';
  public $search;
  public $date1;
  public $date2;
  public $RepChk=false;
  public $PlaceType=0;
  public $PlaceNo=0;
  public $PlaceName='';



    public $orderColumn = "place_name";
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

    public function selectItem($type,$no,$name){
       $this->PlaceType=$type;
       $this->PlaceNo=$no;
       $this->PlaceName=$name;

    }

  public function updatingSearch()
  {
    $this->resetPage();
  }

  public function mount(){
    $this->date1=Carbon::now()->startOfMonth()->toDateString();
    $this->date2=Carbon::now()->endOfMonth()->toDateString();

  }
  public function render()
  {

    return view('livewire.aksat.rep.okod.place-sum',[
      'ssul'=>main::on(Auth()->user()->company)->sum('sul'),
      'ppay'=>main::on(Auth()->user()->company)->sum('sul_pay'),
      'rraseed'=>main::on(Auth()->user()->company)->sum('raseed'),
      'ccount'=>main::on(Auth()->user()->company)->count(),
      'RepTable'=>DB::connection(Auth()->user()->company)
          ->table('main')
          ->join('sells','main.order_no','=','sells.order_no')
          ->join('place_view', function ($join) {
              $join->on('sells.place_no', '=', 'place_view.place_no')
                  ->on('sells.sell_type', '=', 'place_view.place_type');
          })
      ->selectRaw('sells.place_no,sells.sell_type, place_name, COUNT(*) AS WCOUNT, SUM(sul) AS sumsul, SUM(sul_pay) AS sumpay,
                            SUM(raseed) AS sumraseed, SUM(dofa) AS sumdofa, SUM(sul_tot) AS sumsul_tot

                 ')
      ->groupBy('sells.place_no','sells.sell_type','place_name')
          ->orderby($this->orderColumn,$this->sortOrder)
      ->paginate(14),
      'RepTable2'=>DB::connection(Auth()->user()->company)
          ->table('main')
          ->join('sells','main.order_no','=','sells.order_no')
          ->join('place_view', function ($join) {
              $join->on('sells.place_no', '=', 'place_view.place_no')
                  ->on('sells.sell_type', '=', 'place_view.place_type');
          })
        ->selectRaw('sells.place_no,sells.sell_type, place_name, COUNT(*) AS WCOUNT, SUM(sul) AS sumsul, SUM(sul_pay) AS sumpay,
                            SUM(raseed) AS sumraseed, SUM(dofa) AS sumdofa, SUM(sul_tot) AS sumsul_tot
                 ')
          ->groupBy('sells.place_no','sells.sell_type','place_name')
          ->whereBetween('sul_date',[$this->date1,$this->date2])
          ->orderby($this->orderColumn,$this->sortOrder)
          ->paginate(14),

        'Rssul'=>main::on(Auth()->user()->company)->whereBetween('sul_date',[$this->date1,$this->date2])->sum('sul'),
        'Rppay'=>main::on(Auth()->user()->company)->whereBetween('sul_date',[$this->date1,$this->date2])->sum('sul_pay'),
        'Rrraseed'=>main::on(Auth()->user()->company)->whereBetween('sul_date',[$this->date1,$this->date2])->sum('raseed'),
        'Rccount'=>main::on(Auth()->user()->company)->whereBetween('sul_date',[$this->date1,$this->date2])->count(),

        'BankTable'=>DB::connection(Auth()->user()->company)
            ->table('main_view')
            ->join('sells','main_view.order_no','=','sells.order_no')

            ->selectRaw('bank,bank_name, COUNT(*) AS WCOUNT, SUM(sul) AS sumsul, SUM(sul_pay) AS sumpay,
                            SUM(raseed) AS sumraseed, SUM(dofa) AS sumdofa, SUM(sul_tot) AS sumsul_tot')
            ->where('sells.sell_type',$this->PlaceType)
            ->where('sells.place_no',$this->PlaceNo)
            ->when($this->RepChk,function ($q){
                $q->whereBetween('sul_date',[$this->date1,$this->date2]);
            })
            ->groupBy('bank','bank_name')
            ->orderby('bank')
            ->paginate(14, ['*'], 'BankPage'),
    ]);
  }
}
