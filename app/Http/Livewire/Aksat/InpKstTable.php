<?php

namespace App\Http\Livewire\Aksat;

use App\Models\aksat\kst_tran_view;
use App\Models\aksat\kst_trans;
use App\Models\aksat\main;
use App\Models\Operations;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class InpKstTable extends Component
{
    use WithPagination;
  public $no;
  public $The_ser;


  public $post2='rep_sell_tran';
  protected $listeners = [
    'GotoKstDetail','refreshComponent' => '$refresh',
  ];

  public function CloseKstEdit(){
      $this->dispatchBrowserEvent('CloseKstEdit');
  }
    public function CloseKstDelete(){
        $this->dispatchBrowserEvent('CloseKstDelete');
    }

  public function Edit($The_ser){
    $this->emitTo('aksat.edit-kst','GetTheMainNo',$this->no);
    $this->emitTo('aksat.edit-kst','GetTheId',$The_ser);
    $this->dispatchBrowserEvent('OpenKstEdit');

  }
    public function Delete($The_ser){
        $this->The_ser=$The_ser;
        $this->dispatchBrowserEvent('OpenKstDelete');
    }
   public function DoDelete(){
       DB::connection(Auth()->user()->company)->beginTransaction();
       try {
           DB::connection(Auth()->user()->company)->table('kst_trans')->where('no', $this->no)->where('ser', $this->The_ser)->update([
               'ksm' => 0,
               'ksm_date' => null,
               'kst_notes' => null,
               'emp' => auth::user()->empno,
           ]);
           $sul_pay = kst_trans::on(Auth()->user()->company)->where('no', $this->no)->where('ksm', '!=', null)->sum('ksm');
           $sul = main::on(Auth()->user()->company)->where('no', $this->no)->first();
           $raseed = $sul->sul - $sul_pay;
           main::on(Auth()->user()->company)->where('no', $this->no)->update(['sul_pay' => $sul_pay, 'raseed' => $raseed]);

           Operations::insert(['Proce' => 'قسط', 'Oper' => 'الغاء', 'no' => $this->no, 'created_at' => Carbon::now(), 'emp' => auth::user()->empno,]);
           DB::connection(Auth()->user()->company)->commit();
           $this->CloseKstDelete();
           $this->emitSelf('refreshComponent');

       } catch (\Exception $e) {
           DB::connection(Auth()->user()->company)->rollback();

           $this->dispatchBrowserEvent('mmsg', 'حدث خطأ');
       }

   }
    public function GotoKstDetail($no,$worder){
     $this->no=$no;
     $this->emit('GetWhereEquelValue2',$worder);
     $this->emit('kstdetail_goto','ksm_date');

   }
    public function render()
    {
        return view('livewire.aksat.inp-kst-table',[
            'TableList'=>kst_tran_view::where('no',$this->no)->orderBy('ser','asc')->paginate(15)
        ]);
    }
}
