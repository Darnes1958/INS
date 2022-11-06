<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\stores\item_type;

class AddOne extends Component
{

    public $name;

    protected function rules()
    {

        return [
            'name' => ['required'],
        ];
    }

    protected $messages = [
        'required' => 'يجب ملء البيان',
         ];


    public function SaveOne(){
        $this->validate();
        Config::set('database.connections.other.database', Auth::user()->company);
        $no=item_type::max('type_no')+1;
        DB::connection('other')->table('item_type')->insert([
                'type_no' => $no,
                'type_name' => $this->name,
            ]);
        $this->name='';
        $this->emit('itemtypeadded',$no);

        session()->flash('message', 'تم تخزين البيانات');

    }
    public function mount(){
        $this->name='';

    }
    public function render()
    {
        $itemtypes=item_type::where('type_no','>',0)->paginate(10);
        return view('livewire.add-one',compact('itemtypes'));
    }
}
