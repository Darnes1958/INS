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

    public function mount(){
        $this->Company=Auth::user()->company;
        $res=Customers::where('company',$this->Company)->first();
        $this->CompanyName=$res->CompanyName;
        $this->CompanyNameSuffix=$res->CompanyNameSuffix;

    }
    public function Okod(){
       $this->showokod=true;
       $this->showokodarc=false;

    }
    public function OkodArc(){
        $this->showokodArc=true;
        $this->showokod=false;

    }
    public function render()
    {
        return view('livewire.admin.info-page');
    }
}
