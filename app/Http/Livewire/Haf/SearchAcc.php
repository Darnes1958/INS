<?php

namespace App\Http\Livewire\Haf;

use App\Models\aksat\main;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SearchAcc extends Component
{

    public $showdiv = false;
    public $search = "";
    public $records;
    public $empDetails;
    public $sender;
    public $bank;
    public $acc;
    public $accToEdit;
    public $BankGeted=false;

    protected $listeners = ['TakeBank','TakeBankAndAcc'];

    public function TakeBank($bank){
        $this->bank=$bank;
        $this->BankGeted=true;
    }
    public function TakeBankAndAcc($bank,$acc){
        $this->bank=$bank;
        $this->acc=$acc;

        $this->search=$acc;
        $this->BankGeted=true;
    }

    // Fetch records
    public function searchResult(){

        if(!empty($this->search)){

            $this->records = main::on(Auth()->user()->company)->orderby('acc','asc')
                ->select('*')
                ->where([
                    ['bank',$this->bank],
                    ['acc','like','%'.$this->search.'%']
                ])
                ->orwhere([
                    ['bank',$this->bank],
                    ['name','like','%'.$this->search.'%']
                ])

                ->limit(5)
                ->get();

            $this->showdiv = true;
        }else{
            $this->showdiv = false;
        }
    }

    // Fetch record by ID
    public function fetchEmployeeDetail($id = 0){

        $record =  main::on(Auth()->user()->company)->select('*')
            ->where('no',$id)
            ->first();

        $this->search = $record->acc;
        $this->emitTo($this->sender,'TakeTheNo',$id,$record->acc,$this->acc,$record->jeha);
        $this->empDetails = $record;
        $this->showdiv = false;
    }

    public function render()
    {
        return view('livewire.haf.search-acc');
    }
}
