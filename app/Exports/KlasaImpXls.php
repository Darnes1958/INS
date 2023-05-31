<?php

namespace App\Exports;

use App\Models\Customers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KlasaImpXls implements FromCollection, WithHeadings, WithEvents,WithColumnWidths,WithColumnFormatting, WithTitle,WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
  public $date1;
  public $date2;

  public $val;
  public $rowcount;
  public function __construct(string $date1,string $date2)
  {
    $this->date1 = $date1  ;
    $this->date2=$date2;


  }
  public function map($TransTableImp): array
  {
    return [
      $TransTableImp->who_name,
      $TransTableImp->type_name,
      $TransTableImp->val,

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
      ['نوع الإيصال','طريقة الدفع','الإجمالي'],
    ];
  }
  public function columnWidths(): array
  {
    return [
      'A' => 30,
      'B' => 20,
      'C' => 16,


    ];
  }
  public function registerEvents(): array
  {
    return [

      AfterSheet::class => function(AfterSheet $event)  {
        $event->sheet
          ->getStyle('A8:C8')
          ->getFill()
          ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
          ->getStartColor()
          ->setARGB('E8E1E1');

        $event->sheet->setCellValue('A6', 'خلاصة إيصالات القبض من  '.$this->date1.' إلي '.$this->date2);
        $event->sheet->setCellValue('B'.$this->rowcount+9, 'الإجمالـــــــــي');
        $event->sheet->setCellValue('C'.$this->rowcount+9, $this->val);
        $event->sheet->getDelegate()->setRightToLeft(true);
        $event->sheet
          ->getStyle('A'.($this->rowcount+9).':C'.$this->rowcount+9)
          ->getFill()
          ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
          ->getStartColor()
          ->setARGB('E8E1E1');

      },
    ];
  }
  public function columnFormats(): array
  {
    return [
      'C' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,



    ];
  }
  public function styles(Worksheet $sheet)
  {

    return [

      'A1'  => ['font' => ['size' => 18]],
      'A2'  => ['font' => ['size' => 16]],
      'A6'  => ['font' => ['bold' => true]],
      'B'.$this->rowcount+9  => ['font' => ['bold' => true]],
      'C'.$this->rowcount+9  => ['font' => ['bold' => true]],

      'C'.$this->rowcount+9 => ['numberFormat' => ['formatCode' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1]],



    ];


  }
  public function title(): string
  {
    return 'إيصالات القبض ' ;
  }
    public function collection()
    {
      $TransTableImp=DB::connection(Auth()->user()->company)->table('trans')
      ->join('price_type','trans.tran_type','=','price_type.type_no')
      ->join('tran_who','trans.tran_who','=','tran_who.who_no')
      ->where('imp_exp',1)
      ->whereBetween('tran_date',[$this->date1,$this->date2])
      ->selectRaw('who_name,type_name,sum(val) as val')
      ->groupBy('imp_exp','who_no','who_name','type_no','type_name')->orderBy('who_no')->get();
      $tot=DB::connection(Auth()->user()->company)->table('trans')

        ->where('imp_exp',1)
        ->whereBetween('tran_date',[$this->date1,$this->date2])
        ->selectRaw('sum(val) as val')
        ->first();
      $this->val=$tot->val;
      $this->rowcount=$TransTableImp->count();
      return $TransTableImp;
    }
}
