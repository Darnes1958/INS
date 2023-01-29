<?php

namespace App\Http\Livewire\Haf;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class RepHaf extends Component
{
    public $Haf_no=0;
    public $bank_name;


    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $date1;
    public $date2;
    public $haf_date1;
    public $haf_date2;
    public $RepRadio=0;

    public $search;
    public $search2;


    protected function rules()
    {
        return [
            'date1' => ['required','date'],
            'date2' => ['required','date'],
        ];
    }

    protected $messages = [
        'required' => 'لا يجوز',
        'required.date1' => 'يجب ادخال تاريخ صحيح',
        'required.date2' => 'يجب ادخال تاريخ صحيح',
    ];
    public function updatedDate2(){
        if ($this->isDate($this->date1 ) && $this->isDate($this->date2 )) {
          $this->Date2Chk();
        }
    }
  public function updatedDate1(){
    if ($this->isDate($this->date1 ) && $this->isDate($this->date2 )) {
      $this->Date2Chk();
    }
  }

    function isDate($value) {
        if (!$value) {
            return false;
        } else {
            $date = date_parse($value);
            if($date['error_count'] == 0 && $date['warning_count'] == 0){
                return checkdate($date['month'], $date['day'], $date['year']);
            } else {
                return false;
            }
        }
    }
    public function Date2Chk()
    {
        $this->validate();
        $this->haf_date1 = $this->date1;
        $this->haf_date2 = $this->date2;
    }
    public function selectItem($haf,$bank){

       $this->Haf_no=$haf;
       $this->bank_name=$bank;
        }

  public function mount(){
    $this->date1=Carbon::now()->startOfMonth()->toDateString();
    $this->date2=Carbon::now()->endOfMonth()->toDateString();
    $this->haf_date1=$this->date1;
    $this->haf_date2=$this->date2;
  }
  public function updatingSearch()
  {
    $this->resetPage();
  }
  public function updatingSearch2()
  {
    $this->resetPage();
  }

  public function render()
    {
            return view('livewire.haf.rep-haf',[
                'HafTable'=>DB::connection(Auth()->user()->company)->table('hafitha_view')
                    ->whereBetween('hafitha_date',[$this->haf_date1,$this->haf_date2])
                    ->where('hafitha_state',$this->RepRadio)
                    ->where(function ($query) {
                        $query->where('bank_name', 'like', '%' . $this->search . '%')
                            ->orWhere('hafitha_date', 'like', '%'.$this->search.'%');})
                    ->paginate(15),
                 'HafTranTable'=>DB::connection(Auth()->user()->company)->table('hafitha_tran_view')
                   ->where('hafitha_no',$this->Haf_no)
                   ->where(function ($query) {
                     $query->where('name', 'like', '%' . $this->search2 . '%')
                       ->orWhere('acc', 'like', '%'.$this->search2.'%')
                       ->orWhere('no', 'like', '%'.$this->search2.'%');})
                   ->paginate(15, ['*'], 'tranPage'),
            ]);
    }
}
