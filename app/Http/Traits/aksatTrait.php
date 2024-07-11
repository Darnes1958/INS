<?php
namespace App\Http\Traits;

use App\Models\aksat\kst_trans;
use App\Models\aksat\main;
use App\Models\aksat\MainArc;
use App\Models\aksat\TransArc;

trait aksatTrait {
    public function mainTarseed(main $main,$sul_pay=null){
        if (!$sul_pay)
         $sul_pay=kst_trans::where('no',$main->no)->where('ksm','!=',null)->sum('ksm');
        $main->sul_pay=$sul_pay;
        $main->raseed=$main->sul-$sul_pay;
        $main->save();
    }
    public function chkRaseed(main $main) {
        $sul_pay=kst_trans::where('no',$main->no)->where('ksm','!=',null)->sum('ksm');
        if ($main->sul_pay != $sul_pay) {$this->mainTarseed($main,$sul_pay); return false; }
        else return true;
    }

    public function mainArcTarseed(MainArc $MainArc,$sul_pay=null){
        if (!$sul_pay)
            $sul_pay=TransArc::where('no',$MainArc->no)->where('ksm','!=',null)->sum('ksm');
        $raseed=$MainArc->sul-$sul_pay;

        $MainArc->where('no',$MainArc->no)->update(['sul_pay'=>$sul_pay,'raseed'=>$raseed]);

    }
    public function chkArcRaseed(MainArc $MainArc) {
        $sul_pay=TransArc::where('no',$MainArc->no)->where('ksm','!=',null)->sum('ksm');
        if ($MainArc->sul_pay != $sul_pay) {$this->mainArcTarseed($MainArc,$sul_pay);
            return MainArc::where('no',$MainArc->no)->first(); }
        else return $MainArc;
    }

}
