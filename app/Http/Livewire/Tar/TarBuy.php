<?php

namespace App\Http\Livewire\Tar;

use App\Models\buy\buy_tran;
use App\Models\buy\buys;
use App\Models\buy\charge_by;
use App\Models\buy\charge_type;
use App\Models\buy\charges_buy;
use App\Models\jeha\jeha;
use App\Models\Operations;
use App\Models\stores\items;
use App\Models\stores\stores;
use App\Models\stores\stores_names;
use App\Models\Tar\tar_buy;
use App\Models\Tar\tar_buy_view;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class TarBuy extends Component
{
    public $stno;
    public $st_name;

    public $item_no;
    public $item_no_L;
    public $order_no=0;
    public $item_name;
    public $st_raseed;
    public $raseed;
    public $quant;
    public $tar_date;
    public $order_date;
    public $ItemGeted=false;
    public $OrderGeted=false;
    public $TheOrderListSelected;

    public $tar_id;
    public $item_to_delete;
    public $quant_to_delete;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public function updatedTheOrderListSelected(){
        $this->TheOrderListSelected=0;
        $this->ChkOrderNoAndGo();
    }
    public function ChkOrderNoAndGo(){
        $this->OrderGeted=false;
        if ($this->order_no) {
            $res = buys::on(Auth()->user()->company)->find($this->order_no);
            if ($res) {
                $this->stno = $res->place_no;
                $this->order_date = $res->order_date;
                $this->st_name = stores_names::find($this->stno)->st_name;
                $this->OrderGeted=true;

            } else $this->dispatchBrowserEvent('mmsg', 'هذا الرقم غير مخزون ');

        }
    }
    public function updated($field)
    {
        if ($field=='order_no') {$this->OrderGeted=false;}
        if ($field == 'item_no_L') {
            $this->item_no = $this->item_no_L;
            $res=items::find($this->item_no);
            $this->item_name=$res->item_name;
            $this->raseed=$res->raseed;
            $this->st_raseed=stores::where('st_no',$this->stno)->where('item_no',$this->item_no)->first()->raseed;
            $this->ItemGeted=true;
            $this->emit('gotonext', 'quant');
        }
    }
    protected function rules()
    {
        Config::set('database.connections.other.database', Auth::user()->company);
        return [
            'tar_date' => ['required','date',],
            'quant' =>   ['required','integer','gt:0','lte:'.$this->st_raseed],

        ];
    }
    protected $messages = [
        'required' => 'لا يجوز ترك فراغ',
        'lte' => 'الرصيد لا يسمح',
        'order_date.required'=>'يجب ادخال تاريخ صحيح',
    ];
    public function store(){
        $this->validate();
        DB::connection(Auth()->user()->company)->beginTransaction();

        try {
           tar_buy::insert([
                'tar_date'=>$this->tar_date,
                'order_no'=>$this->order_no,
                'item_no'=>$this->item_no,
                'quant'=>$this->quant,
                'emp'=>Auth::user()->empno,
                'created_at'=>Carbon::now(),
            ]);

            buy_tran::where('order_no',$this->order_no)->where('item_no',$this->item_no)->update(['tarjeeh'=>1]);
            stores::where('st_no',$this->stno)->where('item_no',$this->item_no)->decrement('raseed',$this->quant);
            items::where('item_no',$this->item_no)->decrement('raseed',$this->quant);

            DB::connection(Auth()->user()->company)->commit();
            $this->item_no='';
            $this->quant='';
            $this->item_name='';
            $this->raseed='';
            $this->st_raseed='';
            $this->emit('gotonext','order_no');
        } catch (\Exception $e) {
            info($e);
            $this->dispatchBrowserEvent('mmsg','حدث خطأ');
            DB::connection(Auth()->user()->company)->rollback();
        }
    }
    public function selectItem($id,$item,$quant){
        $this->tar_id=$id;
        $this->item_to_delete=$item;
        $this->quant_to_delete=$quant;
        $this->dispatchBrowserEvent('OpenMyDelete');

    }
    public function CloseDeleteDialog(){$this->dispatchBrowserEvent('CloseMyDelete');}


    public function delete(){
        $this->CloseDeleteDialog();
        DB::connection(Auth()->user()->company)->beginTransaction();
        try {
            tar_buy::find($this->tar_id)->delete();
            buy_tran::where('order_no', $this->order_no)->where('item_no', $this->item_to_delete)->update(['tarjeeh' => 0]);
            stores::where('st_no', $this->stno)->where('item_no', $this->item_to_delete)->increment('raseed', $this->quant_to_delete);
            items::where('item_no', $this->item_to_delete)->increment('raseed', $this->quant_to_delete);
            Operations::insert(['Proce' => 'ترجيع مشتريات', 'Oper' => 'الغاء', 'no' => $this->order_no, 'created_at' => Carbon::now(), 'emp' => auth::user()->empno,]);
            DB::connection(Auth()->user()->company)->commit();
        } catch (\Exception $e) {
            info($e);
            $this->dispatchBrowserEvent('mmsg','حدث خطأ');
            DB::connection(Auth()->user()->company)->rollback();
        }
        $this->render();
    }
    public function mount(){
        $this->tar_date=date('Y-m-d');
    }
    public function render()
    {
        if (!$this->order_no) $this->order_no=0;
        return view('livewire.tar.tar-buy',[
            'TableList'=>tar_buy_view::where('order_no',$this->order_no)->paginate(15),
            'items'=>items::whereIn('item_no', function($q){
                $q->select('item_no')->from('buy_tran')
                    ->where('order_no',$this->order_no)
                    ->where('tarjeeh',0);})
             ->get(),
        ]);
    }
}
