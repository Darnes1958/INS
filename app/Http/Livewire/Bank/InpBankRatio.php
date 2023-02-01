<?php

namespace App\Http\Livewire\Bank;

use App\Models\bank\bank;
use App\Models\bank\BankRatio;
use App\Models\bank\BankTajmeehy;
use App\Models\masr\MasCenters;
use App\Models\masr\Masrofat;
use App\Models\masr\MasTypeDetails;
use App\Models\masr\MasTypes;
use Carbon\Traits\Date;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class InpBankRatio extends Component
{
  public $bank_no;
  public $bank_name;
  public $TajNo;
  public $R;
  public $V;
  public $year;
  public $month;

  protected $listeners = [
    'TakeBank',
  ];
  public function TakeBank($bank_no){


    $res=bank::on(Auth::user()->company)->find($bank_no);
    $this->bank_name=$res->bank_name;
    $this->TajNo=$res->bank_tajmeeh;
    if (BankTajmeehy::on(Auth()->user()->company)->find($this->TajNo)->ratio_type==null){
        $this->bank_no=null;
      $this->dispatchBrowserEvent('mmsg','لم يتم ادخال الاعدادات للمصرف التجميعي');
      return false;
    }
    $this->bank_no=$bank_no;
  }
  protected function rules()
  {
    Config::set('database.connections.other.database', Auth::user()->company);
    return [
      'bank_no' => ['required','integer','gt:0', 'exists:other.bank,bank_no'],
      'year' =>['required','integer','gt:0', ],
      'month' =>['required','integer','gt:0', ],
    ];
  }
  protected $messages = [
    'required' => 'لا يجوز ترك فراغ',
    'exists' => 'هذا الرقم غير مخزون مسبقا',
  ];
  public function Do(){
   $this->validate();
   $this->TajNo=bank::on(Auth()->user()->company)->find($this->bank_no)->bank_tajmeeh;
   $res=DB::connection(Auth()->user()->company)->table('BankTajmeehy')->where('TajNo',$this->TajNo)->first();
   $this->R=$res->ratio_type;
   $this->V=$res->ratio_val;
    DB::connection(Auth()->user()->company)->beginTransaction();
    try {
      Masrofat::on(Auth()->user()->company)->whereIn('MasNo', function($q){
        $q->select('MasNo')->from('BankRatio')
          ->where('bank', $this->bank_no)
          ->where('Y', $this->year)
          ->where('M', $this->month);})->delete();

      BankRatio::on(Auth()->user()->company)
        ->where('bank', $this->bank_no)
        ->where('Y', $this->year)
        ->where('M', $this->month)
        ->delete();

   $first=DB::connection(Auth()->user()->company)
     ->table('main')
     ->join('sells','main.order_no','=','sells.order_no')
     ->join('kst_trans','main.no','=','kst_trans.no')
     ->when($this->R=='R',function ($q) {
       return $q->selectRaw('bank,sell_type ,place_no
       ,count(*) as kst_count
       ,sum(kst_trans.ksm) as tot_kst
       ,sum(kst_trans.ksm) * ? /100 as tot_ratio',[$this->V]) ;     })
     ->when($this->R=='V',function ($q) {
       return $q->selectRaw('bank,sell_type,place_no
       ,count(*) as kst_count
       ,sum(kst_trans.ksm) as tot_kst
       ,count(*) * ? as tot_ratio',[$this->V]) ;     })
     ->groupBy('bank','place_no','sell_type')
     ->where('bank',$this->bank_no)

     ->whereYear('kst_trans.ksm_date',$this->year)
     ->whereMonth('kst_trans.ksm_date',$this->month)
     ->where('kst_trans.ksm','>',0)
      ->get();
    if ($first) {
      for ($i = 0; $i < count($first); $i++) {
        BankRatio::on(Auth()->user()->company)->insert([
          'bank' => $this->bank_no,
          'place' => $first[$i]->place_no,
          'place_type' => $first[$i]->sell_type,
          'Y' => $this->year,
          'M' => $this->month,
          'R' => $this->R,
          'V' => $this->V,
          'kst_count' => $first[$i]->kst_count,
          'tot_kst' => $first[$i]->tot_kst,
          'tot_ratio' => $first[$i]->tot_ratio,
        ]);
      }
    }

        $second=DB::connection(Auth()->user()->company)
          ->table('MainArc')
          ->join('sells','MainArc.order_no','=','sells.order_no')
          ->join('transarc','MainArc.no','=','transarc.no')
          ->when($this->R=='R',function ($q) {
            return $q->selectRaw('bank,sell_type ,place_no
       ,count(*) as kst_count
       ,sum(transarc.ksm) as tot_kst
       ,sum(transarc.ksm) * ? /100 as tot_ratio',[$this->V]) ;     })
          ->when($this->R=='V',function ($q) {
            return $q->selectRaw('bank,sell_type,place_no
       ,count(*) as kst_count
       ,sum(transarc.ksm) as tot_kst
       ,count(*) * ? as tot_ratio',[$this->V]) ;     })
          ->groupBy('bank','place_no','sell_type')
          ->where('bank',$this->bank_no)

          ->whereYear('transarc.ksm_date',$this->year)
          ->whereMonth('transarc.ksm_date',$this->month)
          ->where('transarc.ksm','>',0)
          ->get();
        if ($second) {

          for ($i = 0; $i < count($second); $i++) {
            $res=BankRatio::on(Auth()->user()->company)
              ->where('bank', $this->bank_no)
              ->where('Y', $this->year)
              ->where('M', $this->month)
              ->where('place_type', $second[$i]->sell_type)
              ->where('place', $second[$i]->place_no)
              ->first();
            if ($res) {
              $res2 = BankRatio::on(Auth()->user()->company)->find($res->id);

              $res2->kst_count += $second[$i]->kst_count;
              $res2->tot_kst += $second[$i]->tot_kst;
              $res2->tot_ratio += $second[$i]->tot_ratio;
              $res2->save();
             }
            else
            BankRatio::on(Auth()->user()->company)->insert([
                  'bank' => $this->bank_no,
                  'place' => $second[$i]->place_no,
                  'place_type' => $second[$i]->sell_type,
                  'Y' => $this->year,
                  'M' => $this->month,
                  'R' => $this->R,
                  'V' => $this->V,
                  'kst_count' => $second[$i]->kst_count,
                  'tot_kst' => $second[$i]->tot_kst,
                  'tot_ratio' => $second[$i]->tot_ratio,
                ]);
          }
        }

        if (! MasTypes::on(Auth()->user()->company)->where('MasTypeName','عمولة مصارف')->exists()){
          $MasTypeNo=MasTypes::on(Auth()->user()->company)->max('MasTypeNo')+1;
          MasTypes::on(Auth()->user()->company)->insert([
            'MasTypeNo'=>$MasTypeNo,
            'MasTypeName'=>'عمولة مصارف',
          ]);}
          $MasTypeNo=MasTypes::on(Auth()->user()->company)->where('MasTypeName','عمولة مصارف')->first()->MasTypeNo;
          if ( ! MasTypeDetails::on(Auth()->user()->company)
            ->where('MasType',$MasTypeNo)
            ->where('acc_no',$this->bank_no)
            ->exists()){
            $DetailNo=MasTypeDetails::on(Auth()->user()->company)->max('DetailNo')+1;
            MasTypeDetails::on(Auth()->user()->company)->insert([
              'DetailNo'=>$DetailNo,
              'DetailName'=>$this->bank_name,
              'MasType'=>$MasTypeNo,
              'acc_no'=>$this->bank_no,
            ]);}
          else {$DetailNo=MasTypeDetails::on(Auth()->user()->company)
            ->where('MasType',$MasTypeNo)
            ->where('acc_no',$this->bank_no)->first()->DetailNo;}

          $res=BankRatio::on(Auth()->user()->company)
            ->where('bank',$this->bank_no)
            ->where('Y',$this->year)
            ->where('M',$this->month)
            ->get();
          foreach ($res as $key=>$item){
            if ($item->place_type==1) $pt=2; else $pt=1;
            $CenterNo=MasCenters::on(Auth()->user()->company)
              ->where('CenterWho',$pt)
              ->where('WhoID',$item->place)->first()->CenterNo;

              $TheId=DB::connection(Auth()->user()->company)->table('Masrofat')->insertGetId([
                'MasType'=>$MasTypeNo,
                'MasTypeDetail'=>$DetailNo,
                'MasCenter'=>$CenterNo,
                'Val'=>$item->tot_ratio,
                'MasDate'=>date('Y-m-d'),
                'Notes'=>'عمولة مصارف',
                'emp'=>Auth()->user()->empno,
              ]);
              BankRatio::on(Auth()->user()->company)->find($item->id)->update(['MasNo'=>$TheId]);
            }



        DB::connection(Auth()->user()->company)->commit();

        $this->dispatchBrowserEvent('mmsg', 'تمت عملية الاحتساب');

      } catch (\Exception $e) {
          info($e);
        DB::connection(Auth()->user()->company)->rollback();
        $this->dispatchBrowserEvent('mmsg', 'حدث خطأ');
      }
    }



    public function render()
    {
        return view('livewire.bank.inp-bank-ratio',[
          'years'=>DB::connection(Auth()->user()->company)->table('main')
            ->selectRaw('distinct year(sul_date) as year')
            ->orderBy('year')
            ->get(),
          'months'=>DB::connection(Auth()->user()->company)->table('main')
            ->selectRaw('distinct month(sul_date) as month  ')
            ->whereYear('sul_date',$this->year)
            ->orderBy('month')
            ->get()
        ]);
    }
}
