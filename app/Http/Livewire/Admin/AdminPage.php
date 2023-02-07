<?php

namespace App\Http\Livewire\Admin;

use App\Models\buy\buys;
use App\Models\Customers;
use App\Models\stores\items;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Jenssegers\Agent\Agent;

class AdminPage extends Component
{
public $text;

public $database='Daibany';
public $ThedatabaseListIsSelectd;

  public function updatedThedatabaseListIsSelectd(){
    $this->ThedatabaseListIsSelectd=0;
    User::find(auth()->user()->id)->update(['company'=>$this->database]);

    $this->emitTo('admin.empno-select','comp',$this->database);
    $this->redirect('/home');
  }
  public function BuyPrice(){
    $items=items::on(Auth::user()->company)->where('raseed','>',0)->get();
    DB::connection(Auth::user()->company)->beginTransaction();
      try {
        foreach ($items as $item) {
            $buys = buys::on(Auth::user()->company)
                ->join('buy_tran', 'buys.order_no', '=', 'buy_tran.order_no')
                ->select('quant', 'price_input')
                ->where('item_no', $item->item_no)
                ->orderBy('order_date_input', 'desc')
                ->get();
            if ($buys) {
                $calc_raseed = $item->raseed;
                $tot = 0;
                for ($i = 0; $i < count($buys); $i++) {
                    if ($calc_raseed > $buys[$i]->quant) {
                        $tot += $buys[$i]->quant * $buys[$i]->price;
                        $calc_raseed -= $buys[$i]->quant;
                    } else {
                        $tot += $calc_raseed * $buys[$i]->price;
                        break;
                    }
                }
                items::on(Auth::user()->company)->where('item_no', $item->item_no)
                    ->update(['price_cost' => $tot / $item->raseed]);
            }
        }
          DB::connection(Auth()->user()->company)->commit();

          $this->dispatchBrowserEvent('mmsg', 'تمت العملية بنجاح');

      } catch (\Exception $e) {

          DB::connection(Auth()->user()->company)->rollback();
          $this->dispatchBrowserEvent('mmsg', 'حدث خطأ');

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



    public function Clickme(){
        $agent = new Agent();
        $this->text = $agent->platform();
    }




    public function render()
    {
        return view('livewire.admin.admin-page');
    }
}
