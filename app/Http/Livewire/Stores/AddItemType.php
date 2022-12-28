<?php

namespace App\Http\Livewire\Stores;

use App\Models\stores\item_type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AddItemType extends Component
{
    use WithPagination;
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

        $no=item_type::on(Auth()->user()->company)->max('type_no')+1;
        DB::connection(Auth()->user()->company)->table('item_type')->insert([
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
    protected $paginationTheme = 'bootstrap';
    public function render()
    {

        return view('livewire.Stores.add-item-type',[
            'itemtypes' => item_type::on(Auth()->user()->company)->paginate(10),
        ]);
    }
}
