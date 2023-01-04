<?php

namespace App\Http\Livewire\Jeha;

use App\Models\jeha\jeha;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Illuminate\Pagination\LengthAwarePaginator;

use Livewire\WithPagination;

class RepJehaTran extends Component
{
    use WithPagination;


    public $jeha_no=0;
    public $jeha_type;
    public $jeha_name;
    public $tran_date;
    protected $listeners = [
        'Take_Search_JehaNo',
    ];

    public function Chkjeha(){
        if ($this->jeha_no !=null ) {

            $this->jeha_name = '';
            $this->jeha_type = 0;
            $conn=Auth()->user()->company;
            $res = jeha::on(Auth()->user()->company)->find($this->jeha_no);
            if ($res) {
                $this->jeha_name = $res->jeha_name;
                $this->jeha_type = $res->jeha_type;
                if ($res->jeha_no==1) {return('amaa');}
                if ($res->jeha_type==2) {return('supp');}

                return ('ok');
            } else {
                $this->dispatchBrowserEvent('mmsg', 'هذا الرقم غير مخزون ؟');
                return ('not');
            }
        } else {return ('empty');}
    }
    public function JehaKeyDown(){
        $res=$this->Chkjeha();
        if ($res !='empty' && $res!='not')  {
            $this->emit('gotonext','tran_date');

        }

    }
    public function DateKeyDown(){
$this->validate();


    }
    protected function rules()
    {
        Config::set('database.connections.other.database', Auth::user()->company);

        return [

            'jeha_no' =>['required','integer','gt:1', 'exist:other.jeha.jeha_no'],
            'tran_date' => ['required','date'],


        ];
    }
    protected $messages = [
        'exists' => 'هذا الرقم غير مخزون',
        'required' => 'لا يجوز ترك فراغ',

        'tran_date.required'=>'يجب ادخال تاريخ صحيح',
    ];
    public function Take_Search_JehaNo($jeha_no){
        $this->jeha_no=$jeha_no;
        $this->JehaKeyDown();
    }
    public function OpenJehaSerachModal(){
        $this->dispatchBrowserEvent('OpenjehaModal');
    }
    public function CloseJehaSerachModal(){
        $this->dispatchBrowserEvent('ClosejehaModal');
    }
    public function mount(){

        $date = Carbon::now()->subYear();

        $this->tran_date = $date->copy()->startOfYear();
        $this->tran_date=$this->tran_date->ToDateString();

    }
    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
    public function render()
    {
        $page = 1;
        $paginate = 15;


        $collection = collect(DB::connection(Auth()->user()->company)->
        select('Select * from dbo.frep_jeha_tran (?) as result where order_date>=? order by order_date,order_no '
            ,array($this->jeha_no,$this->tran_date)));

        $data = $this->paginate($collection);



        return view('livewire.jeha.rep-jeha-tran',['RepTable'=> $data]);

    }
}
