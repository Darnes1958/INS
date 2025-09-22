<?php

namespace App\Http\Livewire\Aksat;

use App\Models\aksat\hafitha;
use App\Models\aksat\kst_trans;
use App\Models\aksat\main;
use App\Models\aksat\main_items;
use App\Models\aksat\MainArc;
use App\Models\aksat\place;
use App\Models\OverTar\over_kst;
use App\Models\OverTar\over_kst_a;
use App\Models\OverTar\stop_kst;
use App\Models\OverTar\tar_kst;
use App\Models\OverTar\tar_kst_before;
use App\Models\sell\rep_sell_tran;
use App\Models\sell\sell_tran;
use App\Models\sell\sells;
use App\Models\bank\bank;
use App\Models\sell\sells_view;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use DateTime;
use Livewire\WithPagination;

class InpMainTwo extends Component
{
 use WithPagination;
 protected $paginationTheme = 'bootstrap';
  public $no;
  public $acc;
  public $accToEdit;
  public $ShowEditAcc=false;
  public $name;
  public $bankno;
  public $bank_name;
  public $orderno;
  public $order_no;
  public $jeha;
  public $tot;
  public $sul_tot;
  public $sul;
    public $no_old;
    public $order_no_old;
    public $sul_tot_old;
    public $sul_pay_old;
    public $sul_old;
    public $raseed_old;
    public $kst_old;
  public $sul_date;

  public $kstcount;
  public $kst;
  public $chk_in;
  public $notes;
  public $place;
  public $dofa;
  public $ref_no;

  public $DAY_OF_KSM;


  public $OrderGet=false;
  public $BankGet=false;
  public $CountGet=false;

  public $TheBankNoListIsSelectd;
  public $TheOrderNoListIsSelectd;
  public $ThePlaceNoListIsSelectd;

  public $mainitems='rep_sell_tran';

  public function DoEditAcc(){
    $this->ShowEditAcc=true;
    $this->accToEdit=$this->acc;

    $this->emit('goto','accToEdit');

  }
  public function SaveAcc()
  {
    if ($this->accToEdit != '') {
      DB::connection(Auth()->user()->company)->beginTransaction();
      try {
        DB::connection(Auth()->user()->company)->table('main')->where('no', $this->no)->update(['acc' => $this->accToEdit,]);
        over_kst::on(Auth()->user()->company)->where('bank', $this->bankno)->where('acc',$this->acc)->update(['acc' => $this->accToEdit,]);
        over_kst_a::on(Auth()->user()->company)->where('bank', $this->bankno)->where('acc',$this->acc)->update(['acc' => $this->accToEdit,]);
        tar_kst::on(Auth()->user()->company)->where('bank', $this->bankno)->where('acc',$this->acc)->update(['acc' => $this->accToEdit,]);
        stop_kst::on(Auth()->user()->company)->where('bank', $this->bankno)->where('acc',$this->acc)->update(['acc' => $this->accToEdit,]);
        tar_kst_before::on(Auth()->user()->company)->where('bank', $this->bankno)->where('acc',$this->acc)->update(['acc' => $this->accToEdit,]);
        main::on(Auth()->user()->company)->where('jeha', $this->jeha)->update(['acc' => $this->accToEdit,]);
        MainArc::on(Auth()->user()->company)->where('jeha', $this->jeha)->update(['acc' => $this->accToEdit,]);
        DB::connection(Auth()->user()->company)->commit();
        $this->acc = $this->accToEdit;
        $this->ShowEditAcc = false;
      } catch (\Exception $e) {
        DB::connection(Auth()->user()->company)->rollback();

        $this->dispatchBrowserEvent('mmsg', 'حدث خطأ');
      }
    }
  }

  public function updatedTheBankNoListIsSelectd(){
    $this->TheBankNoListIsSelectd=0;
    $this->ChkBankAndGo();
  }
  public function updatedTheOrderNoListIsSelectd(){
    $this->TheOrderNoListIsSelectd=0;
    $this->ChkOrderAndGo();
  }
  public function updatedThePlaceNoListIsSelectd(){
    $this->ThePlaceNoListIsSelectd=0;
    $this->ChkPlaceAndGo();
  }

  function updatedOrderno(){

    $this->OrderGet=false;
    $this->BankGet=false;
    $this->CountGet=false;
    $this->order_no=$this->orderno;
  }
  public function updatedBankno(){
    $this->BankGet=false;
    $this->acc='';
  }
  public function updatedKstcount(){
    $this->CountGet=false;
    $this->kst='';

  }


