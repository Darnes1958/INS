<?php

namespace App\Exports;

use App\Models\Customers;
use App\Models\stores\RepMakzoon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class RepMakXls  implements FromCollection,WithMapping, WithHeadings,
                            WithEvents,WithColumnWidths,WithStyles,WithColumnFormatting
{

  public $place_type;
  public $place_no;
  public $WithZero;
  public $rowcount;
  public function __construct(int $place_type,int $place_no,int $WithZero)
  {
    $this->place_type = $place_type  ;
    $this->place_no=$place_no;
    $this->WithZero = $WithZero;

  }
  /**
   * @var RepMakzoon $RepMakzoon
   */
  public function map($RepMakzoon): array
{
  return [
    $RepMakzoon->type_name,
    $RepMakzoon->item_no,
    $RepMakzoon->item_name,
    $RepMakzoon->price_cost,
    $RepMakzoon->price_sell,
    $RepMakzoon->place_name,
    $RepMakzoon->place_ras,
    $RepMakzoon->raseed,
  ];
}
  public function registerEvents(): array
  {
    return [

      AfterSheet::class => function(AfterSheet $event)  {
        $event->sheet
          ->getStyle('A8:H8')
          ->getFill()
          ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
          ->getStartColor()
          ->setARGB('E8E1E1');

        $event->sheet->setCellValue('D6', 'تقرير بالمخزون بتاريخ  '.date('Y-m-d'));

        $event->sheet
          ->getStyle('A'.($this->rowcount+9).':J'.$this->rowcount+9)
          ->getFill()
          ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
          ->getStartColor()
          ->setARGB('E8E1E1');
        $event->sheet->getDelegate()->setRightToLeft(true);

      },
    ];
  }

  public function columnFormats(): array
  {
    return [
      'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
      'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,

    ];
  }
  public function styles(Worksheet $sheet)
  {

       return [
         8    => ['font' => ['bold' => true]],
         'A1'  => ['font' => ['size' => 18]],
         'A2'  => ['font' => ['size' => 16]],
         'D6'  => ['font' => ['bold' => true]],

         'B'.$this->rowcount+9  => ['font' => ['bold' => true]],
         'E'.$this->rowcount+9  => ['font' => ['bold' => true]],
         'H'.$this->rowcount+9  => ['font' => ['bold' => true]],
         'I'.$this->rowcount+9  => ['font' => ['bold' => true]],
         'E'.$this->rowcount+9 => ['numberFormat' => ['formatCode' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1]],
         'H'.$this->rowcount+9 => ['numberFormat' => ['formatCode' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1]],
         'I'.$this->rowcount+9 => ['numberFormat' => ['formatCode' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1]],
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
        ['التصنيف','رقم الصنف','اسم الصنف','سعر التكلفة','سعر البيع نقدا','المخزن / الصالة','رصيد المخزن/الصالة','الرصيد الكلي'],
      ];
  }

  public function columnWidths(): array
  {
    return [
      'A' => 20,
      'B' => 10,
      'C' => 36,
      'D' => 12,
      'E' => 12,
      'F' => 20,
      'G' => 16,
      'H' => 12,
    ];
  }
  /**
   * @return \Illuminate\Support\Collection
   */
    public function collection()
    {

      $data=RepMakzoon::
       when($this->place_no!=0,function ($q) {
        return $q->where('place_no','=', $this->place_no) ;     })
       ->when($this->place_no!=0,function ($q) {
        return $q->where('place_type','=', $this->place_type) ;     })

       ->when($this->WithZero==0 , function($q){
        return $q->where('raseed','!=',0);
        })
       ->when($this->WithZero==0 , function($q){
          return $q->where('place_ras','!=',0);
        })
       ->orderBy('item_type','asc')
       ->orderBy('item_no','asc')
       ->get();

        $this->rowcount=$data->count();

        return $data;
    }
}
