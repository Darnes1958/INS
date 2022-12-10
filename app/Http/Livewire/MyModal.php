<?php

namespace App\Http\Livewire;

use Illuminate\Queue\Listener;
use Livewire\Component;

class MyModal extends Component
{
    public $show = false;
    protected $Listeners = [
        'show' => 'show'
    ];
    public function show()
    {
        $this->show=true;
    }
    }