  public function ChkNoAndGo(){

   if ($this->no){

    $res=main::on(Auth()->user()->company)->where('no',$this->no)->first();
    if ($res){$this->dispatchBrowserEvent('mmsg', 'هذا الرقم مخزون مسبقا');$this->emit('goto','no');}
    else {$this->emit('goto','sul_date');};}
  }
  public function ChkOrderAndGo(){
   if (!$this->order_no) return;
   Config::set('database.connections.other.database', Auth::user()->company);
   $res=sells_view::on(Auth()->user()->company)->where('order_no',$this->orderno)
     ->where('price_type',2)
     ->whereNotIn('order_no', function($q){
       $q->select('order_no')->from('main');
     })
     ->whereNotIn('order_no', function($q){
       $q->select('order_no')->from('MainArc');
     })
     ->whereNotIn('order_no', function($q){
       $q->select('order_no')->from('MainRes');
     })
     ->first();

   if ($res){

     $res_old=main::on(Auth()->user()->company)->where('jeha',$res->jeha)->first();
     if (! $res_old){
         $this->dispatchBrowserEvent('mmsg', 'لا يوجد عقد سابق لهذا الزبون ليتم ضمه ');
         return false;
     }
       if (hafitha::where('bank',$res_old->bank)->where('hafitha_state',0)->exists()) {
           {$this->dispatchBrowserEvent('mmsg', 'توجد حافظة غير مرحلة لهذا المصرف .. لا يجوز ادخال او ضم عقود !'); return(false);}
       }
     $this->no_old=$res_old->no;
     $this->order_no_old=$res_old->order_no;
     $this->sul_tot_old=$res_old->sul_tot;
     $this->raseed_old=$res_old->raseed;
     $this->sul_pay_old=$res_old->sul_pay;
     $this->sul_old=$res_old->sul;
     $this->kst_old=$res_old->kst;
     $this->bankno=$res_old->bank;
     $this->acc=$res_old->acc;
     $this->place=$res_old->place;
     $this->chk_in=$res_old->chk_in;

     $this->bank_name=bank::on(Auth()->user()->company)->find($this->bankno)->bank_name;

     $this->jeha=$res->jeha;
     $this->name=$res->jeha_name;
     $this->tot=$res->tot;
     $this->sul_tot=$res->tot+$res_old->raseed;
     $this->dofa=$res->cash;
     $this->sul=$res->not_cash+$res_old->raseed;
     $this->no=main::on(Auth()->user()->company)->max('no')+1;
     $this->OrderGet=true;
     $this->order_no=$this->orderno;
     $this->emit('goto','no');
     $this->emit('TakeOrderNo',$res->order_no,$res->jeha_name);
     $this->sul_date=date('Y-m-d');

       $this->emit('GetWhereEquelValue2',$this->order_no_old);
       $this->emit('GetWhereEquelValue',$this->order_no);

   } else {
       if (!sells_view::on(Auth()->user()->company)->where('order_no', $this->orderno)->exists())
           $this->dispatchBrowserEvent('mmsg', 'هذا الرقم غير مخزون ');
       else {
           if (sells_view::on(Auth()->user()->company)->where('order_no', $this->orderno)
               ->first()->price_type<>2)
               $this->dispatchBrowserEvent('mmsg', 'هذه الفاتورة ليسن بسعر التقسيط ');
           else
           {
               $res=main::on(Auth()->user()->company)->where('order_no', $this->orderno)->first();
               if ($res)
                   $this->dispatchBrowserEvent('mmsg', 'هذه الفاتورة سبق تقسيطها بالعقد رقم  '.$res->no);
               {
                   $res=MainArc::on(Auth()->user()->company)->where('order_no', $this->orderno)->first();
                   if ($res)
                       $this->dispatchBrowserEvent('mmsg', 'هذه الفاتورة سبق تقسيطها بغقد بالارشيف رقم  '.$res->no);
               }
           }
       }
   }
  }

  public function ChkKstCountAndGo(){
    if ($this->kstcount){
      $this->kst=$this->truncate( $this->sul/$this->kstcount);
      $this->CountGet=true;
      $this->emit('goto','kst');

    }
  }
  function truncate($val, $f="0")
  {
    if(($p = strpos($val, '.')) !== false) {
      $val = floatval(substr($val, 0, $p + 1 + $f));
    }
    return $val;
  }

