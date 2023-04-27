<?php

namespace App\Http\Livewire\Admin;

use App\Models\Customers;
use App\Models\sell\sells;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
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


   public function mount(){
     $this->Company=Auth::user()->company;
     $res=Customers::where('company',$this->Company)->first();
     $this->CompanyName=$res->CompanyName;
     $this->CompanyNameSuffix=$res->CompanyNameSuffix;



   }
    private function getData()
    {
        $data = [];
        for ($i = 0; $i < count($this->getLabels()); $i++) {
            $data[] = rand(10, 100);
        }
        return $data;
    }
    private function getLabels()
    {
        $labels = [];
        for ($i = 0; $i < 12; $i++) {
            $labels[] = now()->subMonths($i)->format('M');
        }
        return $labels;
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
        $jan='1';$janVal=0;$jancount=0; $feb='2';$febVal=0;$febcount=0; $mar='3';$marVal=0;$marcount=0;
        $apr='4';$aprVal=0;$aprcount=0; $may='5';$mayVal=0;$maycount=0; $jun='6';$junVal=0;$juncount=0;
        $jul='7';$julVal=0;$julcount=0;  $aug='8';$augVal=0;$augcount=0;$sep='9';$sepVal=0;$sepcount=0;
        $oct='10';$octVal=0;$octcount=0; $nov='11';$novVal=0;$novcount=0;  $dec='12';$decVal=0;$deccount=0;
        foreach ($tot as $item) {
            switch ($item->month) {
                case 1: $janVal=$item->tot; $data[] =$janVal; break;
                case 2: $febVal=$item->tot; $data[] =$febVal; break;
                case 3: $marVal=$item->tot; $data[] =$marVal;break;
                case 4: $aprVal=$item->tot; $data[] =$aprVal;break;
                case 5: $mayVal=$item->tot; $data[] =$mayVal;break;
                case 6: $junVal=$item->tot; $data[] =$junVal;break;
                case 7: $julVal=$item->tot; $data[] =$julVal;break;
                case 8: $augVal=$item->tot; $data[] =$augVal;break;
                case 9: $sepVal=$item->tot; $data[] =$sepVal;break;
                case 10: $octVal=$item->tot; $data[] =$octVal;break;
                case 11: $novVal=$item->tot; $data[] =$novVal;break;
                case 12: $decVal=$item->tot; $data[] =$decVal;break;
            }
        }
        //$this->labels[] = $this->getLabels();
        $this->labels= ['1', '2', '3', '4', '5', '6','7','8','9','10','11','12'];
        $this->dataset = [
            [
                'label' => 'اجمالي المبيعات',
                'backgroundColor' => 'rgba(15,64,97,255)',
                'borderColor' => 'rgba(15,64,97,255)',
                'data' => $data,
            ],
        ];
        foreach ($count as $item) {
            switch ($item->month) {
                case 1: $jancount=$item->count; break;
                case 2: $febcount=$item->count; break;
                case 3: $marcount=$item->count; break;
                case 4: $aprcount=$item->count; break;
                case 5: $maycount=$item->count; break;
                case 6: $juncount=$item->count; break;
                case 7: $julcount=$item->count; break;
                case 8: $augcount=$item->count; break;
                case 9: $sepcount=$item->count; break;
                case 10: $octcount=$item->count; break;
                case 11: $novcount=$item->count; break;
                case 12: $deccount=$item->count; break;
            }
        }

        $columnChartModelTot =
            (new ColumnChartModel())

                ->withoutLegend()
                ->setColumnWidth(20)
                ->addColumn($jan, $janVal, '#f6ad55')
                ->addColumn($feb, $febVal, '#fc8181')
                ->addColumn($mar, $marVal, '#90cdf4')
                ->addColumn($apr, $aprVal, '#257a1d')
                ->addColumn($may, $mayVal, '#242322')
                ->addColumn($jun, $junVal, '#9e7039')
                ->addColumn($jul, $julVal, '#baed11')
                ->addColumn($aug, $augVal, '#030754')
                ->addColumn($sep, $sepVal, '#a18e13')
                ->addColumn($oct, $octVal, '#d1afed')
                ->addColumn($nov, $novVal, '#750858')
                ->addColumn($dec, $decVal, '#e30b25')
        ;
        $columnChartModelCount =
            (new ColumnChartModel())

                ->withoutLegend()
                ->setColumnWidth(20)
                ->addColumn($jan, $jancount, '#f6ad55')
                ->addColumn($feb, $febcount, '#fc8181')
                ->addColumn($mar, $marcount, '#90cdf4')
                ->addColumn($apr, $aprcount, '#257a1d')
                ->addColumn($may, $maycount, '#242322')
                ->addColumn($jun, $juncount, '#9e7039')
                ->addColumn($jul, $julcount, '#baed11')
                ->addColumn($aug, $augcount, '#030754')
                ->addColumn($sep, $sepcount, '#a18e13')
                ->addColumn($oct, $octcount, '#d1afed')
                ->addColumn($nov, $novcount, '#750858')
                ->addColumn($dec, $deccount, '#e30b25')
        ;
      if ($this->ShowDailyTot)
        $DailyTot =DB::connection(Auth()->user()->company)->table('Daily_Tot')
            ->where('val','!=',0)->get();
      else  $DailyTot = [];
        return view('livewire.admin.welcome-page',[
            'columnChartModelTot'=>$columnChartModelTot,
            'columnChartModelCount'=>$columnChartModelCount,
            'users'=>  DB::table('users')
                ->where('company',Auth()->user()->company)
                ->paginate(8),
          'DailyTot'=>$DailyTot,
        ]);
    }
}
