<?php

namespace App\Http\Livewire\Manager;

use App\Models\Operations;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class RepOper extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';
  public $DateChk=false,$ByChk=false;
  public $created_at,$By;

  public function ChkDateAndGo(){

}
  public function render()
    {

        return view('livewire.manager.rep-oper',[
          'UserName'=>User::where('company',Auth::user()->company)->get(),
          'TableList'=>Operations::join('pass','Operations.emp','=','pass.emp_no')

            ->select('Operations.*','pass.emp_name')
            ->when($this->ByChk,function ($q){
              $q->where('emp',$this->By);
            })
            ->when($this->DateChk,function ($q){
              $q->whereDate('created_at',$this->created_at);
            })
            ->paginate(15)
          ,
        ]);
    }
}
