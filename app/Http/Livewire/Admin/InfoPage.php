<?php

namespace App\Http\Livewire\Admin;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\aksat\RepAksatController;
use App\Models\Customers;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class InfoPage extends Component
{
    public $Company;
    public $CompanyName;
    public $showokod=false;
    public $showokodarc=false;
    public $showokodall=false;
    public $showitemrep=false;

    protected $listeners = ['CloseOkod','CloseOkodArc','CloseItemRep','CloseOkodAll',];

    public function CloseOkod(){
        $this->showokod=false;
    }
    public function CloseOkodAll(){
        $this->showokodall=false;
    }
    public function CloseOkodArc(){
        $this->showokodarc=false;
    }
    public function CloseItemRep(){
        $this->showitemrep=false;
    }
    public function mount(){
        $this->Company=Auth::user()->company;
        $res=Customers::where('company',$this->Company)->first();
        $this->CompanyName=$res->CompanyName;
        $this->CompanyNameSuffix=$res->CompanyNameSuffix;

    }
    public function Okod(){
       $this->showokod=true;
       $this->showokodarc=false;
       $this->showokodall=false;
       $this->showitemrep=false;

    }
    public function OkodArc(){
        $this->showokodarc=true;
        $this->showokod=false;
        $this->showokodall=false;
        $this->showitemrep=false;

    }
    public function RepItem(){
        $this->showitemrep=true;
        $this->showokod=false;
        $this->showokodall=false;
        $this->showokodarc=false;

    }
    public function OkodAll(){
        $this->showokodarc=false;
        $this->showokod=false;
        $this->showokodall=true;
        $this->showitemrep=false;

    }
    public function render()
    {
        return view('livewire.admin.info-page');
    }
}
