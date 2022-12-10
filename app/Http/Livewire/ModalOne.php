<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Livewire\MyModal;

class ModalOne extends MyModal
{
    public function render()
    {
        return view('livewire.modal-one');
    }
}
