<?php

namespace App\Http\Livewire\Haf;

use App\Models\aksat\hafitha;
use App\Models\aksat\hafitha_tran;
use App\Models\aksat\main;
use App\Models\aksat\MainArc;
use App\Models\aksat\ManyNo;
use App\Models\OverTar\over_kst;
use App\Models\OverTar\over_kst_a;
use App\Models\OverTar\stop_kst;
use App\Models\OverTar\tar_kst;
use App\Models\OverTar\tar_kst_before;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class HafManyNo extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'TakeHafNo','TakeTheNo',
    ];
    public $hafitha=0;
    public $bank;
    public $h_no;
    public $acc;
    public $no;

    public $NoToEdit;
    public $Rec;

    public $name;
    public $jeha;
    public $showbtn=false;
    public $search;

    public function TakeNoAcc($no,$acc){
        $this->no=$no;
        $this->acc=$acc;
    }
    public function TakeHafNo($h_no){
        $this->hafitha=$h_no;
        $this->h_no=$h_no;
    }


    public function TakeTheNo($no,$NoToEdit){

      DB::connection(Auth()->user()->company)->beginTransaction();
       try {
         hafitha_tran::where('hafitha',$this->h_no)->where('no',$NoToEdit)
             ->update(['no'=>$no,'kst'=>
                 DB::connection(Auth()->user()->company)->
                 raw('kst+baky')]);
         $res=main::where('no',$no)->first();
         $raseed=$res->raseed;
         $name=$res->name;
         $NoList=hafitha_tran::where('hafitha', $this->h_no)
               ->where('no',$this->no)->get();

           $sumkst=0;
           foreach ($NoList as $List) {
               $sumkst += $List->kst;
               if ($raseed >= $sumkst) {
                   hafitha_tran::where('hafitha', $this->hafitha)
                               ->where('ser_in_hafitha',$List->ser_in_hafitha)
                               ->update(['name'=>$name,'kst_type' => 1, 'baky' => 0,]);
               } else {
                   if (($sumkst - $raseed) < $List->kst) {
                       hafitha_tran::where('hafitha', $this->hafitha)
                                   ->where('ser_in_hafitha',$List->ser_in_hafitha)
                                   ->update(['name'=>$name,'kst' => $List->kst-($sumkst - $raseed),
                                       'kst_type' => 3, 'baky' => $sumkst - $raseed,]);
                   } else hafitha_tran::where('hafitha', $this->hafitha)
                                      ->where('ser_in_hafitha',$List->ser_in_hafitha)
                                      ->update(['name'=>$name, 'kst_type' => 2, 'baky' => 0,]);
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
           hafitha::where('hafitha_no',$this->hafitha)->update([
               'kst_morahel'=>$summorahel,'kst_over'=>$sumover,'kst_half_over'=>$sumhalfover,
               'kst_wrong'=>$sumwrong,
           ]);
           ManyNo::where('h_no',$this->h_no)->whereIn('no',[$no,$NoToEdit])->delete();

        DB::connection(Auth()->user()->company)->commit();
           $this->NoToEdit='';
           $this->no='';
           $this->acc='';

           $this->resetPage();
        } catch (\Exception $e) {
           info($e);
            DB::connection(Auth()->user()->company)->rollback();
            $this->dispatchBrowserEvent('mmsg', 'حدث خطأ');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        return view('livewire.haf.haf-many-no',[
            'ManyNo' =>ManyNo::
                join('main','ManyNo.no','=','main.no')
                ->where('ManyNo.h_no',$this->h_no)
                ->where('name', 'like', '%'.$this->search.'%')
                ->select('ManyNo.no','name','ManyNo.kst','ManyNo.acc')
                ->orderBy('ManyNo.no','asc')
                ->paginate(12),
            'Mains'=>main::where('acc',$this->acc)->get()]);
    }
}
