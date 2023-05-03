<?php

namespace App\Http\Livewire\Admin;

use App\Models\aksat\kst_trans;
use App\Models\aksat\main;
use App\Models\Customers;
use App\Models\sell\sells;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class WelcomePage extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
   public $Company;
   public $CompanyName;
   public $CompanyNameSuffix;
   public $Whome;
   public $ShowDailyTot=false,$ShowUsers=true;

    public array $dataset = [];
    public array $labels = [];
    public array $years = [];
    public array $backgroundColor;

    public array $sellcount = [];
    public array $maincount = [];
    public array $maintot = [];
    public array $kstcount = [];
    public array $ksttot = [];
    public array $rebhyear = [];
    public array $rebhtot = [];



   public function mount(){
     $this->Company=Auth::user()->company;
     $res=Customers::where('company',$this->Company)->first();
     $this->CompanyName=$res->CompanyName;
     $this->CompanyNameSuffix=$res->CompanyNameSuffix;
       $this->backgroundColor= [
           'rgba(15,64,97,255)',
           'rgba(95, 147, 87, 0.8)',
           'rgba(237, 42, 17, 0.8)',
           'RGBA( 0, 255, 255, 1 )',
           'RGBA( 165, 42, 42, 1 )',
           'RGBA( 127, 255, 0, 1 )',
           'RGBA( 220, 20, 60, 1 )',
           'RGBA( 0, 100, 0, 1 )',
           'RGBA( 139, 0, 139, 1 )',
           'RGBA( 85, 107, 47, 1 )',
           'RGBA( 255, 140, 0, 1 )',
           'RGBA( 128, 128, 128, 1 )',
       ];


   }

    public function render()
    {

        $date=Carbon::now();
        $year=$date->year;
        $tot=sells::selectRaw('month(order_date) month,round(sum(tot),0) tot')
           ->WhereYear('order_date',$year)
            ->groupByRaw('month(order_date)')->get();
        $count=sells::selectRaw('month(order_date) month,count(*) count')
            ->WhereYear('order_date',$year)
            ->groupByRaw('month(order_date)')->get();
        $maincount=main::selectRaw('month(sul_date) month,count(*) count')
            ->WhereYear('sul_date',$year)
            ->groupByRaw('month(sul_date)')->get();
        $maintot=main::selectRaw('month(sul_date) month,round(sum(sul),0) tot')
            ->WhereYear('sul_date',$year)
            ->groupByRaw('month(sul_date)')->get();
        $kstcount=kst_trans::selectRaw('month(ksm_date) month,count(*) count')
            ->WhereYear('ksm_date',$year)
            ->WhereYear('ksm','!=',0)
            ->groupByRaw('month(ksm_date)')->get();
        $ksttot=kst_trans::selectRaw('month(ksm_date) month,round(sum(ksm),0) tot')
            ->WhereYear('ksm_date',$year)
            ->WhereYear('ksm','!=',0)
            ->groupByRaw('month(ksm_date)')->get();
        $rebhtot=sells::selectRaw('month(order_date) month,round(sum(rebh),0) tot')
          ->WhereYear('order_date',$year)
          ->groupByRaw('month(order_date)')->get();
        $rebhyear=sells::selectRaw('year(order_date) year,round(sum(rebh),0) tot')
        ->WhereYear('order_date','>=',$year-4)
        ->WhereYear('order_date','<=',$year)
          ->orderbyRaw('year(order_date)')
          ->groupByRaw('year(order_date)')->get();


        if (count($tot)==0) $data=['0',];
        if (count($count)==0) $data2=['0',];
        if (count($maintot)==0) $data5=['0',];
        if (count($maincount)==0) $data3=['0',];
        if (count($ksttot)==0) $data6=['0',];
        if (count($kstcount)==0) $data4=['0',];
        if (count($rebhtot)==0) $rebh_tot_data=['0',];
      if (count($rebhyear)==0) {$rebh_year_data=['0',];$this->years=['0',];};

        foreach ($tot as $item) {
            $data[] =$item->tot;

        }

        $this->labels= ['1', '2', '3', '4', '5', '6','7','8','9','10','11','12'];
        $this->dataset = [
            [

                'label' => 'اجمالي المبيعات الشهرية',

                'backgroundColor'=> $this->backgroundColor,



                'data' => $data,
            ],
        ];

        foreach ($count as $item) {
            $data2[] =$item->count;

        }
        $this->sellcount = [
            [
                'label' => 'عدد الفواتير المباعة شهريا',
                'backgroundColor'=> $this->backgroundColor,
                'borderColor' => 'rgba(15,64,97,255)',
                'data' => $data2,
            ],
        ];
        foreach ($maintot as $item) {
            $data5[] =$item->tot;

        }
        $this->maintot = [
            [
                'label' => 'اجمالي العقود شهريا',
                'backgroundColor'=> $this->backgroundColor,
                'borderColor' => 'rgba(15,64,97,255)',
                'data' => $data5,
            ],
        ];
        foreach ($maincount as $item) {
            $data3[] =$item->count;

        }
        $this->maincount = [
            [
                'label' => 'عدد العقود شهريا',
                'backgroundColor'=> $this->backgroundColor,
                'borderColor' => 'rgba(15,64,97,255)',
                'data' => $data3,
            ],
        ];
        foreach ($kstcount as $item) {
            $data4[] =$item->count;

        }
        $this->kstcount = [
            [
                'label' => 'عدد الاقساط المحصلة شهريا',
                'backgroundColor'=> $this->backgroundColor,
                'borderColor' => 'rgba(15,64,97,255)',
                'data' => $data4,
            ],
        ];

        foreach ($ksttot as $item) {
            $data6[] =$item->tot;

        }
        $this->ksttot = [
            [
                'label' => 'اجمالي الاقساط المحصلة شهريا',
                'backgroundColor'=> $this->backgroundColor,
                'borderColor' => 'rgba(15,64,97,255)',
                'data' => $data6,
            ],
        ];

      foreach ($rebhtot as $item) {
        $rebh_tot_data[] =$item->tot;

      }
      $this->rebhtot = [
        [
          'label' => 'اجمالي الأرباح شهريا',
          'backgroundColor'=> $this->backgroundColor,
          'borderColor' => 'rgba(15,64,97,255)',
          'data' => $rebh_tot_data,
        ],
      ];
      foreach ($rebhyear as $item) {
        $rebh_year_data[] =$item->tot;
        $this->years[] =$item->year;

      }

      $this->rebhyear = [
        [
          'label' => 'اجمالي الأرباح أخر خمس سنوات',
          'backgroundColor'=> $this->backgroundColor,
          'borderColor' => 'rgba(15,64,97,255)',
          'data' => $rebh_year_data,
        ],
      ];
      if ($this->ShowDailyTot)
        $DailyTot =DB::connection(Auth()->user()->company)->table('Daily_Tot')
            ->where('val','!=',0)->get();
      else  $DailyTot = [];
        return view('livewire.admin.welcome-page',[

            'users'=>  DB::table('users')
                ->where('company',Auth()->user()->company)
                ->paginate(8),
          'DailyTot'=>$DailyTot,
        ]);
    }
}

