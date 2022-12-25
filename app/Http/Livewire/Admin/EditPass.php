<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class EditPass extends Component
{
    public $OldPass;
    public $NewPass;
    public $ConfirmPass;

    public $OldGeted=false;
    public $ConfirmGeted=false;

    public function updatedOldPass(){
        $this->OldGeted=false;
    }

    public function ChkOldAndGo(){
        $hashedPassword =Auth::user()->getAuthPassword();

        if (Hash::check($this->OldPass, $hashedPassword)) {
            $this->OldGeted=true;
            $this->emit('goto','new');
        } else {
            $this->dispatchBrowserEvent('mmsg', 'كلمة السر غير صحيحة !!');
            return false;
        }
    }
    protected $rules = [
        'NewPass' => 'required|min:8',
        'ConfirmPass' => 'required|min:8',
    ];
    public function Save(){
     $this->validate();
     if ($this->NewPass!=$this->ConfirmPass) {
         $this->dispatchBrowserEvent('mmsg', 'الأرقام غير متطابقة !!');
         return false;
     }
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($this->NewPass)
        ]);
        return redirect()->to('/home');

    }
    public function render()
    {
        return view('livewire.admin.edit-pass');
    }
}
