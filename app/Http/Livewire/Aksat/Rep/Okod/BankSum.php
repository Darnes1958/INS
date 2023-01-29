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

class BankSum extends Component
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

    return view('livewire.aksat.rep.okod.bank-sum',[
      'RepTable'=>DB::connection(Auth()->user()->company)->table('main_view')
      ->selectRaw('bank, bank_name, COUNT(*) AS WCOUNT, SUM(sul) AS sumsul, SUM(sul_pay) AS sumpay,
                            SUM(raseed) AS sumraseed, SUM(dofa) AS sumdofa, SUM(sul_tot) AS sumsul_tot,
                             (SELECT       SUM(kst) AS Expr1
                               FROM             dbo.over_kst
                               WHERE         (bank = dbo.main_view.bank)) AS over_kst,
                             (SELECT       SUM(kst) AS Expr1
                               FROM             dbo.tar_kst
                               WHERE         (bank = dbo.main_view.bank)) AS tar_kst,
                             (SELECT       SUM(kst) AS Expr1
                               FROM             dbo.wrong_kst
                               WHERE         (bank = dbo.main_view.bank)) AS wrong_kst
                 ')
      ->groupBy('bank','bank_name')
      ->orderby('bank')
      ->paginate(14),
      'RepTable2'=>DB::connection(Auth()->user()->company)->table('main_view')
        ->selectRaw('bank, bank_name, COUNT(*) AS WCOUNT, SUM(sul) AS sumsul, SUM(sul_pay) AS sumpay,
                            SUM(raseed) AS sumraseed, SUM(dofa) AS sumdofa, SUM(sul_tot) AS sumsul_tot,
                             (SELECT       SUM(kst) AS Expr1
                               FROM             dbo.over_kst
                               WHERE         (bank = dbo.main_view.bank)) AS over_kst,
                             (SELECT       SUM(kst) AS Expr1
                               FROM             dbo.tar_kst
                               WHERE         (bank = dbo.main_view.bank)) AS tar_kst,
                             (SELECT       SUM(kst) AS Expr1
                               FROM             dbo.wrong_kst
                               WHERE         (bank = dbo.main_view.bank)) AS wrong_kst
                 ')
        ->groupBy('bank','bank_name')
        ->whereBetween('sul_date',[$this->date1,$this->date2])
        ->orderby('bank')
        ->paginate(14)
    ]);
  }
}
