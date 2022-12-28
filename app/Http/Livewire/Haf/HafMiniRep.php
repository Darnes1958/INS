<?php

namespace App\Http\Livewire\Haf;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class HafMiniRep extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'TakeHafithaMini','TakeKstTypeName',
    ];
    public $hafitha=0;


    public $search;
    public $DisRadio='DisAll';
    public $rep_type;

    public function TakeKstTypeName($ksttypeno){
      $this->rep_type=$ksttypeno;
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
                ->paginate(15)]);
    }
}
