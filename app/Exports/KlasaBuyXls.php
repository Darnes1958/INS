<?php

namespace App\Exports;

use App\Models\Customers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class KlasaBuyXls implements FromCollection, WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
  public $date1;
  public $date2;
  public function __construct(string $date1,string $date2)
  {
    $this->date1 = $date1  ;
    $this->date2=$date2;


  }
  public function map($BuyTable): array
  {
    return [
      $BuyTable->place_name,
      $BuyTable->type_name,
      $BuyTable->tot1,
      $BuyTable->ksm,
      $BuyTable->tot,
      $BuyTable->cash,
      $BuyTable->not_cash,

    ];
  }
  public function headings(): array
  {
    $cus=Customers::where('Company',Auth::user()->company)->first();
    return [
      [$cus->CompanyName],
      [$cus->CompanyNameSuffix],
      [' '],
      [''],
      [''],
      [''],
      [''],
      ['المخزن','طريقة الدفع','الإجمالي','الخصم','المطلوب','المدفوع','الباقي'],
    ];
  }
  public function registerEvents(): array
  {
    return [

      AfterSheet::class => function(AfterSheet $event)  {

        $event->sheet->getDelegate()->setRightToLeft(true);

      },
    ];
  }
    public function collection()
    {
      $BuyTable=DB::connection(Auth()->user()->company)->table('buys')
        ->join('price_type','buys.price_type','=','price_type.type_no')
        ->join('stores_names','buys.place_no','=','stores_names.st_no')
        ->whereBetween('order_date',[$this->date1,$this->date2])
        ->selectRaw('stores_names.st_no place_no,st_name as place_name,type_no,type_name,
                                 sum(tot1) as tot1,sum(ksm) as ksm,sum(tot) as tot,sum(cash) as cash,sum(not_cash) as not_cash')
        ->groupBy('stores_names.st_no','st_name','type_no','type_name')->get();
      return $BuyTable;//
    }
}
