<?php

namespace App\Http\Livewire\Masr;


use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class RepMas extends Component
{
    public $MasType;
    public $MasCenter;

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $date1;
    public $date2;
    public $mas_date1;
    public $mas_date2;
    public $RepRadio=1;

    public $search;
    public $DetailTable;
    public $CenterTable;

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
        $this->mas_date1 = $this->date1;
        $this->mas_date2 = $this->date2;
    }
    public function selectItem($MasType){

       $this->MasType=$MasType;
        }
    public function selectItem2($MasCenter){

        $this->MasCenter=$MasCenter;
    }

    public function render()
    {

        $this->DetailTable=DB::connection(Auth()->user()->company)->table('Masrofat')
        ->join('MasTypes','Masrofat.MasType','=','MasTypes.MasTypeNo')
        ->whereBetween('MasDate',[$this->mas_date1,$this->mas_date2])
        ->selectRaw('MasType,MasTypeName,sum(Val) as Val')
        ->groupBy('MasType','MasTypeName')->get();
        $this->CenterTable=DB::connection(Auth()->user()->company)->table('Masrofat')
        ->join('MasCenters','Masrofat.MasCenter','=','MasCenters.CenterNo')
        ->whereBetween('MasDate',[$this->mas_date1,$this->mas_date2])
        ->selectRaw('MasCenter,CenterName,sum(Val) as Val')
        ->groupBy('MasCenter','CenterName')->get();
        if ($this->RepRadio==1)
            return view('livewire.masr.rep-mas',[
                'RepTable'=>DB::connection(Auth()->user()->company)->table('MasView')
                    ->whereBetween('MasDate',[$this->mas_date1,$this->mas_date2])
                    ->where('MasType',$this->MasType)
                    ->where(function ($query) {
                        $query->where('DetailName', 'like', '%' . $this->search . '%')
                            ->orWhere('MasDate', 'like', '%'.$this->search.'%')
                            ->orWhere('CenterName', 'like', '%'.$this->search.'%');})

                    ->paginate(15),
              $this->DetailTable,$this->CenterTable

            ]);
        else
            return view('livewire.masr.rep-mas',[
                'RepTable'=>DB::connection(Auth()->user()->company)->table('MasView')
                    ->whereBetween('MasDate',[$this->mas_date1,$this->mas_date2])
                    ->where('MasCenter',$this->MasCenter)
                    ->where(function ($query) {
                        $query->where('DetailName', 'like', '%' . $this->search . '%')
                            ->orWhere('MasDate', 'like', '%'.$this->search.'%')
                            ->orWhere('CenterName', 'like', '%'.$this->search.'%');})

                    ->paginate(15),
                $this->DetailTable,$this->CenterTable


            ]);

    }
}
