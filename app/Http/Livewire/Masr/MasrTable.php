<?php

namespace App\Http\Livewire\Masr;

use App\Models\masr\Masrofat;
use App\Models\masr\MasView;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class MasrTable extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $MasNo=0;
    public $dailydate;
    protected $listeners = [
        'TakeDate','refreshComponent' => '$refresh'
    ];
    public function TakeDate($dailydate){
        $this->dailydate=$dailydate;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function mount(){
      $this->dailydate=date('Y-m-d');
    }
    public function selectItem($masno,$action){
        $this->MasNo=$masno;
        if ($action=='delete') {$this->dispatchBrowserEvent('OpenMyDelete');}
        if ($action=='update') {$this->emitTo('masr.masr-inp','TakeMasNo',$masno);}
    }
    public function CloseDeleteDialog(){$this->dispatchBrowserEvent('CloseMyDelete');}


    public function delete(){
        $this->CloseDeleteDialog();
        Masrofat::on(Auth()->user()->company)->where('MasNo',$this->MasNo)->delete();

        $this->render();
    }
    public function render()
    {
        return view('livewire.masr.masr-table',[
            'TableList'=>MasView::on(Auth::user()->company)
                ->where('MasDate',$this->dailydate)->paginate(15)
        ]);
    }
}
