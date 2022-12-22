<?php

namespace App\Http\Livewire\Admin;

use App\Models\Customers;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class WelcomePage extends Component
{
   public $Company;
   public $CompanyName;
   public $CompanyNameSuffix;
   public $Whome;

   public function mount(){
     $this->Company=Auth::user()->company;
     $res=Customers::where('company',$this->Company)->first();
     $this->CompanyName=$res->CompanyName;
     $this->CompanyNameSuffix=$res->CompanyNameSuffix;

   }
    public function render()
    {
        return view('livewire.admin.welcome-page');
    }
}
