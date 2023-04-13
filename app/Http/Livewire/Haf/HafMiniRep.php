<?php

namespace App\Http\Livewire\Haf;

use App\Models\aksat\hafitha_tran;
use App\Models\aksat\main;
use App\Models\aksat\MainArc;
use App\Models\OverTar\over_kst;
use App\Models\OverTar\over_kst_a;
use App\Models\OverTar\stop_kst;
use App\Models\OverTar\tar_kst;
use App\Models\OverTar\tar_kst_before;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class HafMiniRep extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'TakeHafithaMini','TakeKstTypeName','TakeTheNo',
    ];
    public $hafitha=0;
    public $bank;
    public $acc;


    public $search;
    public $DisRadio='DisAll';
    public $rep_type;
    public $NoToEdit;
    public $OldAcc;
    public $name;
    public $jeha;
    public $showbtn=false;

    public function selectItem($acc){
      $this->acc=$acc;
    }

    public function ChkNoToEdit(){
        if ($this->NoToEdit){
            $res=main::on(Auth()->user()->company)->where('no',$this->NoToEdit)->first();
            if ($res){
                $this->OldAcc=$res->acc;
                $this->name=$res->name;
                $this->jeha=$res->jeha;
            } else
            {
                $res=MainArc::on(Auth()->user()->company)->where('no',$this->NoToEdit)->first();
                if ($res){
                    $this->OldAcc=$res->acc;
                    $this->name=$res->name;
                    $this->jeha=$res->jeha;
                } else {
                    $this->dispatchBrowserEvent('mmsg','هذا الرقم غير مخزون');
                    return false;
                }
            }
           $this->showbtn=true;
           $this->emitSelf('hafmini_goto','SaveAccBtn');
        }
    }

    public function SaveNewAcc(){
        $this->TakeTheNo($this->NoToEdit,$this->OldAcc,$this->acc,$this->jeha);
        $this->showbtn=false;
    }
    public function TakeTheNo($no,$acc,$accToEdit,$jeha){

      DB::connection(Auth()->user()->company)->beginTransaction();
       try {

        over_kst::on(Auth()->user()->company)->where('bank', $this->bank)->where('acc',$acc)->update(['acc' => $accToEdit,]);
        over_kst_a::on(Auth()->user()->company)->where('bank', $this->bank)->where('acc', $acc)->update(['acc' => $accToEdit,]);
        tar_kst::on(Auth()->user()->company)->where('bank', )->where('acc',$acc)->update(['acc' => $accToEdit,]);
        stop_kst::on(Auth()->user()->company)->where('bank', )->where('acc',$acc)->update(['acc' => $accToEdit,]);
        tar_kst_before::on(Auth()->user()->company)->where('bank', $this->bank)->where('acc',$acc)->update(['acc' => $accToEdit,]);
        main::on(Auth()->user()->company)->where('jeha', $jeha)->update(['acc' => $accToEdit,]);
        MainArc::on(Auth()->user()->company)->where('jeha', $jeha)->update(['acc' => $accToEdit,]);

           if (main::where('no',$no)->exists())
            $raseed=main::where('no',$no)->first()->raseed;
           else
             $raseed=MainArc::where('no',$no)->first()->raseed;

           $NoList=hafitha_tran::where('hafitha', $this->hafitha)
               ->where('acc','=',str($accToEdit))->get();


           $sumkst=0;
           foreach ($NoList as $List) {
               $sumkst += $List->kst;
               if ($raseed >= $sumkst) {
                   hafitha_tran::where('hafitha', $this->hafitha)
                               ->where('ser_in_hafitha',$List->ser_in_hafitha)
                               ->update(['name'=>$List->name,'no'=>$no,'kst_type' => 1, 'baky' => 0,]);
               } else {
                   if (($sumkst - $raseed) < $List->kst) {
                       hafitha_tran::where('hafitha', $this->hafitha)
                                   ->where('ser_in_hafitha',$List->ser_in_hafitha)
                                   ->update(['name'=>$List->name,'no'=>$no, 'kst' => $List->kst-($sumkst - $raseed), 'kst_type' => 3, 'baky' => $sumkst - $raseed,]);
                   } else hafitha_tran::where('hafitha', $this->hafitha)
                                      ->where('ser_in_hafitha',$List->ser_in_hafitha)
                                      ->update(['name'=>$List->name,'no'=>$no,'kst' => $List->kst, 'kst_type' => 2, 'baky' => 0,]);
               }
           }
           $summorahel=hafitha_tran::where('hafitha',$this->hafitha)->where('kst_type',1)->sum('kst');
           $sumover1=hafitha_tran::where('hafitha',$this->hafitha)->where('kst_type',2)->sum('kst');
           $sumover2=hafitha_tran::where('hafitha',$this->hafitha)->where('kst_type',5)->sum('kst');
           $sumover3=hafitha_tran::where('hafitha',$this->hafitha)->where('kst_type',3)->sum('baky');
           if ($sumover1==null) {$sumover1=0;}
           if ($sumover2==null) {$sumover2=0;}
           if ($sumover3==null) {$sumover3=0;}
           $sumover=$sumover1+$sumover2+$sumover3;
           $sumhalfover=hafitha_tran::where('hafitha',$this->hafitha)->where('kst_type',3)->sum('kst');
           $sumwrong=hafitha_tran::where('hafitha',$this->hafitha)->where('kst_type',4)->sum('kst');
           DB::connection(Auth()->user()->company)->table('hafitha')->where('hafitha_no',$this->hafitha)->update([
               'kst_morahel'=>$summorahel,'kst_over'=>$sumover,'kst_half_over'=>$sumhalfover,'kst_wrong'=>$sumwrong,
           ]);

        DB::connection(Auth()->user()->company)->commit();
           $this->NoToEdit='';
           $this->OldAcc='';
           $this->name='';
           $this->resetPage();
        } catch (\Exception $e) {
           info($e);
            DB::connection(Auth()->user()->company)->rollback();
            $this->dispatchBrowserEvent('mmsg', 'حدث خطأ');
        }
    }

    public function TakeKstTypeName($ksttypeno,$bank){

      $this->rep_type=$ksttypeno;
      $this->bank=$bank;
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function TakeHafithaMini($h){
        $this->hafitha=$h;
    }
    public function render()
    {
        return view('livewire.haf.haf-mini-rep',[
            'HafithaTable' =>DB::connection(Auth()->user()->company)
                ->table('hafitha_tran_view')
                ->when($this->search || $this->DisRadio=='DisAll', function($q)  {
                    return $q->where([
                        ['hafitha_no', '=', $this->hafitha],
                        ['kst_type', '=', $this->rep_type],
                        ['name', 'like', '%'.$this->search.'%'],])
                        ->orwhere([
                            ['hafitha_no', '=', $this->hafitha],
                            ['kst_type', '=', $this->rep_type],
                            ['acc', 'like', '%'.$this->search.'%'],]);       })
                ->when($this->search || $this->DisRadio=='DisMe', function($q)  {
                    return $q->where([
                        ['hafitha_no', '=', $this->hafitha],
                        ['kst_type', '=', $this->rep_type],
                        ['emp','=',Auth::user()->empno],
                        ['name', 'like', '%'.$this->search.'%'],])
                        ->orwhere([
                            ['hafitha_no', '=', $this->hafitha],
                            ['kst_type', '=', $this->rep_type],
                            ['emp','=',Auth::user()->empno],
                            ['acc', 'like', '%'.$this->search.'%'],]);       })

                ->when(!$this->search || $this->DisRadio=='DisAll', function($q)  {
                    return $q->where([
                        ['hafitha_no', '=', $this->hafitha],
                        ['kst_type', '=', $this->rep_type],]);       })
                ->when(!$this->search || $this->DisRadio=='DisMe', function($q)  {
                    return $q->where([
                        ['hafitha_no', '=', $this->hafitha],
                        ['kst_type', '=', $this->rep_type],
                        ['emp','=',Auth::user()->empno], ]);       })

                ->orderBy('acc','asc')
                ->orderBy('ser_in_hafitha','asc')
                ->paginate(12)]);
    }
}
