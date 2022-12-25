<?php

namespace App\Http\Livewire\Admin;

use App\Models\Customers;

use Livewire\Component;

class DatabaseSelect extends Component
{
    public function hydrate(){
        $this->emit('database-change-event');
    }
    public function render()
    {

        $this->ItemList=Customers::all();
        return view('livewire.admin.database-select',$this->ItemList);

    }

}
