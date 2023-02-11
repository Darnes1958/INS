<?php

namespace App\Http\Livewire\Buy;

use App\Models\buy\charge_by;
use App\Models\buy\charge_type;
use App\Models\buy\charges_buy;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AddType extends Component
{
    use WithPagination;
    public $name;
    public $EditMod=false;
    public $no;

    protected function rules()
    {

        return [
            'name' => ['required'],
        ];
    }

    protected $messages = [
        'required' => 'يجب ملء البيان',
    ];

    public function EditOne($no,$name){
        $this->no=$no;
        $this->name=$name;
        $this->EditMod=true;
        $this->emit('gotoedit','name');
    }
    public function DeleteOne($no){
        $this->no=$no;
        if (charges_buy::on(Auth()->user()->company)->where('charge_type',$this->no)->exists() ) {
            $this->dispatchBrowserEvent('mmsg', 'سبق استخدام هذا البيان ولا يجوز الغاءه');
            return false;
        }
        charge_type::on(Auth()->user()->company)->where('type_no',$this->no)->delete();
        $this->render();
    }
    public function SaveOne(){
        $this->validate();

        if ($this->EditMod){

            DB::connection(Auth()->user()->company)->table('charge_type')
                ->where('type_no',$this->no)
                ->update([
                    'type_name' => $this->name,
                ]);
            $this->EditMod=false;
        } else {
            $this->no=charge_type::on(Auth()->user()->company)->max('type_no')+1;
            DB::connection(Auth()->user()->company)->table('charge_type')->insert([
                'type_no' => $this->no,
                'type_name' => $this->name,
            ]);}
        $this->name='';


        session()->flash('message', 'تم تخزين البيانات');

    }
    public function mount(){
        $this->name='';

    }
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        return view('livewire.buy.add-type',[
            'items' => charge_type::on(Auth()->user()->company)->paginate(10),
        ]);
    }
}
