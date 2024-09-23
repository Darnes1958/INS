<?php

namespace App\Http\Livewire\Admin;

use App\Models\aksat\kst_trans;
use App\Models\aksat\main;
use App\Models\buy\buy_tran;
use App\Models\buy\buys;
use App\Models\Customers;
use App\Models\OverTar\over_kst;
use App\Models\stores\items;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Jenssegers\Agent\Agent;
use DateTime;

class AdminPage extends Component
{
public kst_trans $KstTrans;
protected $rules = [
 'KstTrans.kst'=>'required',
 'KstTrans.kst_date'=>'required',
];
public $text;


public $database='Elmaleh';
public $ThedatabaseListIsSelectd;

  public function updatedThedatabaseListIsSelectd(){
    $this->ThedatabaseListIsSelectd=0;
    User::find(auth()->user()->id)->update(['company'=>$this->database]);

    $this->emitTo('admin.empno-select','comp',$this->database);
    $this->redirect('/home');
  }
  public function PublicFun(){
      return ;
      //  $this->KstranToOver();
      //  return;
  //    $this->EmptyKstranRecord();
  //    return;

     $res=kst_trans::orderBy('no','asc')->orderBy('kst_date','asc')->get();
     $no=-1;
     $ser=0;
     foreach ($res as $item) {
         if ($item->no==$no){
             $ser++;
         }else {
             $no=$item->no;
             $ser=1;
         }
         $month = date('m', strtotime($item->kst_date));
         $year = date('Y', strtotime($item->kst_date));
         $date = $year . $month . '28';
         $date = DateTime::createFromFormat('Ymd', $date);
         $date = $date->format('Y-m-d');

         kst_trans::where('wrec_no',$item->wrec_no)->update([
             'ser'=>$ser,'kst_date'=>$date,
         ]);


     }
  }
  public function EmptyKstranRecord(){
      $mains=main::where('raseed','>',0)->get();
      foreach($mains as $main) {
        $sul_date=$main->sul_date;
        $kstcount=$main->kst_count;
        $kst=$main->kst;
        $no=$main->no;
          $day = date('d', strtotime($sul_date));
          $month = date('m', strtotime($sul_date));
          $year = date('Y', strtotime($sul_date));
          $date = $year . $month . '28';
          $date = DateTime::createFromFormat('Ymd', $date);
          $date = $date->format('Y-m-d');
          if ($day > 24) {
              $date = date('Y-m-d', strtotime($date . "+1 month"));
          }
          $kst_trans= kst_trans::where('no',$no)->orderBy('ser','asc')->get();
          $count=$kst_trans->count();
          $max=$kst_trans->max('ser');
          if ($count < $kstcount) {
              $ser=$count+1;
              if ($count!=0) $date=date('Y-m-d',
                  strtotime($kst_trans->where('ser',$max)->first()->kst_date . "+1 month"));
              for ($x = $ser; $x <= $kstcount; $x++){
                  kst_trans::insert([
                      'ser'=>$x,
                      'no'=>$no,
                      'kst_date'=>$date,
                      'ksm_type'=>2,
                      'chk_no'=>0,
                      'kst'=>$kst,
                      'ksm_date'=>null,
                      'ksm'=>0,
                      'emp'=>1,
                      'h_no'=>0,
                      'kst_notes'=>null,
                      'inp_date'=>date('Y-m-d'),
                  ]);

                  $date = date('Y-m-d', strtotime($date . "+1 month"));
              }

          }


      }

  }
    public function KstranToOver(){
        $mains=main::where('raseed','<',0)->get();
        foreach($mains as $main) {
            $kst=$main->kst;
            $no=$main->no;
            $raseed=abs($main->raseed);
            if ($main->raseed % $kst !=0) continue;
            $kst_trans= kst_trans::where('no',$no)
                ->where('ksm','!=',0)
                ->where('ksm',$kst)
                ->orderBy('ser','desc')->get();
            foreach ($kst_trans as $kst) {
                over_kst::insert([
                    'no'=>$no,'name'=>$main->name,'bank'=>$main->bank,'acc'=>$main->acc,'kst'=>$kst->ksm,
                    'tar_type'=>1,'tar_date'=>$kst->ksm_date,'letters'=>0,'emp'=>1,
                    'h_no'=>0,'inp_date'=>$kst->ksm_date,
                ]);
                $raseed-=$kst->ksm;
                $kst->ksm=0;
                $kst->ksm_date=null;
                $kst->kst_notes=null;
                $kst->save();
                if ($raseed==0) break;
            }
            $sul_pay=kst_trans::where('no',$main->no)->where('ksm','!=',null)->sum('ksm');
            $main->sul_pay=$sul_pay;
            $main->raseed=$main->sul-$sul_pay;
            $main->save();
        }

    }
  protected function FalseAll(){
      $this->emitTo('admin.manage-roles','show',False);
      $this->emitTo('admin.inp-user','show',False);
      $this->emitTo('admin.inp-company','show',False);
      $this->emitTo('admin.rep-company','show',False);
      $this->emitTo('admin.rep-users','show',False);
      $this->emitTo('admin.rep-old-roles','show',false);
      $this->emitTo('admin.rep-roles','show',false);
      $this->emitTo('admin.from-excel','show',false);
      $this->emitTo('admin.to-hafitha','show',false);
      $this->emitTo('admin.from-excel2','show',false);
      $this->emitTo('admin.rep-log-user','show',False);
      $this->emitTo('admin.kaema','show',false);
      $this->emitTo('admin.mahjoza','show',false);
  }
  public function InpUser(){

    $this->FalseAll();
    $this->emitTo('admin.inp-user','show',True);
  }
  public function InpCompany(){
    $this->FalseAll();
    $this->emitTo('admin.inp-company','show',True);
  }
  public function RepCompany(){
    $this->FalseAll();
    $this->emitTo('admin.rep-company','show',True);
  }
    public function RepUsers(){
        $this->FalseAll();
        $this->emitTo('admin.rep-users','show',True);
    }
    public function InpRole(){
        $this->FalseAll();
        $this->emitTo('admin.manage-roles','show',True);
        $this->emitTo('admin.rep-old-roles','show',True);
    }
    public function RepRole(){
        $this->FalseAll();

        $this->emitTo('admin.rep-roles','show',True);
    }
  public function FromExcel(){
    $this->FalseAll();

    $this->emitTo('admin.from-excel','show',True);
  }
  public function ToHafitha(){
    $this->FalseAll();

    $this->emitTo('admin.to-hafitha','show',True);
  }
  public function FromExcel2(){
    $this->FalseAll();
    $this->emitTo('admin.from-excel2','show',True);
  }
    public function LogUser(){
        $this->FalseAll();
        $this->emitTo('admin.rep-log-user','show',True);
    }
  public function Kaema(){
    $this->FalseAll();

    $this->emitTo('admin.kaema','show',True);
  }
    public function Mahjoza(){
        $this->FalseAll();

        $this->emitTo('admin.mahjoza','show',True);
    }


    public function Clickme(){
        $agent = new Agent();
        $this->text = $agent->platform();
    }




    public function render()
    {
        return view('livewire.admin.admin-page');
    }
}
