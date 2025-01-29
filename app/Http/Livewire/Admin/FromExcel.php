<?php

namespace App\Http\Livewire\Admin;

use App\Http\Controllers\ExcelController;
use App\Imports\FromExcelImport;
use App\Imports\FromExcelImportS;
use App\Imports\FromExcelImportT;
use App\Models\Dateofexcel;
use App\Models\excel\FromExcelModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;


class FromExcel extends Component
{
  use WithFileUploads;
  use WithPagination;
    protected $paginationTheme = 'bootstrap';
  public $file;
  public $filename;
  public $Show=false;
  public $ShowDo=false;
  public $TajNo=0;
  public $BankRadio='wahda';


  protected $listeners = ['show'];

  public function show($show){

    $this->Show=$show;
  }
  public function Delete($id){
      Dateofexcel::find($id)->delete();
      $this->render();
  }
  public function Do(){

    if ($this->BankRadio=='wahda')
      Excel::import(new FromExcelImport, $this->filename);
    if ($this->BankRadio=='tejary')
      Excel::import(new FromExcelImportT, $this->filename);
    if ($this->BankRadio=='sahary')
      Excel::import(new FromExcelImportS, $this->filename);
    if ($this->BankRadio=='jomhoria')
      Excel::import(new FromExcelImportS, $this->filename);

    FromExcelModel::on(Auth()->user()->company)->update([
      'hafitha_tajmeehy'=>$this->TajNo,
    ]);

    if (Auth::user()->company=='Boshlak')
    {
      FromExcelModel::on(Auth()->user()->company)->
      update([ 'ksm' => DB::raw('ksm-(.05*ksm)') ]);

    }
    $beginDate=FromExcelModel::min('ksm_date');
    $endDate=FromExcelModel::max('ksm_date');
    $res=Dateofexcel::where('taj_id',$this->TajNo)
      ->whereBetween('date_begin',[$beginDate,$endDate])->first();
    $res2=Dateofexcel::where('taj_id',$this->TajNo)
      ->whereBetween('date_end',[$beginDate,$endDate])->first();
    if ($res || $res2){
      FromExcelModel::truncate();
      $this->dispatchBrowserEvent('mmsg', 'يوجد تداخل في تاريخ الحافظة مع حافظة سابقة لنفس المصرف ');
      return false;

    }

    Dateofexcel::create([
      'taj_id'=>$this->TajNo,
      'date_begin'=>FromExcelModel::min('ksm_date'),
      'date_end'=>FromExcelModel::max('ksm_date'),
        ]
    );

    return redirect('/home')->with('success', 'All good!');

  }
  public function Take(){
      FromExcelModel::on(Auth()->user()->company)->truncate();
      $this->filename='c:\Excel\\'.$this->BankRadio.'\\'.Auth()->user()->company.'.xlsx';

      $this->ShowDo=true;

  }

    public function render()
    {
      $data= Dateofexcel::where('taj_id',$this->TajNo)->orderBy('created_at','desc')->paginate(5);
        return view('livewire.admin.from-excel',[
          'data'=>$data,
        ]);
    }
}
