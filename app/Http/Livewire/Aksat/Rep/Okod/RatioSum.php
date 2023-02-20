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

class RatioSum extends Component
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

    return view('livewire.aksat.rep.okod.ratio-sum',[
      'ssul'=>main::on(Auth()->user()->company)->sum('sul'),
      'ppay'=>main::on(Auth()->user()->company)->sum('sul_pay'),
      'rraseed'=>main::on(Auth()->user()->company)->sum('raseed'),
      'RepTable'=>DB::connection(Auth()->user()->company)
          ->table('PlaceSum_view')
          ->selectRaw('place_no,place_name,place_type,SUM(sumsul) AS sumsul, SUM(sumpay) AS sumpay,
                            SUM(sumraseed) AS sumraseed ,sum(ratio) ratio')

      ->groupBy('place_no','place_name','place_type')
      ->orderby($this->orderColumn,$this->sortOrder)
      ->paginate(14),
      'BankTable'=>DB::connection(Auth()->user()->company)
            ->table('main')
            ->join('sells','main.order_no','=','sells.order_no')
            ->join('bank','main.bank','=','bank.bank_no')
            ->join('BankTajmeehy','bank.bank_tajmeeh','=','TajNo')

            ->selectRaw('bank,bank_name, ratio_type, SUM(sul) AS sumsul, SUM(sul_pay) AS sumpay,
                            SUM(raseed) AS sumraseed, SUM(dofa) AS sumdofa, SUM(sul_tot) AS sumsul_tot,
                            CASE WHEN ratio_type=\'R\' THEN sum(ratio_val*raseed/100)   
                                 WHEN ratio_type=\'V\' THEN sum(ratio_val*round(raseed/kst,0,0) ) 
                            END as ratio

            ')
            ->where('sells.sell_type',$this->PlaceType)
            ->where('sells.place_no',$this->PlaceNo)
            ->where('ratio_type','!=',null)
            ->groupBy('bank','bank_name','ratio_type')
            ->orderby('bank')
            ->paginate(14, ['*'], 'BankPage'),
    ]);
  }
}
