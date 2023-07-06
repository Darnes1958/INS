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

class BankKstCount extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';
  public $search;
  public $date1;
  public $date2;
  public $RepChk=false;

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

    return view('livewire.aksat.rep.okod.bank-kst-count',[
      'ssul'=>main::on(Auth()->user()->company)->sum('sul'),
      'ppay'=>main::on(Auth()->user()->company)->sum('sul_pay'),
      'rraseed'=>main::on(Auth()->user()->company)->sum('raseed'),
      'ccount'=>main::on(Auth()->user()->company)->count(),
      'RepTable'=>DB::connection(Auth()->user()->company)->table('main_view')
      ->selectRaw('bank, bank_name, COUNT(*) AS WCOUNT, SUM(sul) AS sumsul, SUM(sul_pay) AS sumpay,
                            SUM(raseed) AS sumraseed,
                             (SELECT       count(*) AS Expr1
                               FROM             dbo.kst_trans
                               WHERE         (no in (select no from main where main.bank=main_view.bank) ) and (ksm is null or ksm=0)) AS kst_count
                             
                 ')
      ->groupBy('bank','bank_name')
      ->orderby('bank')
      ->paginate(14),

    ]);
  }
}
