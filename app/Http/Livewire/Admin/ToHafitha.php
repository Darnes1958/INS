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
  public $BankList;
  protected $listeners = ['show'];

  public function show($show){
    $this->Show=$show;
  }
  protected function FillNoBankMainArc($FromExcel){
      foreach ($FromExcel as $item) {
          $acc=$item->acc;
          $bankcode=Str::substr($acc, 0, 4);
          if (bank::on(Auth()->user()->company)->where('bank_code',$bankcode)->exists())
              $bank_no=bank::on(Auth()->user()->company)->where('bank_code',$bankcode)->first()->bank_no;
          else  {
              $this->dispatchBrowserEvent('mmsg', 'كود المصرف '.$bankcode.' غير موجود ');
              return false;
          };

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
    protected function FillWrongData($BankANdAcc){
        $AccList=FromExcelModel::on(Auth()->user()->company)
            ->where('bank',$BankANdAcc->bank)
            ->where('acc',$BankANdAcc->acc)
            ->get();
        foreach ($AccList as $List){
           FromExcelModel::on(Auth()->user()->company)->find($List->id)->update([
              'kst'=>$List->ksm,'kst_type'=>4,'baky'=>0,]) ; }
    }
  protected function FillNoData($NoAndType){

    if ($NoAndType->MainArcWrong==1){
        $raseed=main::on(Auth()->user()->company)->find($NoAndType->no)->raseed;
        $NoList=FromExcelModel::on(Auth()->user()->company)->where('no',$NoAndType->no)->get();
        $sumkst=0;
        foreach ($NoList as $List){
          $sumkst+=$List->ksm;
          if ($raseed>=$sumkst){
              FromExcelModel::on(Auth()->user()->company)->find($List->id)->update([
               'kst'=>$List->ksm,'kst_type'=>1,'baky'=>0,]) ; }
          else {
              if (($sumkst-$raseed)<$List->ksm){
                  FromExcelModel::on(Auth()->user()->company)->find($List->id)->update([
                      'kst'=>$raseed,'kst_type'=>3,'baky'=>$sumkst-$raseed,]) ;
              } else FromExcelModel::on(Auth()->user()->company)->find($List->id)->update([
                'kst'=>$List->ksm,'kst_type'=>2,'baky'=>0,]) ;
          }
        }

    }
    if ($NoAndType->MainArcWrong==2){
        $NoList=FromExcelModel::on(Auth()->user()->company)->where('no',$NoAndType->no)->get();
        foreach ($NoList as $List){
        FromExcelModel::on(Auth()->user()->company)->find($List->id)->update([
            'kst'=>$List->ksm,'kst_type'=>5,'baky'=>0,]) ;}
    }
}
  protected function FillKstHaf($bank){


    $NoList=FromExcelModel::on(Auth()->user()->company)->select('no','MainArcWrong')
        ->where('no','!=',0)
        ->distinct()->get();
       foreach ($NoList as $NoAndType) {$this->FillNoData($NoAndType);}

    $AccList=FromExcelModel::on(Auth()->user()->company)->select('bank','acc')
         ->where('no','=',0)
         ->where('bank',$bank)
         ->distinct()->get();

        foreach ($AccList as $BankAndAcc){$this->FillWrongData($BankAndAcc);  }
  }
  public function Do(){
    $this->FromExcel=FromExcelModel::on(Auth()->user()->company)->get();
    if (!$this->FillNoBankMainArc($this->FromExcel)) return false;

    $this->BankList=FromExcelModel::on(Auth()->user()->company)->select('bank')->distinct()->get();
    foreach ($this->BankList as $bank){
       $this->FillKstHaf($bank->bank);
    }
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
        return view('livewire.admin.to-hafitha');
    }
}
