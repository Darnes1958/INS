<?php

namespace App\Http\Livewire\Aksat\Rep\Okod;

use App\Http\Traits\aksatTrait;
use App\Models\aksat\main;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class RepMainHead extends Component
{
 use WithPagination;
 use aksatTrait;
 protected $paginationTheme = 'bootstrap';
 public $no;
 public $acc;
 public $search='';
 public $IsSearch=true;
 public $bankno=0;
 public $TheBankListIsSelectd;
 public $who='aksat.rep.okod.rep-main-data';

 protected $listeners = ['OpenTable',];

 public function updatedTheBankListIsSelectd(){
        $this->TheBankListIsSelectd=0;
        $this->emitTo('bank.bank-select','TakeBankNo',$this->bankno);
    }
 public function updatingSearch()
  {
    $this->resetPage();
  }

 public function OpenTable(){
    $this->IsSearch=true;
 }
 public function CloseTable(){
        $this->search='';
        $this->IsSearch=false;
    }
 public function selectItem($no){
   $this->no=$no;
   $this->CloseTable();
   $this->ChkNoAndGo();
 }
 public function ChkNoAndGo(){

    $this->acc='';

    if ($this->no!=null) {
        $result = main::find($this->no);
        if ($result) {
          info($result->sul_pay);
            $this->chkRaseed($result);
            info($result->sul_pay);
            $this->CloseTable();
            $this->acc=$result->acc;
            $this->emitTo($this->who,'GotoDetail',$result);
            $this->emitTo('aksat.rep.okod.rep-main-trans','GotoTrans',$this->no);
            $this->emit('GetWhereEquelValue2',$result->order_no);

        }
    }
 }
    public function render()
    {

        return view('livewire.aksat.rep.okod.rep-main-head',[
            'TableList' => DB::connection(Auth()->user()->company)->table('main')
                ->select('no','acc', 'name','sul','kst')
                ->when(($this->bankno==null||$this->bankno==0),function ($q) {
                    return $q->where('name', 'like', '%'.$this->search.'%')
                            ->orwhere('acc', 'like', '%'.$this->search.'%')
                            ->orwhere('no', 'like', '%'.$this->search.'%')
                            ->orwhere('jeha', 'like', '%'.$this->search.'%')
                            ->orwhere('order_no', 'like', '%'.$this->search.'%') ;     })
                ->when($this->bankno!=0,function ($q) {
                    return $q->where('bank',$this->bankno)
                        ->Where(function($query) {
                            $query->where('name', 'like', '%'.$this->search.'%')
                                ->orwhere('acc', 'like', '%'.$this->search.'%')
                                ->orwhere('no', 'like', '%'.$this->search.'%')
                                ->orwhere('jeha', 'like', '%'.$this->search.'%')
                                ->orwhere('order_no', 'like', '%'.$this->search.'%');}) ;
                           })

                ->paginate(5)
    ]);
    }
}