  protected function rules()
  {
    Config::set('database.connections.other.database', Auth::user()->company);

    return [
      'order_no' => ['required','integer','gt:0', Rule::exists('other.sells')->where(function ($query) {
        $query->where('price_type', 2)
          ->whereNotIn('order_no', function($q){
            $q->select('order_no')->from('main');
          })
          ->whereNotIn('order_no', function($q){
            $q->select('order_no')->from('MainArc');
          })
          ->whereNotIn('order_no', function($q){
            $q->select('order_no')->from('MainRes');
          })
          ->whereIn('jeha', function($q){
              $q->select('jeha')->from('main');
          });
      })],
      'no' =>['required','integer','gt:0','unique:other.main,no','unique:other.MainArc,no'],
      'sul_date' => ['required','date'],

      'kstcount' => ['required','integer','gt:0'],
      'kst' => ['required','numeric','gt:0'],

    ];
  }
  protected $messages = [
    'exists' => 'هذا الرقم غير مخزون',
    'required' => 'لا يجوز ترك فراغ',
    'unique' => 'هذا الرقم مخزون مسبقا',

    'sul_date.required'=>'يجب ادخال تاريخ صحيح',
  ];
  public function SaveCont(){
      $this->validate();

      DB::connection(Auth()->user()->company)->beginTransaction();
      try {
          $taj_id=bank::find($this->bankno)->bank_tajmeeh;
         DB::connection(Auth()->user()->company)->table('main')->insert([
           'no'=>$this->no,'name'=>$this->name,'bank'=>$this->bankno,'acc'=>$this->acc,'sul_date'=>$this->sul_date,'sul_type'=>1,'sul_tot'=>$this->sul_tot,
           'dofa'=>$this->dofa,'sul'=>$this->sul,'kst'=>$this->kst,'kst_count'=>$this->kstcount,'sul_pay'=>0,'raseed'=>$this->sul,'order_no'=>$this->orderno,
           'jeha'=>$this->jeha,'place'=>$this->place,'notes'=>$this->notes,'chk_in'=>$this->chk_in,'chk_out'=>0,'last_order'=>$this->order_no_old,'ref_no'=>$this->ref_no,
           'emp'=>auth::user()->empno,'inp_date'=>date('Y-m-d'),'taj_id'=>$taj_id]);
         $res=sell_tran::on(Auth()->user()->company)->where('order_no',$this->orderno)->get();
         foreach ($res as $item) {
           main_items::on(Auth()->user()->company)->insert(['no'=>$this->no,'item_no'=>$item->item_no]);
         }
          $day = date('d', strtotime($this->sul_date));
          $month = date('m', strtotime($this->sul_date));
          $year = date('Y', strtotime($this->sul_date));
          $date=$year.$month.'28';
          $date = DateTime::createFromFormat('Ymd',$date);
          $date=$date->format('Y-m-d');
          if ($day>$this->DAY_OF_KSM) {$date = date('Y-m-d', strtotime($date . "+1 month"));}
          for ($i=1;$i<=$this->kstcount;$i++) {
              kst_trans::on(Auth()->user()->company)->insert([
                'ser'=>$i,
                'no'=>$this->no,
                'kst_date'=>$date,
                'ksm_type'=>2,
                'chk_no'=>0,
                'kst'=>$this->kst,
                'ksm_date'=>null,
                'ksm'=>0,
                'emp'=>auth()->user()->empno,
                'h_no'=>0,
                'kst_notes'=>null,
                'inp_date'=>date('Y-m-d'),
              ]);
              $date = date('Y-m-d', strtotime($date . "+1 month"));
          }

          $results=kst_trans::on(Auth()->user()->company)->where('no',$this->no_old)->where(function ($query) {
              $query->where('ksm', '=', null)
                  ->orWhere('ksm', '=', 0);
          })->min('ser');
          $ser= empty($results)? 0 : $results;

          if ($ser!=0) {
              DB::connection(Auth()->user()->company)->table('kst_trans')->
              where('no',$this->no_old)->where('ser',$ser)->update([
                 'ksm'=>$this->raseed_old,'ksm_date'=>$this->sul_date,'ksm_type'=>2,
                  'inp_date'=>date('Y-m-d'),'kst_notes'=>'مبلغ تم دمجه مع العقد رقم '.$this->no_old,
                  'emp'=>auth::user()->empno,]);

          } else
          {  $max=(kst_trans::on(Auth()->user()->company)->where('no',$this->no_old)->max('ser'))+1;
             DB::connection(Auth()->user()->company)->table('kst_trans')->insert([
                  'ser'=>$max,'no'=>$this->no_old,'kst_date'=>$this->sul_date,'ksm_type'=>2,'chk_no'=>0,
                  'kst'=>$this->kst_old,'ksm_date'=>$this->sul_date,'ksm'=>$this->raseed_old,
                  'kst_notes'=>'مبلغ تم دمجه مع العقد رقم '.$this->no_old,
                  'inp_date'=>date('Y-m-d'),'emp'=>auth::user()->empno,
              ]);
          }
          DB::connection(Auth()->user()->company)->table('main')->where('no',$this->no_old)->update([
              'sul_pay'=>$this->sul_old,
              'raseed'=>0,
          ]);

          $select = main::on(Auth()->user()->company)->where('no',$this->no_old)->select('no','name','bank','acc','sul_date','sul_type','sul_tot','dofa','sul',
              'kst','kst_count','sul_pay','raseed','order_no','jeha','place','notes','chk_in','chk_out','last_order','ref_no','emp','inp_date','taj_id');
          $bindings = $select->getBindings();
          $insertQuery = 'INSERT into mainarc (no,name,bank,acc,sul_date,sul_type,sul_tot,dofa,sul,kst,kst_count,sul_pay,raseed,order_no,
                                               jeha,place,notes,chk_in,chk_out,last_order,ref_no,emp,inp_date,taj_id) '. $select->toSql();
          DB::connection(Auth()->user()->company)->insert($insertQuery, $bindings);

          $select = kst_trans::on(Auth()->user()->company)->where('no',$this->no_old)->select('ser','no','kst_date','ksm_type','chk_no','kst','ksm_date','ksm','h_no','emp','kst_notes','inp_date');
          $bindings = $select->getBindings();
          $insertQuery = 'INSERT into transarc (ser,no,kst_date,ksm_type,chk_no,kst,ksm_date,ksm,h_no,emp,kst_notes,inp_date) '. $select->toSql();
          DB::connection(Auth()->user()->company)->insert($insertQuery, $bindings);

          $select = over_kst::on(Auth()->user()->company)->where('no',$this->no_old)
            ->select('no','name','bank','acc','kst','tar_type','tar_date','letters','emp','h_no','inp_date');
          $bindings = $select->getBindings();
          $insertQuery = 'INSERT into over_kst_a (no,name,bank,acc,kst,tar_type,tar_date,letters,emp,h_no,inp_date) '. $select->toSql();
          DB::connection(Auth()->user()->company)->insert($insertQuery, $bindings);

          DB::connection(Auth()->user()->company)->table('over_kst')->where('no',$this->no_old)->delete();
          DB::connection(Auth()->user()->company)->table('kst_trans')->where('no',$this->no_old)->delete();
          DB::connection(Auth()->user()->company)->table('main')->where('no',$this->no_old)->delete();
        DB::connection(Auth()->user()->company)->commit();
        $this->sul_old='';$this->sul_pay_old='';$this->sul_tot_old='';$this->no_old='';$this->bank_name='';$this->tot='';
        $this->no=''; $this->orderno='';$this->name='';$this->bankno='';$this->acc='';$this->place='';
        $this->sul='';$this->sul_tot='';$this->dofa='';$this->kst='';
        $this->kstcount='';$this->notes='';$this->ref_no='';$this->chk_in='';
        $this->emitTo('aksat.order-select','refreshComponent');
        $this->emit('goto','orderno');

      } catch (\Exception $e) {
        DB::connection(Auth()->user()->company)->rollback();
        info($e);
        $this->dispatchBrowserEvent('mmsg', 'حدث خطأ');
      }
  }
    public function render()
    {

      $res=DB::connection(Auth()->user()->company)->table('settings')->where('no',3)->first();
      $this->DAY_OF_KSM=$res->s1;
if (!$this->order_no) $this->order_no=0;
        return view('livewire.aksat.inp-main-two',[
            'RepTableOld'=>rep_sell_tran::on(Auth()->user()->company)
            ->where('order_no',$this->order_no_old)->paginate(10),
            'RepTableNew'=>rep_sell_tran::on(Auth()->user()->company)
                ->where('order_no',$this->order_no)->paginate(10),
        ]);
    }
}
