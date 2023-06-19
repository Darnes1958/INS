<?php

namespace App\Http\Livewire\Admin;

use App\Models\aksat\hafitha;
use App\Models\aksat\main;
use App\Models\aksat\MainArc;
use App\Models\bank\bank;
use App\Models\excel\FromExcelModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Str;

class ToHafitha extends Component
{
  public $Show=false;
  public $FromExcel;
  public $TajNo;



  protected $listeners = ['show'];

  public function show($show){
    $this->Show=$show;
  }
  protected function FillNoBankMainArc($FromExcel){
      $this->TajNo=$FromExcel[0]->hafitha_tajmeehy;
      foreach ($FromExcel as $item) {
          $acc=$item->acc;
          $bankcode=Str::substr($acc, 0, 3);
        if (Auth::user()->company=='BokreahAli')
        {
          if ($this->TajNo==3)
            $bank_no='061';

          else
            $bank_no='069';

        }
        else {
          if (bank::on(Auth()->user()->company)
            ->where('bank_tajmeeh', $this->TajNo)
            ->where('bank_code', $bankcode)
            ->exists()) {
            $bank_no = bank::on(Auth()->user()->company)
              ->where('bank_tajmeeh', $this->TajNo)
              ->where('bank_code', $bankcode)
              ->first()->bank_no;
          } else {
            $this->dispatchBrowserEvent('mmsg', 'كود المصرف '.$bankcode.' غير موجود ');
            return false;
          };
        }

          $no=main::on(Auth()->user()->company)
              ->where('bank',$bank_no)
              ->where('acc',$acc)->first();
          if ($no) {
              FromExcelModel::on(Auth()->user()->company)->where('acc', $acc)->update([
                  'bank' => $bank_no,
                  'no'=>$no->no,
                  'MainArcWrong'=>1,
              ]);
          } else {
              $no=MainArc::on(Auth()->user()->company)
                  ->where('bank',$bank_no)
                  ->where('acc',$acc)->first();
              if ($no) {
                  FromExcelModel::on(Auth()->user()->company)->where('acc', $acc)->update([
                      'bank' => $bank_no,
                      'no'=>$no->no,
                      'MainArcWrong'=>2,
                  ]);
              } else
              {FromExcelModel::on(Auth()->user()->company)->where('acc', $acc)->update([
                  'bank' => $bank_no,
                  'no'=>0,
                  'MainArcWrong'=>0,
              ]);
              }
          }
      }
      return true;

  }


  public function Do(){
    $this->FromExcel=FromExcelModel::on(Auth()->user()->company)->get();
    if (!$this->FillNoBankMainArc($this->FromExcel)) return false;
    $this->Do2();

  }
    public function Do2(){
        $Data=FromExcelModel::on(Auth()->user()->company)
            ->join('main','FromExcel.no','=','main.no')
            ->select('id','FromExcel.no','FromExcel.ksm','raseed')
            ->where('MainArcWrong','=',1)
            ->orderBy('no')
            ->get();
        $PrevNo=0;
        for ($i=0;$i<count($Data);$i++) {
            $id = $Data[$i]->id;
            $MainArc = $Data[$i]->MainArcWrong;
            $no = $Data[$i]->no;
            $ksm = $Data[$i]->ksm;
            $raseed = $Data[$i]->raseed;

            if ($PrevNo != $no) {$sumkst = 0;$PrevNo = $no;}
            $sumkst += $ksm;
            if ($raseed >= $sumkst) {
                    FromExcelModel::on(Auth()->user()->company)->find($id)->update([
                        'kst' => $ksm, 'kst_type' => 1, 'baky' => 0,]);
                }
            else {
                if (($sumkst - $raseed) < $ksm) {
                    FromExcelModel::on(Auth()->user()->company)->find($id)->update([
                        'kst' => $ksm-($sumkst - $raseed), 'kst_type' => 3, 'baky' => $sumkst - $raseed,]);
                 }
                else {
                    FromExcelModel::on(Auth()->user()->company)->find($id)->update([
                        'kst' => $ksm, 'kst_type' => 2, 'baky' => 0,]);
                }
            }
        }
        $Data2=FromExcelModel::on(Auth()->user()->company)
            ->where('MainArcWrong','=',2)
            ->get();
        for ($i=0;$i<count($Data2);$i++) {
           FromExcelModel::on(Auth()->user()->company)->find($Data2[$i]->id)->update([
              'kst'=>$Data2[$i]->ksm,'kst_type'=>5,'baky'=>0,]) ;}

        $Data3=FromExcelModel::on(Auth()->user()->company)
            ->where('MainArcWrong','=',0)
            ->get();
        for ($i=0;$i<count($Data3);$i++) {
                FromExcelModel::on(Auth()->user()->company)->find($Data3[$i]->id)->update([
                    'kst'=>$Data3[$i]->ksm,'kst_type'=>4,'baky'=>0,]) ;}

    }




