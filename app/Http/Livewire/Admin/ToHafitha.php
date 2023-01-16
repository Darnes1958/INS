<?php

namespace App\Http\Livewire\Admin;

use App\Models\aksat\main;
use App\Models\aksat\MainArc;
use App\Models\bank\bank;
use App\Models\excel\FromExcelModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Str;

class ToHafitha extends Component
{
  public $Show=false;
  protected $listeners = ['show'];

  public function show($show){

    $this->Show=$show;
  }

  public function Do(){
    $FromExcel=FromExcelModel::on(Auth()->user()->company)->get();
    foreach ($FromExcel as $item) {
      $acc=$item->acc;
      $bankcode=Str::substr($acc, 0, 4);
      if (bank::on(Auth()->user()->company)->where('bank_code',$bankcode)->exists())
      $bank_no=bank::on(Auth()->user()->company)->where('bank_code',$bankcode)->first()->bank_no;
        else  continue;

      $no=main::on(Auth()->user()->company)
        ->where('bank',$bank_no)
        ->where('acc',$acc)->first();
      if ($no) {
        FromExcelModel::on(Auth()->user()->company)->where('acc', $acc)->update([
          'bank' => $bank_no,
          'no'=>$no->no,
          'h_no'=>1,
        ]);
      } else {
        $no=MainArc::on(Auth()->user()->company)
          ->where('bank',$bank_no)
          ->where('acc',$acc)->first();
        if ($no) {
          FromExcelModel::on(Auth()->user()->company)->where('acc', $acc)->update([
            'bank' => $bank_no,
            'no'=>$no->no,
            'h_no'=>2,
          ]);
        } else
        {FromExcelModel::on(Auth()->user()->company)->where('acc', $acc)->update([
          'bank' => $bank_no,
          'no'=>0,
          'h_no'=>0,
        ]);
        }
      }
    }


  }
    public function render()
    {
        return view('livewire.admin.to-hafitha');
    }
}
