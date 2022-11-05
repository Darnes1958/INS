<?php

namespace App\Http\Livewire\Stores;

use App\Models\stores\items;



use Livewire\Component;

class AddItem extends Component
{
    public items $items;
    public function SaveItem(){
        $this->dispatchBrowserEvent('CloseModal');
    }
    public function mount(items $items)
    {
       $this->items=$items;
    }
    public function render()
    {
        return view('livewire.stores.add-item');
    }
}
