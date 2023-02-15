<?php

namespace App\Http\Livewire\Bank;

use App\Models\bank\bank;
use App\Models\bank\BankRatio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class RepBankRatio extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $bank_no;
    public $bank_name;
    public $year;
    public $month;

    public $place;
    public $place_type;
    public $place_name;




    protected $listeners = [
        'TakeBank',
    ];
    public function selectItem($place_type,$place){
      $this->place=$place;
      $this->place_type=$place_type;

      $this->place_name=DB::connection(Auth::user()->company)->table('place_view')
          ->where('place_type',$place_type)
          ->where('place_no',$place)->first()->place_name;
        $this->resetPage();
    }
    public function TakeBank($bank_no){

        $this->bank_no=$bank_no;
        $this->bank_name=bank::on(Auth::user()->company)->find($this->bank_no)->bank_name;
        $this->resetPage();
    }

    public function render()
    {

        return view('livewire.bank.rep-bank-ratio',[
          'years'=>DB::connection(Auth()->user()->company)->table('BankRatio')
            ->selectRaw('distinct Y as year')
            ->get(),
            'PlaceTable'=>BankRatio::on(Auth()->user()->company)
                ->join('place_view', function ($join) {
                    $join->on('BankRatio.place', '=', 'place_view.place_no')
                         ->on('BankRatio.place_type', '=', 'place_view.place_type');
                })
            ->selectRaw('bank,place,BankRatio.place_type,place_name,
              sum(kst_count) as kst_count,sum(tot_kst) as tot_kst,sum(tot_ratio) tot_ratio')
            ->where('Y',$this->year)
            ->where('bank',$this->bank_no)
            ->groupBy('bank','place','BankRatio.place_type','place_name')->paginate(15),

            'MonthTable'=>BankRatio::on(Auth()->user()->company)
             ->select('M','kst_count','tot_kst','tot_ratio')
            ->where('bank',$this->bank_no)
            ->where('Y',$this->year)
            ->where('place_type',$this->place_type)
            ->where('place',$this->place)
            ->orderBy('M')->paginate(15),

        ]);
    }
}
