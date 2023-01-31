<?php

namespace App\Http\Livewire\Bank;

use App\Models\bank\bank;
use App\Models\bank\BankRatio;
use App\Models\bank\BankTajmeehy;
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
   $first=DB::connection(Auth()->user()->company)
     ->table('main')
     ->join('sells','main.order_no','=','sells.order_no')
     ->join('kst_trans','main.no','=','kst_trans.no')
     ->when($this->R=='R',function ($q) {
       return $q->selectRaw('bank,1 as place_type,place_no,sum(kst_trans.ksm) as tot_kst,sum(kst_trans.ksm) * ? /100 as tot_ratio',[$this->V]) ;     })
     ->when($this->R=='V',function ($q) {
       return $q->selectRaw('bank,1 as place_type,place_no,sum(kst_trans.ksm) as tot_kst,count(*) * ? as tot_ratio',[$this->V]) ;     })


     ->groupBy('bank','place_no')
     ->where('bank',$this->bank_no)
     ->where('sells.sell_type','=',1)
     ->whereYear('kst_trans.ksm_date',$this->year)
     ->whereMonth('kst_trans.ksm_date',$this->month)
     ->where('kst_trans.ksm','>',0);
    $second=DB::connection(Auth()->user()->company)
      ->table('main')
      ->join('sells','main.order_no','=','sells.order_no')
      ->join('kst_trans','main.no','=','kst_trans.no')
      ->when($this->R=='R',function ($q) {
        return $q->selectRaw('bank,1 as place_type,place_no,sum(kst_trans.ksm) as tot_kst,sum(kst_trans.ksm) * ? /100 as tot_ratio',[$this->V]) ;     })
      ->when($this->R=='V',function ($q) {
        return $q->selectRaw('bank,1 as place_type,place_no,sum(kst_trans.ksm) as tot_kst,count(*) * ? as tot_ratio',[$this->V]) ;     })

      ->groupBy('bank','place_no')
      ->where('bank',$this->bank_no)
      ->where('sells.sell_type','=',2)
      ->whereYear('kst_trans.ksm_date',$this->year)
      ->whereMonth('kst_trans.ksm_date',$this->month)
      ->where('kst_trans.ksm','>',0)
      ->union($first)
      ->get();
    if ($second){
      DB::connection(Auth()->user()->company)->beginTransaction();
      try {
        BankRatio::on(Auth()->user()->company)
          ->where('bank',$this->bank_no)
          ->where('Y',$this->year)
          ->where('M',$this->month)
          ->delete();
      for ($i=0;$i<count($second);$i++){
        BankRatio::on(Auth()->user()->company)->insert([
          'bank'=>$this->bank_no,
          'place'=>$second[$i]->place_no,
          'place_type'=>$second[$i]->place_type,
          'Y'=>$this->year,
          'M'=>$this->month,
          'R'=>$this->R,
          'V'=>$this->V,
          'tot_kst'=>$second[$i]->tot_kst,
          'tot_ratio'=>$second[$i]->tot_ratio,
        ]);
      }
        DB::connection(Auth()->user()->company)->commit();
        $this->dispatchBrowserEvent('mmsg', 'تمت عملية الاحتساب');

      } catch (\Exception $e) {
        info($e);
        DB::connection(Auth()->user()->company)->rollback();
        $this->dispatchBrowserEvent('mmsg', 'حدث خطأ');
      }
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
