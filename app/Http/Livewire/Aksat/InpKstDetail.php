<?php

namespace App\Http\Livewire\Aksat;

use App\Models\aksat\kst_trans;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Rule;
use League\CommonMark\Extension\CommonMark\Parser\Inline\OpenBracketParser;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class InpKstDetail extends Component
{
  public $D_no;
  public $D_bank;
  public $D_acc;
  public $name;
  public $sul_tot;
  public $dofa;
  public $sul;
  public $sul_pay;
  public $raseed;
  public $kst_count;
  public $kst;
  public $notes;
  public $ksm_date;
  public $ksm;


  public $OpenKstDetail;

  protected $listeners = [
    'nofound','NoAtUpdate','bankfound','GoResetKstDetail',
  ];
  public function GoResetKstDetail(){
    $this->ResetKstDetail();

  }

  public function SaveSuccess(){
    $this->ResetKstDetail();
  }
  public function nofound($res){
   $this->FillKstDetail($res);
   $this->OpenKstDetail=true;
  }
  public function NoAtUpdate($res){
    $this->FillKstDetail($res);
  }
  public function FillKstDetail($res){
    $this->D_no=$res['no'];
    $this->D_bank=$res['bank'];
    $this->D_acc=$res['acc'];
    $this->name=$res['name'];
    $this->sul_tot=$res['sul_tot'];
    $this->dofa=$res['dofa'];
    $this->sul=$res['sul'];
    $this->sul_pay=$res['sul_pay'];
    $this->raseed=$res['raseed'];
    $this->kst_count=$res['kst_count'];
    $this->kst=$res['kst'];
    $this->ksm=$res['kst'];

  }

  public function bankfound(){
   $this->ResetKstDetail();
  }
function ResetKstDetail (){
  $this->name='';
  $this->sul_tot='';
  $this->dofa='';
  $this->sul='';
  $this->sul_pay='';
  $this->raseed='';
  $this->kst_count='';
  $this->kst='';
  $this->ksm='';

  $this->OpenKstDetail=false;

}
  public function ChkKsm(){
    $this->validate();
    $ksm=$this->ksm;
    $over=0;

    if ($this->raseed<=0) {
      session()->flash('message', 'خصم بالفائض');
      $ksm=0;
      $over=$this->ksm;
    }

    if (($this->ksm>$this->raseed) && ($this->raseed>0)) {
      session()->flash('message', 'سيتم خصم '.$this->raseed.' , و الـ '.$this->ksm-$this->raseed.' فائض');
      $ksm=$this->raseed;
      $over=$this->ksm-$this->raseed;
    }
    Config::set('database.connections.other.database', Auth::user()->company);
    DB::connection('other')->beginTransaction();
    try {
        if ($ksm!=0){
          $results=kst_trans::where('no',$this->D_no)->where(function ($query) {
            $query->where('ksm', '=', null)
              ->orWhere('ksm', '=', 0);
          })->min('ser');
          $ser= empty($results)? 0 : $results;

            if ($ser!=0) {
              DB::connection('other')->table('kst_trans')->where('no',$this->D_no)->where('ser',$ser)->update([
                'ksm'=>$ksm,
                'ksm_date'=>$this->ksm_date,
                'ksm_type'=>2,
                'inp_date'=>date('Y-m-d'),
                'kst_notes'=>$this->notes,
                'emp'=>auth::user()->empno,
              ]);

            } else
            {
             $max=(kst_trans::where('no',$this->D_no)->max('ser'))+1;

              DB::connection('other')->table('kst_trans')->insert([
                'ser'=>$max,
                'no'=>$this->D_no,
                'kst_date'=>$this->ksm_date,
                'ksm_type'=>2,
                'chk_no'=>0,
                'kst'=>$this->kst,
                'ksm_date'=>$this->ksm_date,
                'ksm'=>$ksm,
                'kst_notes'=>$this->notes,
                'inp_date'=>date('Y-m-d'),
                'emp'=>auth::user()->empno,
              ]);
             }

          }
         if ($over!=0) {

          DB::connection('other')->table('over_kst')->insert([
            'no'=>$this->D_no,
            'name'=>$this->name,
            'bank'=>$this->D_bank,
            'acc'=>$this->D_acc,
            'kst'=>$over,
            'tar_type'=>1,
            'tar_date'=>$this->ksm_date,
            'letters'=>0,
            'emp'=>auth::user()->empno,
          ]);
          }

          DB::connection('other')->table('main')->where('no',$this->D_no)->update([
            'sul_pay'=>$this->sul_pay+$ksm,
            'raseed'=>$this->raseed-$ksm,
          ]);

          DB::connection('other')->commit();

          $this->ResetKstDetail();
          $this->emitTo('tools.my-table','refreshComponent');
          $this->emit('ksthead_goto','no');


        } catch (\Exception $e) {
        DB::connection('other')->rollback();

        // something went wrong
      }
}
  protected function rules()
  {

    return [
      'ksm_date' => ['required'],
      'ksm' => ['required','numeric','gt:0'],
    ];
  }
  protected $messages = [
    'required' => 'لا يجوز ترك فراغ',

    'ksm_date.required' => 'تاريخ خطأ',

  ];

function mount(){
    $this->ResetKstDetail();
  $this->ksm_date=date('Y-m-d');

}
    public function render()
    {
        return view('livewire.aksat.inp-kst-detail');
    }
}
