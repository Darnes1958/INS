<?php

namespace App\Exports;

use App\Http\Livewire\Buy\BuySelect;
use App\Models\buy\buys;
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

class KlasaBuyXls implements FromCollection, WithHeadings, WithEvents,WithColumnWidths,WithColumnFormatting, WithTitle,WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
  public $date1;
  public $date2;
  public $tot1;
  public $ksm;
  public $tot;
  public $cash;
  public $not_cash;
  public $rowcount;
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
  public function columnWidths(): array
{
  return [
    'A' => 30,
    'B' => 20,
    'C' => 16,
    'D' => 16,
    'E' => 16,
    'F' => 16,
    'G' => 16,

  ];
}
  public function registerEvents(): array
  {
    return [

      AfterSheet::class => function(AfterSheet $event)  {
        $event->sheet
          ->getStyle('A8:G8')
          ->getFill()
          ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
          ->getStartColor()
          ->setARGB('E8E1E1');

        $event->sheet->setCellValue('C6', 'خلاصة المشتريات من  '.$this->date1.' إلي '.$this->date2);
        $event->sheet->setCellValue('B'.$this->rowcount+9, 'الإجمالـــــــــي');
        $event->sheet->setCellValue('C'.$this->rowcount+9, $this->tot1);
        $event->sheet->setCellValue('D'.$this->rowcount+9, $this->ksm);
        $event->sheet->setCellValue('E'.$this->rowcount+9, $this->tot);
        $event->sheet->setCellValue('F'.$this->rowcount+9, $this->cash);
        $event->sheet->setCellValue('G'.$this->rowcount+9, $this->not_cash);
        $event->sheet->getDelegate()->setRightToLeft(true);
        $event->sheet
          ->getStyle('A'.($this->rowcount+9).':G'.$this->rowcount+9)
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
      'C' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
      'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
      'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
      'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
      'G' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,


    ];
  }
  public function styles(Worksheet $sheet)
  {

    return [

      'A1'  => ['font' => ['size' => 18]],
      'A2'  => ['font' => ['size' => 16]],
      'C6'  => ['font' => ['bold' => true]],
      'B'.$this->rowcount+9  => ['font' => ['bold' => true]],
      'C'.$this->rowcount+9  => ['font' => ['bold' => true]],
      'D'.$this->rowcount+9  => ['font' => ['bold' => true]],
      'E'.$this->rowcount+9  => ['font' => ['bold' => true]],
      'F'.$this->rowcount+9  => ['font' => ['bold' => true]],
      'G'.$this->rowcount+9  => ['font' => ['bold' => true]],
      'C'.$this->rowcount+9 => ['numberFormat' => ['formatCode' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1]],
      'D'.$this->rowcount+9 => ['numberFormat' => ['formatCode' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1]],
      'E'.$this->rowcount+9 => ['numberFormat' => ['formatCode' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1]],
      'F'.$this->rowcount+9 => ['numberFormat' => ['formatCode' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1]],
      'G'.$this->rowcount+9 => ['numberFormat' => ['formatCode' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1]],



    ];


  }
  public function title(): string
  {
    return 'المشتريات ' ;
  }
    public function collection()
    {
      $BuyTable=buys::
        join('price_type','buys.price_type','=','price_type.type_no')
        ->join('stores_names','buys.place_no','=','stores_names.st_no')
        ->whereBetween('order_date',[$this->date1,$this->date2])
        ->selectRaw('st_name as place_name,type_name,
                                 sum(tot1) as tot1,sum(ksm) as ksm,sum(tot) as tot,sum(cash) as cash,sum(not_cash) as not_cash')
        ->groupBy('stores_names.st_no','st_name','type_no','type_name')->orderby('st_no')->get();
      $tot=buys::
        whereBetween('order_date',[$this->date1,$this->date2])
        ->selectRaw('sum(tot1) as tot1,sum(ksm) as ksm,sum(tot) as tot,sum(cash) as cash,sum(not_cash) as not_cash')
        ->first();

      $this->rowcount=$BuyTable->count();
      $this->tot1=$tot->tot1;

      $this->ksm=$tot->ksm;
      $this->tot=$tot->tot;
      $this->cash=$tot->cash;
      $this->not_cash=$tot->not_cash;
      return $BuyTable;//
    }
}