  public function Tarheel(){
      $BankList=FromExcelModel::on(Auth()->user()->company)->select('bank','h_no')->distinct()->get();
      DB::connection(Auth()->user()->company)->beginTransaction();
      try {
      foreach ($BankList as $bank){
          $summorahel=FromExcelModel::on(Auth()->user()->company)->where('bank',$bank->bank)->where('kst_type',1)->sum('kst');
          $sumover1=FromExcelModel::on(Auth()->user()->company)->where('bank',$bank->bank)->where('kst_type',2)->sum('kst');
          $sumover2=FromExcelModel::on(Auth()->user()->company)->where('bank',$bank->bank)->where('kst_type',5)->sum('kst');
          $sumover3=FromExcelModel::on(Auth()->user()->company)->where('bank',$bank->bank)->where('kst_type',3)->sum('baky');
          if ($sumover1==null) {$sumover1=0;}
          if ($sumover2==null) {$sumover2=0;}
          if ($sumover3==null) {$sumover3=0;}
          $sumover=$sumover1+$sumover2+$sumover3;
          $sumhalfover=FromExcelModel::on(Auth()->user()->company)->where('bank',$bank->bank)->where('kst_type',3)->sum('kst');
          $sumwrong=FromExcelModel::on(Auth()->user()->company)->where('bank',$bank->bank)->where('kst_type',4)->sum('kst');
          if ($sumhalfover==null) {$sumhalfover=0;}
          if ($sumwrong==null) {$sumwrong=0;}
          $haf=hafitha::on(Auth()->user()->company)->max('hafitha_no')+1;
          DB::connection(Auth()->user()->company)->table('hafitha')->insert([
              'hafitha_no'=> $haf,
              'bank'=> $bank->bank,
              'hafitha_date'=>date('Y-m-d'),
              'hafitha_tot'=>$summorahel+$sumover+$sumhalfover+$sumwrong,
              'hafitha_state'=>0,
              'kst_morahel'=>$summorahel,
              'kst_over'=>$sumover,
              'kst_half_over'=>$sumhalfover,
              'kst_wrong'=>$sumwrong,
          ]);
          DB::connection(Auth()->user()->company)->table('pages')->insert([
              'hafitha'=>$haf,
              'page_no'=>1,
              'page_tot'=>$summorahel+$sumover+$sumhalfover+$sumwrong,
              'page_enter'=>$summorahel+$sumover+$sumhalfover+$sumwrong,
              'page_differ'=>0,
          ]);
          $NoList=FromExcelModel::on(Auth()->user()->company)
              ->where('bank', $bank->bank)->get();
          $serinhafitha=0;
          foreach ($NoList as $List) {
              $serinhafitha+=1;
              DB::connection(Auth()->user()->company)->table('hafitha_tran')->insert([
                  'hafitha'=> $haf,
                  'ser_in_hafitha'=>$serinhafitha,
                  'ser'=>0,
                  'no'=>$List->no,
                  'acc'=>$List->acc,
                  'name'=>$List->name,
                  'ksm_date'=>$List->ksm_date,
                  'kst'=>$List->kst,
                  'baky'=>$List->baky,
                  'kst_type'=>$List->kst_type,
                  'page_no'=>1,
                  'emp'=>1,
              ]);
          }
      }
          DB::connection(Auth()->user()->company)->commit();


      } catch (\Exception $e) {
info($e);
          DB::connection(Auth()->user()->company)->rollback();
          $this->dispatchBrowserEvent('mmsg', 'حدث خطأ');
      }
  }

    public function render()
    {
        return view('livewire.admin.to-hafitha',[
        'form_bank'=>FromExcelModel::on(Auth()->user()->company)
            ->select('bank')
            ->orderBy('bank')
            ->distinct()->get()]);
    }
}
